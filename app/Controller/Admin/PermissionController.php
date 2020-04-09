<?php
declare (strict_types=1);

namespace App\Controller\Admin;

use App\Service\Admin\_PermissionServiceInterface;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\Middleware;
use Hyperf\HttpServer\Annotation\PostMapping;
use Psr\Http\Message\ResponseInterface;
use App\Middleware\Admin\AuthMiddleware;

/**
 * Class PermissionController
 * @package App\Controller\Admin
 * @Controller(prefix="/admin/permission")
 * @Middleware(AuthMiddleware::class)
 */
class PermissionController extends BaseController
{

    /**
     * @Inject()
     * @var _PermissionServiceInterface
     */
    protected _PermissionServiceInterface $permissionService;

    /**
     * 获取用户左侧菜单列表
     * @PostMapping(path="getUserMenus")
     * @return ResponseInterface
     */
    public function getUserMenus(): ResponseInterface
    {
        return $this->getPrivacyJson(200, null, $this->permissionService->getUserMenus());
    }


    /**
     * 获取权限数据列表
     * @PostMapping(path="data")
     * @return ResponseInterface
     */
    public function data(): ResponseInterface
    {
        $data = $this->permissionService->data();
        return $this->getPrivacyJson(200, null, $data, ['count' => count($data)]);
    }
}