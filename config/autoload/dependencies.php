<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://doc.hyperf.io
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf-cloud/hyperf/blob/master/LICENSE
 */

return [
    #--------------------------------------后台服务关系绑定-------------------------------------
    \App\Service\Admin\_UserServiceInterface::class => \App\Service\Admin\Impl\_UserService::class,  //用户服务
    \App\Service\Admin\_PermissionServiceInterface::class => \App\Service\Admin\Impl\_PermissionService::class //权限/菜单服务
];
