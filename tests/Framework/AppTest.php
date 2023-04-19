<?php

namespace Tests\Framework;

use Framework\App;
use PHPUnit\Framework\TestCase;
use GuzzleHttp\Psr7\ServerRequest;

class AppTest extends TestCase {

    // public function testRedirectTrailingSlash(){
    //     $request = new ServerRequest('GET', '/qweqwe/');
    //     $app = new App([]);
    //     $response = $app->run($request);
    //     $this->assertContains('/qweqwe', $response->getHeader('Location'));
    //     $this->assertEquals(301, $response->getStatusCode());
    // }

}