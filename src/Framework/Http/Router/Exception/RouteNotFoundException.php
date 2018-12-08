<?php
namespace Framework\Http\Router\Exception;

use LogicException;

class RouteNotFoundException extends LogicException
{
  private $name;
  private $params;
  
  public function __construct($name, array $params, \Throwable $previous = null)
  {
    parent::__construct('RegexRoute ' . $name . ' not found', 0, $previous);
    $this->name = $name;
    $this->params = $params;
  }
  
  public function getName()
  {
    return $this->name;
  }
  
  public function getParams(): array
  {
    return $this->params;
  }
}