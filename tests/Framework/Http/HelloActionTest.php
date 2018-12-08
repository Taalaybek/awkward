<?php
/**
 * Created by awkward.
 * User: user
 * Date: 12/8/2018
 * Time: 5:58 PM
 */

namespace Tests\Framework\Http;

use App\Http\Action\HelloAction;
use PHPUnit\Framework\TestCase;
use Zend\Diactoros\ServerRequest;

class HelloActionTest extends TestCase
{
  public function testGuest()
  {
    $action = new HelloAction();
    $request = new ServerRequest();
    $response = $action($request);
    $this->assertEquals(200, $response->getStatusCode());
    self::assertEquals('Hello, Guest!', $response->getBody()->getContents());
  }
  
  public function testJohn()
  {
    $action = new HelloAction();
    $request = (new ServerRequest())
      ->withQueryParams(['name' => 'John']);
    $response = $action($request);
    $this->assertEquals('Hello, John!', $response->getBody()->getContents());
  }
}
