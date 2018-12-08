<?php
namespace App\Http\Action\Blog;


use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response\HtmlResponse;
use Zend\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ServerRequestInterface;

final class BlogShowAction
{
  public final function __invoke(ServerRequestInterface $request): ResponseInterface
  {
    $id = $request->getAttribute('id');
    if ($id > 2) {
      return new HtmlResponse('Undefined page', 404);
    }
    return new JsonResponse(['id' => $id, 'title' => 'Post #' . $id]);
  }
}