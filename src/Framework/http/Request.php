<?php
namespace Framework\Http;

class Request
{
  function getQueryParams(): array
  {
    if (isset($_GET)) {
      return $_GET;
    }
  }
  function getCookies(): array
  {
    if (isset($_COOKIE)) {
      return $_COOKIE;
    }
  }
}