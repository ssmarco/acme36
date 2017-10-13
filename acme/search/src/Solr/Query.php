<?php

namespace Acme\Search\Solr;

use Acme\Search\ConfigInterface;

class Query extends \Object
{
    protected $config;

    public function __construct(ConfigInterface $config)
    {
        $this->config = $config;
    }

    public function parse($options)
    {
        return $options;
        $page = (isset($options['start'])) ? ceil($options['start']/10) : 0;
        $pageLength = $this->config->details()['page_length'];
        return array(
            'page' => $page,
            'hitsPerPage' => $pageLength
        );
    }
}
