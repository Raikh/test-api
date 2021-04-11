<?php

namespace Onigae\TestApi\DebitCard;

use Onigae\TestApi\Interfaces\ConfigInterface;

class Config implements ConfigInterface
{
    private array $config = [
        'base_uri' =>  'http://localhost/',
        'timeout' => 60,

    ];

    /**
     * Config constructor.
     */
    public function __construct(
         array $config = [])
    {
        $this->parseConfig($config);
    }

    public function getConfig(): array
    {
        return $this->config;
    }

    private function parseConfig(array $config = [])
    {
        foreach ($config as $key => $value)
        {
            $this->config[$key] = $value;
        }
    }

    public function setBaseUri(string $uri)
    {
        $this->config['base_uri'] = $uri;
    }

    public function setAuth(string $headerKey, string $value)
    {
        $this->config['headers'][$headerKey] = $value;
    }
}