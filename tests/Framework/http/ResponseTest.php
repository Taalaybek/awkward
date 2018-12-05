<?php
namespace Tests\Framework\Http;

use Framework\Http\Response;
use PHPUnit\Framework\TestCase;

/**
 * ResponseTest
 */
class ResponseTest extends TestCase
{
    /** @test */
    public function test_empty(): void
    {
        $response = new Response($body = 'Body');

        $this->assertEquals($body, $response->getBody());
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('OK', $response->getReasonPhrase());
    }

    public function test_404(): void
    {
        $response = new Response($body='Body', $status=404);
        $this->assertEquals($body, $response->getBody());
        $this->assertEquals(404, $response->getStatusCode());
        $this->assertEquals('Not Found', $response->getReasonPhrase());
    }

    public function test_headers(): void
    {
        $response = (new Response(''))
            ->setHeader($header = 'X-Header', $value = 'Alex')
            ->setHeader($header1 = 'X-Header1', $value1 = 'Vladimir');
        
        $this->assertEquals(
            [$header => $value, $header1 => $value1], 
            $response->getHeaders()
        );
    }
}
