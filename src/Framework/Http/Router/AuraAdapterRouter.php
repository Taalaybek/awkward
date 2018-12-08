<?php
namespace Framework\Http\Router;

use Throwable;
use Aura\Router\RouterContainer;
use Psr\Http\Message\ServerRequestInterface;
use Framework\Http\Router\Exception\RouteNotFoundException;
use Framework\Http\Router\Exception\RequestNotMatchedException;

class AuraAdapterRouter implements Router
{
  private $aura;
  public function __construct(RouterContainer $aura)
  {
    $this->aura = $aura;
  }
  
  /**
   * @param ServerRequestInterface $request
   * @return Result|null
   */
  public function match(ServerRequestInterface $request): Result
  {
    $matcher = $this->aura->getMatcher();
    
    if ($route = $matcher->match($request)) {
      return new Result($route->name, $route->handler, $route->attributes);
    }
    throw new RequestNotMatchedException($request);
  }
  
  public function generate($name, array $params = []): string
  {
    $generator = $this->aura->getGenerator();
    try {
      return $generator->generate($name, $params);
    } catch (Throwable $e) {
      throw new RouteNotFoundException($name, $params, $e);
    }
  }
}
