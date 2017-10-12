<?php


class MyIndex extends SolrIndex {
    function init() {
	    $this->addClass('SiteTree');
        //$this->addAllFulltextFields();
	    $this->addFulltextField('Title');
	    $this->addFulltextField('Content');
    }
}
