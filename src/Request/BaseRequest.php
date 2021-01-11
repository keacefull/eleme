<?php

namespace Abbotton\Eleme\Request;

use Abbotton\Eleme\Config;

class BaseRequest
{
    private $client;

    private $config;

    public function __construct(Config $config, $client)
    {
        $this->config = $config;
        $this->client = $client;
    }

    protected function post($cmd, array $params = [])
    {
        $url = $this->config->baseUrl;

        return $this->request('POST', $url, ['form_params' => $this->getParams($cmd, $params)]);
    }

    private function request($method, $url, $options = [])
    {
        $method = strtoupper($method);

        $options['headers'] = [
            'Content-Type' => 'application/x-www-form-urlencoded',
        ];

        $response = $this->client->request($method, $url, $options);

        return $response->getBody()->getContents();
    }

    private function getParams(string $cmd, array $body)
    {
        $params = [];
        $params['cmd'] = $cmd;
        $params['source'] = $this->config->appKey;
        $params['secret'] = $this->config->appSecret;
        $params['ticket'] = $this->getTicket();
        $params['version'] = $this->config->version;
        $params['timestamp'] = time();
        $params['access_token'] = $this->config->accessToken;
        $params['encrypt'] = '';
        $params['body'] = json_encode($body, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        $params['sign'] = $this->generateSign($params);

        return $params;
    }

    private function getTicket()
    {
        if (function_exists('com_create_guid')) {
            $uuid = trim(com_create_guid(), '{}');
        } else {
            mt_srand((float) microtime() * 10000);
            $charId = strtoupper(md5(uniqid(rand(), true)));
            $hyphen = chr(45);
            $uuid = substr($charId, 0, 8).$hyphen
                .substr($charId, 8, 4).$hyphen
                .substr($charId, 12, 4).$hyphen
                .substr($charId, 16, 4).$hyphen
                .substr($charId, 20, 12);
        }

        return strtoupper($uuid);
    }

    private function generateSign(array $params)
    {
        ksort($params);
        $tmp = [];
        foreach ($params as $key => &$value) {
            $tmp[] = "$key=$value";
        }
        $strSign = implode('&', $tmp);

        return strtoupper(md5($strSign));
    }
}
