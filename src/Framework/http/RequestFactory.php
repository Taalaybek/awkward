<?php
namespace Framework\Http;

use Framework\Http\Request;

final class RequestFactory
{
    public static function fromGlobals(
        array $query = null,
        array $body = null
    )
    {
        return (new Request)
            ->setQueryParams($query ?: $_GET)
            ->setParsedBody($body ?: $_POST);
    }
}
