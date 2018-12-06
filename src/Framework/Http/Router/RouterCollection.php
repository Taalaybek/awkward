<?php
namespace Framework\Http\Router;

class RouterCollection
{
  private $routes = [];
  
  public function get($name, $pattern, $handler, array $tokens = [])
  {
    $this->routes[] = [
      'name' => $name,
      'pattern' => $pattern,
      'handler' => $handler,
      'methods' => ['GET'],
      'tokens' => $tokens,
    ];
  }
  
  /**
   * @return array
   */
  public function getRoutes(): array
  {
    return $this->routes;
  }
}