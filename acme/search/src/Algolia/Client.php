<?php
namespace Acme\Search\Algolia;

use Acme\Search\ClientInterface;
use Acme\Search\ConfigInterface;
use AlgoliaSearch\Client as ClientAPI;

class Client extends \Object implements ClientInterface
{
    protected $query;
    protected $config;
    protected $controller;
    protected $api;
    protected $name = 'Algolia';
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
        $appName = $config['values'][$this->name]['app'];
        $index = $config['values'][$this->name]['index'];
        $searchKey = $config['values'][$this->name]['search_key'];
        $this->api = new ClientAPI($appName, $searchKey);
        $this->index = $this->api->initIndex($index);
    }

    public function connect()
    {
        return true;
    }

    public function query($keyword, array $options = [])
    {
        $results = $this->index->search(
            $keyword,
            $this->query->parse($options)
        );

        $records = array();
        foreach ($results['hits'] as $record) {
            $records[] = array(
                'Title' => $record['name'],
                'URLSegment' => $record['image_path'],
                'Content' => 'Rating:' . $record['rating'] . '<br />'
                    . ' Name: ' . $record['name']
            );
        }

        $list = new \PaginatedList(new \ArrayList($records));
        $list->setPageStart($results['page']);
        $list->setPageLength($results['hitsPerPage']);
        $list->setTotalItems($results['nbHits']);

        // The list has already been limited by the query above
        $list->setLimitItems(false);

        return $list;
    }
}
