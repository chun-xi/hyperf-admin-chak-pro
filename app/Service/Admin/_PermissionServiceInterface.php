<?php
declare (strict_types=1);

namespace App\Service\Admin;


/**
 * Interface _PermissionServiceInterface
 * @package App\Service\Admin
 */
interface _PermissionServiceInterface
{
    /**
     * 通过session获取用户菜单权限
     * @return array
     */
    public function getUserMenus(): array;


    /**
     * 获取数据列表
     * @return mixed
     */
    public function data();
}