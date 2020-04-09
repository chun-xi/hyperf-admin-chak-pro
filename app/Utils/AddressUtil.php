<?php
declare(strict_types=1);

namespace App\Utils;


use Hyperf\Guzzle\ClientFactory;
use Hyperf\HttpServer\Contract\RequestInterface;

/**
 * Class AddressUtil
 * @package App\Utils
 */
class AddressUtil
{

    /**
     * 获取客户端地址
     * @param RequestInterface $request
     * @return array|string|null
     */
    public static function getAddress(RequestInterface $request)
    {
        $s = '127.0.0.1';

        $ip = $request->server('remote_addr');
        if ($ip != '' && $ip != $s) {
            return $ip;
        }

        $list = ['x-real-ip', 'x-forwarded-for', 'remote-host'];

        foreach ($list as $item) {
            $ip = $request->header($item);
            if ($ip != '' && $ip != $s) {
                return $ip;
            }
        }

        return '';
    }

    /**
     * 获取IP归属地
     * @param string $ip
     * @return string
     */
    public static function getLocation(string $ip): string
    {

        $container = \Hyperf\Utils\ApplicationContext::getContainer();
        /**
         * @var $httpClientFactory ClientFactory
         */
        $httpClientFactory = $container->get(ClientFactory::class);

        $contents = $httpClientFactory->create()->get("https://api.ip138.com/query/?ip={$ip}&token=866de101d7c3b422a303c6d44304aef7")->getBody()->getContents();
        $body = json_decode($contents, true);

        $address = '';

        for ($i = 0; $i < 4; $i++) {
            $address .= $body['data'][$i];
        }

        return $address;
    }
}