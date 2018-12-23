<?php
namespace App\Http\Action;

use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\EmptyResponse;
use Zend\Diactoros\Response\HtmlResponse;

class CabinetAction
{
  public function __invoke(ServerRequestInterface $request)
  {
    $password = $request->getServerParams()['PHP_AUTH_PW'] ?? null;
    $username = $request->getServerParams()['PHP_AUTH_USER'] ?? null;
    
    if ($password === 'qwerty' && $username === 'admin') {
      return new HtmlResponse('I am logged in as ' . $username);
    }
    
    return new EmptyResponse(401, ['WWW-Authenticate' => 'Basic realm=Restricted area']);
  }
  
}
