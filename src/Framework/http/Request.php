<?php
namespace Framework\Http;

class Request
{
  function getQueryParams(): array
  {
      return $_GET;
  }
  function getParsedBody()
  {
      return $_POST ?: null;
  }
}