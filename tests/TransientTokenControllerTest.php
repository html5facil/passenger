<?php

use Symfony\Component\HttpFoundation\Cookie;

class TransientTokenControllerTest extends PHPUnit_Framework_TestCase
{
    public function tearDown()
    {
        Mockery::close();
    }

    public function test_token_can_be_refreshed()
    {
        $cookieFactory = Mockery::mock('Masdevs\Passenger\ApiTokenCookieFactory');
        $cookieFactory->shouldReceive('make')->once()->with(1, 'token')->andReturn(new Cookie('cookie'));

        $request = Mockery::mock(Illuminate\Http\Request::class);
        $request->shouldReceive('user')->andReturn($user = Mockery::mock());
        $user->shouldReceive('getKey')->andReturn(1);
        $request->shouldReceive('session->token')->andReturn('token');

        $controller = new Masdevs\Passenger\Http\Controllers\TransientTokenController($cookieFactory);

        $response = $controller->refresh($request);

        $this->assertEquals(200, $response->status());
        $this->assertEquals('Refreshed.', $response->getOriginalContent());
    }
}
