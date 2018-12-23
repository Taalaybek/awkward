<?php
namespace App\Http\Action;

use Psr\Http\Message\ServerRequestInterface;
use Zend\Diactoros\Response\EmptyResponse;
use Zend\Diactoros\Response\HtmlResponse;

class CabinetAction
{
  
  private $users;
  
  public function __construct(array $users)
  {
    $this->users = $users;
  }
  
  public function __invoke(ServerRequestInterface $request)
  {
    $password = $request->getServerParams()['PHP_AUTH_PW'] ?? null;
    $username = $request->getServerParams()['PHP_AUTH_USER'] ?? null;
    if (!empty($username) && !empty($password)) {
      foreach ($this->users as $name => $pass){
        if ($name == $username && $pass == $password) {
          return new HtmlResponse('I am logged in as ' . $username);
        }
      }
    }
    
    return new EmptyResponse(401, ['WWW-Authenticate' => 'Basic realm=Restricted area']);
  }
  
}
