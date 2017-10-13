<?php

namespace Acme\Search;

class ClientFactory extends \Object implements ClientInterface
{
    protected $config;
    protected $client;
    protected $controller;
    protected $connected = false;

    public function __construct(ConfigInterface $config, \ContentController $controller)
    {
        $this->config = $config;
        $this->controller = $controller;
        $config = $this->config->details();
        $defaultClient = $config['default'];
        $client = $config['values'][$defaultClient]['client'];

        $this->client = \Object::create($client, $this->config, $this->controller);
    }

    // Used for connecting to external api
    public function connect()
    {
        return ($this->connected) ?: $this->connected = $this->client->connect();
    }

    public function query($keyword, array $options = [])
    {
        // Used to illustrate an error
        // throw new \Exception("Error Processing Request", 1);

        return $this->client->query($keyword, $options);
    }
}
