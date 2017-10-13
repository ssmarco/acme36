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
        $source = $config->get(self::class, 'source');
        $values = [];
        foreach ($source as $key) {
            $values[$key] = $config->get(self::class, $key);
        }

        return [
            'values'  => $values,
            'source'  => $source,
            'default' => reset($source),
            'page_length'  => $config->get(self::class, 'page_length'),
            'page_number'  => $config->get(self::class, 'page_number'),
            'client'  => $config->get(self::class, 'client'),
            'indices' => $config->get(self::class, 'indices'),
        ];
    }
}
