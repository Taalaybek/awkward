<?php
namespace App\Http\Action\Blog;

use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\Response\JsonResponse;

final class IndexAction
{
  public final function __invoke(): ResponseInterface
  {
    return new JsonResponse([
      ['id' => 1, 'title' => 'lorem ipsum', 'body' => 'some content'],
      ['id' => 2, 'title' => 'heredoc nowdoc', 'body' => 'lady milien paco rabban']
    ]);
  }
}