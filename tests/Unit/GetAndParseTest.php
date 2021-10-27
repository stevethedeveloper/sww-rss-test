<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

use App\Classes\RssParser;

class GetAndParseTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_get_and_parse()
    {
        $url = 'https://www.omnycontent.com/d/playlist/2b465d4a-14ee-4fbe-a3c2-ac46009a2d5a/b1907157-de93-4ea2-a952-ac700085150f/be1924e3-559d-4f7d-98e5-ac7000851521/podcast.rss';
        $parser = new RssParser();
        $this->assertTrue($parser->getAndParseFeed($url, false));
    }
}
