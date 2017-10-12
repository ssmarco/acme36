<?php

namespace Acme\Search;

class Config extends \Object implements ConfigInterface
{
    /**
     * @config
     */
    private static $client;

    /**
     * @config
     */
    private static $indices = array();

    public function details()
    {
        $config = \Config::inst();

        return [
            'client' => $config->get(self::class, 'client'),
            'indices' => $config->get(self::class, 'indices'),
        ];
    }
}
