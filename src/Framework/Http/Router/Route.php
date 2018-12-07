<?php
namespace Framework\Http\Router;

use Psr\Http\Message\ServerRequestInterface;

interface Route
{
  public function match(ServerRequestInterface $request): ?Result;
  public function generate($name, array $params = []): ?string;
}
