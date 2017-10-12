<?php

namespace Acme\Search;

interface ClientInterface
{
    public function connect();

    public function query($keyword, array $options = []);
}
