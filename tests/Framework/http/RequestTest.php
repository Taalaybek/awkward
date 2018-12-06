<?php
namespace Tests\Framework\Http;

use PHPUnit\Framework\TestCase;
use Zend\Diactoros\ServerRequest as Request;

class RequestTest extends TestCase
{
    public function testEmpty()
    {
        $request = new Request();
        self::assertEquals([], $request->getQueryParams());
        self::assertNull($request->getParsedBody());
    }
  
    public function testQueryParams()
    {
      $request = (new Request())
        ->withQueryParams($name = ['name' => 'Alex']);
      self::assertEquals($name, $request->getQueryParams());
      self::assertNull($request->getParsedBody());
    }
    
    public function testParsedBody()
    {
      $request = (new Request())
        ->withParsedBody($data = ['title' => 'Title']);
      self::assertEquals($data, $request->getParsedBody());
    }
}
