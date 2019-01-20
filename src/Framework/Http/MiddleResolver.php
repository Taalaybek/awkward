<?php
namespace Framework\Http;

final class MiddleResolver
{
  public final function resolve($handler)
  {
    return is_string($handler) ? new $handler(): $handler;
  }
}