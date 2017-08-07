<?php declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * Test Fetch MainPage Data.
     * @return void
     * @covers \App\Http\Controllers\MovieController::mainPage()
     */
    public function testCanFetchTheMainPageData()
    {
        $response = $this->get('/');
        $this->assertEquals('200',$response->getStatusCode());
        $this->assertNotEmpty($response->getContent());
    }

    /**
     * Test Can Fetch Movie Data.
     * @return void
     * @covers \App\Http\Controllers\MovieController::index()
     */
    public function testCanFetchTheMovieData()
    {
        $response = $this->get('/movie');
        $this->assertEquals('200', $response->getStatusCode());
        $response = $response->getContent();
        $result = json_decode($response, true);
        foreach($result as $item)
        {
            $this->assertArrayHasKey('name', $item);
            $this->assertArrayHasKey('season', $item);
            $this->assertArrayHasKey('episode', $item);
            $this->assertArrayHasKey('url', $item);
            $this->assertArrayHasKey('img', $item);
            $this->assertNotEmpty($item['name']);
            $this->assertNotEmpty($item['season']);
            $this->assertNotEmpty($item['episode']);
            $this->assertTrue(mb_strlen($item['name']) > 0);
        }

    }

    /**
     * Test Fetch MainPage Data.
     * @return void
     * @covers \App\Http\Controllers\MovieController::show()
     */
    public function testCanFetchMovieByTheWildCard()
    {
        $response = $this->get('/movie/1');
        $this->assertEquals('200',$response->getStatusCode());
        $this->assertNotEmpty($response->getContent());
        $content = json_decode($response->getContent(), true);
        $this->assertSame(1, $content['id']);
    }


    public function testShouldThrowExceptionIfRouteNotExist()
    {
        $response = $this->get('/unvaliable');
        $this->assertEquals('404', $response->getStatusCode());
    }
}
