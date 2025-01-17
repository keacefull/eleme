<?php

namespace Abbotton\Eleme;

use Abbotton\Eleme\Request\Activity;
use Abbotton\Eleme\Request\Common;
use Abbotton\Eleme\Request\Order;
use Abbotton\Eleme\Request\Prescription;
use Abbotton\Eleme\Request\Shop;
use Abbotton\Eleme\Request\Sku;
use Abbotton\Eleme\Request\Ugc;
use Exception;
use Symfony\Component\HttpClient\HttpClient;

/**
 * Class Application.
 *
 * @property Activity $activity
 * @property Common $common
 * @property Order $order
 * @property Prescription $prescription
 * @property Shop $shop
 * @property Sku $sku
 * @property Ugc $ugc
 */
class Application
{
    private $config;
    private $client;

    public function __construct($config)
    {
        $this->config = new Config($config);
        $this->client = HttpClient::create();
    }

    public function __get($name)
    {
        if (! isset($this->$name)) {
            $class_name = ucfirst($name);
            $application = "\\Abbotton\\Eleme\\Request\\{$class_name}";
            if (! class_exists($application)) {
                throw new Exception($class_name.'不存在');
            }
            $this->$name = new $application($this->config, $this->client);
        }

        return $this->$name;
    }

    public function setHttpClient($client): self
    {
        $this->client = $client;

        return $this;
    }
}
