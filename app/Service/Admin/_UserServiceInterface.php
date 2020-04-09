<?php
declare (strict_types=1);

namespace App\Service\Admin;

/**
 * 用户接口
 * Interface _UserServiceInterface
 * @package App\Service
 */
interface _UserServiceInterface
{
    /**
     * 登录
     * @param string $user
     * @param string $pass
     * @param string $address
     * @return bool
     */
    public function login(string $user, string $pass, string $address): array;


    /**
     * 通过ID获取用户的权限
     * @param int $userId
     * @return array
     */
    public function getUserPermissions(int $userId): array;
}