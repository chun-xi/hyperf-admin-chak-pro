<?php
declare (strict_types=1);

namespace App\Controller\Admin;

use App\Constant\Admin\Session;
use App\Service\Admin\_UserServiceInterface;
use App\Utils\AddressUtil;
use App\Utils\PacketUtil;
use App\Utils\StringUtil;
use EasySwoole\VerifyCode\Conf;
use EasySwoole\VerifyCode\VerifyCode;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\PostMapping;
use Psr\Http\Message\ResponseInterface;

/**
 * 用户验证控制器
 * @Controller(prefix="/admin/auth")
 * Class AuthController
 * @package App\Controller\Admin
 */
class AuthController extends BaseController
{

    /**
     * @Inject()
     * @var _UserServiceInterface
     */
    protected _UserServiceInterface $userService;

    /**
     * 账号登录
     * @PostMapping(path="login")
     * @return ResponseInterface
     */
    public function login(): ResponseInterface
    {
        $map = (array)$this->post();

        $this->validator($map, [
            'user' => 'required',
            'pass' => 'required|between:6,20'
        ], [
            'user.required' => '用户名不能为空',
            'pass.required' => '密码不能为空',
            'pass.between' => '密码错误'
        ]);

        $login = $this->userService->login($map['user'], $map['pass'], AddressUtil::getAddress($this->request));
        return $this->getPrivacyJson(200, 'success', $login);
    }


    /**
     * 登录验证码
     * @GetMapping(path="code")
     * @return ResponseInterface
     */
    public function code(): ResponseInterface
    {
        $this->validator((array)$this->post(), [
            'rand' => 'required'
        ], [
            'rand.required' => '随机数据不能为空'
        ]);

        $config = (new Conf())->setUseCurve()->setUseNoise();
        $code = new VerifyCode($config);
        $result = $code->DrawCode();

        //将验证码存到session
        $this->session->set(Session::IMAGE_CODE, $result->getImageCode());

        return $this->getPrivacyJson(200, null, $result->getImageBase64());
    }
}