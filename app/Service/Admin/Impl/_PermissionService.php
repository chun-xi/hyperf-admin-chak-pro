<?php
declare (strict_types=1);

namespace App\Service\Admin\Impl;


use App\Constant\Admin\Session;
use App\Entity\RecordEntity;
use App\Model\Admin\_Permission;
use App\Service\Admin\_PermissionServiceInterface;
use App\Service\Admin\BaseService;
use App\Utils\CategoryUtil;
use Hyperf\Contract\SessionInterface;
use Hyperf\Di\Annotation\Inject;

class _PermissionService extends BaseService implements _PermissionServiceInterface
{

    /**
     * @Inject()
     * @var SessionInterface
     */
    protected SessionInterface $session;

    /**
     * @inheritDoc
     */
    public function getUserMenus(): array
    {
        $auth = $this->session->get(Session::AUTH);
        return CategoryUtil::generateTree($auth['permission']['menus'], 'id', 'pid', 'list');
    }


    /**
     * @return mixed
     */
    public function data()
    {
        $recordEntity = new RecordEntity(_Permission::class);
        return $this->getRecords($recordEntity);
    }
}