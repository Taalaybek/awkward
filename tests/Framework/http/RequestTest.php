<?php
namespace Tests\Framework\Http;

use Framework\Http\Request;
use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{
    public function testEmpty()
    {
        $_GET = [];
        $_POST = [];
        $request = new Request();
        $this->assertEquals([], $request->getQueryParams());
        $this->assertNull($request->getParsedBody());
    }

    public function testGetQueryParams()
    {
        $_GET = $data = [
            'name' => 'Alex'
        ];
        $_POST = [];
        $request = new Request();
        $this->assertEquals($data, $request->getQueryParams());
    }
}

