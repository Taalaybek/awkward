<?php
namespace Framework\Http\Router;

final class ActionResolver
{
  public final function handler($handler)
  {
    return is_string($handler) ? new $handler(): $handler;
  }
}