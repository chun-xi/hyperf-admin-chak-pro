<?php
declare(strict_types=1);

namespace App\Utils;


use Hyperf\Logger\LoggerFactory;
use Hyperf\Utils\ApplicationContext;
use Psr\Log\LoggerInterface;

/**
 * Class LogUtil
 * @package App\Utils
 */
class LogUtil
{
    /**
     * @return LoggerInterface
     */
    public static function app()
    {
        $log = ApplicationContext::getContainer()->get(LoggerFactory::class)->get('log', 'default');
        return $log;
    }
}