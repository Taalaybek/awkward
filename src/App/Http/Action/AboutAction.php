<?php
namespace App\Http\Action;

use Zend\Diactoros\Response\HtmlResponse;

final class AboutAction
{
  public final function __invoke()
  {
    return new HtmlResponse('I am Simple site');
  }
}