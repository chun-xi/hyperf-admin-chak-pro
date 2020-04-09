<?php
declare (strict_types=1);

namespace App\Controller\Admin;


use App\Exception\AdminException;
use App\Utils\PacketUtil;
use Hyperf\Contract\SessionInterface;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Hyperf\Validation\Contract\ValidatorFactoryInterface;
use Psr\Container\ContainerInterface;

/**
 * Class BaseController
 * @package App\Controller\Admin
 */
abstract class BaseController
{
    /**
     * @Inject()
     * @var ContainerInterface
     */
    protected ContainerInterface $container;

    /**
     * @Inject()
     * @var RequestInterface
     */
    protected RequestInterface $request;

    /**
     * @Inject()
     * @var ResponseInterface
     */
    protected ResponseInterface $response;

    /**
     * @Inject()
     * @var ValidatorFactoryInterface
     */
    protected ValidatorFactoryInterface $validationFactory;


    /**
     * @Inject()
     * @var SessionInterface
     */
    protected SessionInterface $session;


    /**
     * 获取加密post数据
     * @param string|null $key
     * @param null $default
     * @return array|mixed|null
     */
    protected function post(?string $key = null, $default = null)
    {
        $post = (array)$this->request->post();
        $map = PacketUtil::unpack($post);
        if ($key == null) {
            return $map;
        }
        return isset($map[$key]) ? $map[$key] : $default;
    }

    /**
     * 获取渲染json对象
     * @param int $code
     * @param string $message
     * @param mixed $data
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function getJson(int $code, string $message = null, $data = null, array $more = null): \Psr\Http\Message\ResponseInterface
    {
        $json = ['code' => $code];

        if ($message != null) {
            $json['msg'] = $message;
        }

        if ($data != null) {
            $json['data'] = $data;
        }

        if ($more != null) {
            $json = array_merge($json, $more);
        }

        return $this->response->json($json);
    }

    /**
     * 获取私有的json对象
     * @param int $code
     * @param string $message
     * @param mixed $data
     * @param array|null $more
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function getPrivacyJson(int $code, string $message = null, $data = null, array $more = null): \Psr\Http\Message\ResponseInterface
    {
        $json = ['code' => $code];

        if ($message != null) {
            $json['msg'] = $message;
        }

        if ($data != null) {
            $json['data'] = $data;
        }

        if ($more != null) {
            $json = array_merge($json, $more);
        }

        $pack = PacketUtil::pack(json_encode($json));
        return $this->response->json($pack);
    }


    /**
     * @param array $data 验证数据
     * @param array $rules 验证规则
     * @param array $message 错误消息
     * @throws AdminException
     */
    protected function validator(array $data, array $rules, array $message): void
    {
        $validator = $this->validationFactory->make($data, $rules, $message);
        if ($validator->fails()) {
            throw new AdminException($validator->errors()->first(), 0);
        }
    }
}