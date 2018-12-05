<?php
namespace Tests\Framework\Http;

use Framework\Http\Request;
use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{
    public function testEmpty()
    {
        $request = new Request();
        $this->assertEquals([], $request->getQueryParams());
        $this->assertNull($request->getParsedBody());
    }

    public function testGetQueryParams()
    {
        
        $request = new Request(
            $data = [ 'name' => 'Alex' ]
        );
        $this->assertEquals($data, $request->getQueryParams());
    }

    public function getParsedBdoy()
    {
        $request = new Request(
            $data = ['title' => 'Title']
        );
        $this->assertEquals($data, $request->getParsedBdoy());
    }
}
