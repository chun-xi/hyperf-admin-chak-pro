<?php
declare(strict_types=1);

namespace App\Utils;


use Hyperf\Utils\ApplicationContext;

/**
 * Class ApplicationUtil
 * @package App\Utils
 */
class ApplicationUtil
{
    /**
     * @param string $classId
     * @return mixed
     */
    public static function getApplicationContext(string $classId)
    {
        $container = ApplicationContext::getContainer();
        return $container->get($classId);
    }
}