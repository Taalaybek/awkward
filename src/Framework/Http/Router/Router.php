<?php
namespace Framework\Http\Router;

use Psr\Http\Message\ServerRequestInterface;
use Framework\Http\Router\Exception\RequestNotMatchedException;
use Framework\Http\Router\Exception\RouteNotFoundException;

interface Router
{
  
  /**
   * @param ServerRequestInterface $request
   * @throws RequestNotMatchedException
   * @return Result|null
   */
  public function match(ServerRequestInterface $request): Result;
  
  
  /**
   * @param $name
   * @param array $params
   * @throws RouteNotFoundException;
   * @return null|string
   */
  public function generate($name, array $params = []): string;
}