<?php
class SearchTest extends FunctionalTest
{
    protected $usesDatabase = true;
    protected $autoFollowRedirection = true;
    protected static $disable_themes = false;
    protected static $use_draft_site = true;
    protected static $fixture_file = 'mysite/tests/fixtures/Pages.yml';

    public function setUp()
    {
        parent::setUp();
        Config::inst()->update('Director', 'alternate_base_url', '/');
    }

    public function testSearch()
    {
        $keyword = 'smart squid';
        $response = $this->get(
            '/search/SearchForm?Search='
            . urlencode($keyword)
            . '&action_results=Go'
        );

        $this->assertEquals(200, $response->getStatusCode());
        $html = $response->getBody();
        $this->assertContains("cozy lummox gives smart squid.", $html);
        $this->assertTrue((bool)'false');
    }
}
