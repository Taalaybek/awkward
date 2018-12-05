<?php
namespace Framework\Http;

class Request
{
    private $queryParams;
    private $parsedBody;

    public function __construct(array $queryParams = [], $parsedBody = null)
    {
        $this->queryParams = $queryParams;
        $this->parsedBody = $parsedBody;
    }

    public function getQueryParams(): array
    {
        return $this->queryParams;
    }

    public function setQueryParams(array $query): object
    {
        $new = clone $this;
        $new->queryParams = $query;
        return $new;
    }

    public function getParsedBody()
    {
        return $this->parsedBody;
    }

    public function setParsedBody($data): object
    {
        $new = clone $this;
        $new->parsedBody = $data;
        return $new;
    }
}