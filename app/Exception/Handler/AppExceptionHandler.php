<?php

declare(strict_types=1);

namespace App\Exception\Handler;

use App\Exception\AdminException;
use App\Utils\PacketUtil;
use Hyperf\Contract\StdoutLoggerInterface;
use Hyperf\Di\Annotation\Inject;
use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Hyperf\Logger\LoggerFactory;
use Hyperf\Utils\Codec\Json;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use Throwable;

class AppExceptionHandler extends ExceptionHandler
{
    /**
     * @Inject()
     * @var StdoutLoggerInterface
     */
    protected StdoutLoggerInterface $stdoutLogger;

    /**
     * @var LoggerInterface
     */
    protected LoggerInterface $logger;


    /**
     * AppExceptionHandler constructor.
     * @param LoggerFactory $loggerFactory
     */
    public function __construct(LoggerFactory $loggerFactory)
    {
        $this->logger = $loggerFactory->get('log', 'error');
    }


    /**
     * 获取错误异常json
     * @param Throwable $throwable
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    private function getErrorJson(Throwable $throwable, ResponseInterface $response): ResponseInterface
    {
        return $response->withStatus(200)->withHeader("content-type", "application/json;chartset=uft-8")->withBody(new SwooleStream(Json::encode(['code' => $throwable->getCode(), 'msg' => $throwable->getMessage()])));
    }

    /**
     * 获取加密后的异常json
     * @param Throwable $throwable
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    private function getErrorPrivacyJson(Throwable $throwable, ResponseInterface $response): ResponseInterface
    {
        $pack = PacketUtil::pack(Json::encode(['code' => $throwable->getCode(), 'msg' => $throwable->getMessage()]));
        return $response->withStatus(200)->withHeader("content-type", "application/json;chartset=uft-8")->withBody(new SwooleStream(Json::encode($pack)));
    }

    /**
     * 异常处理类
     * @param Throwable $throwable
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public function handle(Throwable $throwable, ResponseInterface $response): ResponseInterface
    {
        if ($throwable instanceof AdminException) {
            return $this->getErrorPrivacyJson($throwable, $response);
        }
        /*    if ((bool)env('DAEMONIZE')) {
                $this->logger->error(sprintf('%s[%s] in %s', $throwable->getMessage(), $throwable->getLine(), $throwable->getFile()));
            } else {
                $this->stdoutLogger->error(sprintf('%s[%s] in %s', $throwable->getMessage(), $throwable->getLine(), $throwable->getFile()));
            }*/
        //$this->stdoutLogger->error($throwable->getTraceAsString());
        return $this->getErrorJson($throwable, $response);
    }

    public function isValid(Throwable $throwable): bool
    {
        return true;
    }
}
