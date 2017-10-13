<?php
namespace Acme\Search\Solr;

use Acme\Search\ClientInterface;
use Acme\Search\ConfigInterface;
use AlgoliaSearch\Client as ClientAPI;

class Client extends \Object implements ClientInterface
{
    protected $query;
    protected $config;
    protected $controller;
    protected $name = 'Solr';
    protected $index;

    public function __construct(ConfigInterface $config, \ContentController $controller)
    {
        $this->config = $config;
        $this->controller = $controller;
        $this->query = Query::create($this->config);
        $this->init();
    }

    public function init()
    {
        $config = $this->config->details();
        $index = $config['values'][$this->name]['index'];
        $this->index = singleton($index);
    }

    public function connect()
    {
        return true;
    }

    public function query($keyword, array $options = [])
    {
        $query = new \SearchQuery();
        $query->search($keyword);
        $results = $this->index->search($query);

        return $results->Matches;
    }
}
