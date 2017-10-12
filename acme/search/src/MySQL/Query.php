<?php

namespace Acme\Search\MySQL;

use Acme\Search\ConfigInterface;

class Query extends \Object
{
    protected $config;

    public function __construct(ConfigInterface $config)
    {
        $this->config = $config;
    }
}
