<?php

declare(strict_types=1);

namespace App\Middleware\Admin;

use App\Constant\Admin\Session;
use App\Exception\AdminException;
use Hyperf\Contract\SessionInterface;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Utils\Context;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * 权限验证中间件
 * Class AuthMiddleware
 * @package App\Middleware
 */
class AuthMiddleware implements MiddlewareInterface
{

    /**
     * @Inject()
     * @var SessionInterface
     */
    protected SessionInterface $session;


    /**
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $router = trim($request->getUri()->getPath(), "/");

        $token = $request->getHeader("token");

        if (!$token) {
            throw new AdminException("用户未登录", 1001);
        }

        $token = $token[0];

        $session = $this->session->get(Session::AUTH);

        if (!$session) {
            throw new AdminException("登录已失效", 1001);
        }

        $userId = $session['userId'];

        if (!$userId) {
            throw new AdminException("用户校验失败", 1001);
        }

        if ($token != $session['token']) {
            throw new AdminException("登录异常", 1001);
        }

        if (!array_key_exists($router, $session['permission']['permissions'])) {
            throw new AdminException("您还没有权限访问或该功能已停用");
        }
        $request->userId = $userId;
        Context::set(ServerRequestInterface::class, $request);
        return $handler->handle($request);
    }
}