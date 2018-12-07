<?php
namespace Framework\Http\Router;

class RouteCollection
{
  private $routes = [];
  
  public function addRoute(Route $route): void
  {
    $this->routes[] = $route;
  }
  
  public function add($name, $pattern, $handler, array $methods, array $tokens = [])
  {
    $this->addRoute(new RegexRoute($name, $pattern, $handler, $methods, $tokens));
  }
  
  public function any($name, $pattern, $handler, array $tokens = [])
  {
    $this->addRoute(new RegexRoute($name, $pattern, $handler, [], $tokens));
  }
  
  public function get($name, $pattern, $handler, array $tokens = [])
  {
    $this->addRoute(new RegexRoute($name, $pattern, $handler, ['GET'], $tokens));
  }
  
  public function post($name, $pattern, $handler, array $tokens = [])
  {
    $this->addRoute(new RegexRoute($name, $pattern, $handler, ['POST'], $tokens));
  }
  
  public function delete($name, $pattern, $handler, array $tokens = [])
  {
    $this->addRoute(new RegexRoute($name, $pattern, $handler, ['DELETE'], $tokens));
  }
  
  public function getRoutes(): array
  {
    return $this->routes;
  }
}