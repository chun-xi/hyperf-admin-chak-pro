<?php
declare (strict_types=1);

namespace App\Controller\Admin;

use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Psr\Http\Message\ResponseInterface;

/**
 * Class IndexController
 * @package App\Controller\Admin
 * @Controller(prefix="/admin")
 */
class IndexController extends BaseController
{
    /**
     * @GetMapping(path="/admin")
     */
    public function index(): ResponseInterface
    {
        return $this->response->redirect('/admin/index.html');
    }
}