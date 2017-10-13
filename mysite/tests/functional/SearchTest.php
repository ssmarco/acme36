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


    private function jsonencoder()
    {
        $Content = <<<EOT
<h1>Stripeology</h1>
<div class="content"><h2>Definition</h2><h3>/strʌɪpɒlədʒi/</h3><p><em>noun</em></p><ol><li>the culture, history and mindset of SilverStripers.</li>
<li>a body of shared knowledge held collectively by SilverStripers.</li>
<li>the thing we study on Hackday and do every other day — working together and collaborating in an agile way.</li>
<li>a play on genealogy — it presents the past legacy of SilverStripers, and as each member of the SilverStripe family adds their branch, the tree (bamboo patch?) grows and flourishes.</li>
<li>the word you have to look up every time you have to spell it.</li>
</ol><h2>Share, learn, grow</h2><p>There are plenty of opportunities for learning at SilverStripe — we pay for SilverStripers to attend conferences and training; we have an awesome mentoring programme; we hold our own monthly hackdays; and we encourage knowledge sharing through regular internal events likes Show &amp; Tells, Lunch &amp; Learns and Guild Meetings. We call this our&nbsp;<em>Stripeology</em>&nbsp;and we've got something on every week. Mostly, you will be working alongside super smart designers, developers and scrum masters. They’ll share their love of the craft with you and help you grow your skills.</p></div>
EOT;
        $test = array(
            'name' => "Stripeology",
            'rating' => 1000,
            'image_path' => "/g3fsRgEoMxaqPayIMtGDWERqJ6A.jpg",
            'alternative_name' => null,
            'objectID' => '',
            'Content' => $Content
        );

        echo json_encode($test);
    }
}
