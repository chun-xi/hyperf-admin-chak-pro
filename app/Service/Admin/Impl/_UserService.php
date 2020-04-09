<?php
declare (strict_types=1);

namespace App\Service\Admin\Impl;


use App\Constant\Admin\Session;
use App\Exception\AdminException;
use App\Model\Admin\_User;
use App\Service\Admin\_UserServiceInterface;
use App\Utils\CategoryUtil;
use App\Utils\DateUtil;
use App\Utils\StringUtil;
use Hyperf\Contract\SessionInterface;
use Hyperf\Database\Model\Relations\Relation;
use Hyperf\Di\Annotation\Inject;

/**
 * Class _UserService
 * @package App\Service\Impl
 */
class _UserService implements _UserServiceInterface
{

    /**
     * @Inject()
     * @var SessionInterface
     */
    protected SessionInterface $session;


    /**
     * @inheritDoc
     */
    public function login(string $user, string $pass, string $address): array
    {
        $user = _User::query()->where("user", $user)->first();

        if (!$user) {
            throw new AdminException("未找到该账号");
        }

        if ($user->pass != StringUtil::generatePassword($pass, $user->salt)) {
            throw new AdminException("密码错误");
        }

        if ($user->status != 1) {
            throw new AdminException("账号已被禁用");
        }

        //获取权限
        $userPermissions = $this->getUserPermissions($user->id);

        print_r($userPermissions);

        if (count($userPermissions['permissions']) == 0 || count($userPermissions['menus']) == 0) {
            throw new AdminException("你的权限为空，无法正常登录");
        }

        $now = DateUtil::current();

        $user->address = $address;
        $user->login_date = $now;
        $user->save();

        $token = strtoupper(StringUtil::generateRandStr(16));

        $data = ['token' => $token, 'permission' => $userPermissions, 'userId' => $user->id];

        $this->session->set(Session::AUTH, $data);

        return $data;
    }

    /**
     * @inheritDoc
     */
    public function getUserPermissions(int $userId): array
    {
        $user = _User::with(['roles' => function (Relation $relation) {
            $relation->with(['permissions' => function (Relation $relation) {
                $relation->with(['dicts'])->where("status", 1)->orderBy("rank", "asc");
            }])->where("status", 1);
        }])->find($userId);

        $permissions = [];
        $menus = [];
        $dicts = [];

        foreach ($user->roles as $role) {

            foreach ($role->permissions as $permission) {
                //获取权限/菜单
                if ($permission->type == 1) {
                    $permissions[trim($permission->path, '/')] = $permission->id;
                } else {
                    $menus[] = [
                        'id' => $permission->id,
                        'title' => $permission->name,
                        'name' => $permission->path,
                        'icon' => $permission->face,
                        'pid' => $permission->pid
                    ];
                }

                //获取字典权限
                foreach ($permission->dicts as $dict) {
                    $dicts[$dict->code] = true;
                }
            }
        }

        return ['permissions' => $permissions, 'menus' => CategoryUtil::generateTree($menus, 'id', 'pid', 'list'), 'dicts' => $dicts];
    }
}