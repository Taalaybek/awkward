<?php
namespace Tests\Framework\Http;

use PHPUnit\Framework\TestCase;
use Zend\Diactoros\Response;
use Zend\Diactoros\Response\HtmlResponse as Html;

/**
 * ResponseTest
 */
class ResponseTest extends TestCase
{
    /** @test */
    public function test_empty(): void
    {
        $response = new Html($body = 'Body');

        $this->assertEquals($body, $response->getBody()->getContents());
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function test_404(): void
    {
        $response = new Html($body='Body', $status=404);
        $this->assertEquals($body, $response->getBody()->getContents());
        $this->assertEquals(404, $response->getStatusCode());
        $this->assertEquals(mb_strlen($body), $response->getBody()->getSize());
    }

    public function test_headers(): void
    {
        $response = (new Response())
            ->withHeader($header = 'X-Header', $value = 'Alex')
            ->withHeader($header1 = 'X-Header1', $value1 = 'Vladimir');

        $this->assertEquals(
            [$header => [$value], $header1 => [$value1]],
            $response->getHeaders()
        );
    }
}
