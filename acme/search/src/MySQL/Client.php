<?php
namespace Acme\Search\MySQL;

use Acme\Search\ClientInterface;
use Acme\Search\ConfigInterface;

class Client extends \Object implements ClientInterface
{
    protected $query;
    protected $config;
    protected $controller;

    public function __construct(ConfigInterface $config, \ContentController $controller)
    {
        $this->config = $config;
        $this->controller = $controller;
        $this->query = Query::create($this->config);
    }

    public function connect()
    {
        return true;
    }

    public function query($keyword, array $options = [])
    {
        $sf = new \SearchForm($this->controller, 'SearchForm');
        return $sf->getResults(null, ['Search' => $keyword]);
    }
}
