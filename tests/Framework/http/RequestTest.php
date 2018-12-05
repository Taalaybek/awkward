<?php
namespace Tests\Framework\Http;

use Framework\Http\Request;
use PHPUnit\Framework\TestCase;
use Framework\Http\RequestFactory;

class RequestTest extends TestCase
{
    public function testEmpty()
    {
        $request = RequestFactory::fromGlobals(
            $queryParams = [ 'name' => 'Alex' ],
            $parsedBody = ['title' => 'Title']
        );
        $this->assertInstanceOf(Request::class, $request);
        $this->assertEquals($queryParams, $request->getQueryParams());
        $this->assertEquals($parsedBody, $request->getParsedBody());
    }
}
