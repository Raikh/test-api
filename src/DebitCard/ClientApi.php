<?php

namespace Onigae\TestApi\DebitCard;

use Onigae\TestApi\Interfaces\ClientApiInterface;
use Psr\Http\Message\ResponseInterface;

class ClientApi implements ClientApiInterface
{
    private \GuzzleHttp\Client $client;

    /**
     * ClientApi constructor.
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $this->client = new \GuzzleHttp\Client(
            $config->getConfig()
        );
    }

    /**
     * @param $uri
     * @param array $options
     * @return ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Throwable
     */
    protected function post($uri, array $options = []): \Psr\Http\Message\ResponseInterface
    {
        try {
            return $this->client->post($uri, $options);
        }
        catch (\Throwable $throwable)
        {
            // Do some stuff if needed
            throw $throwable;
        }
    }

    /**
     * @param $uri
     * @param array $options
     * @return ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Throwable
     */
    protected function get($uri, array $options = []): \Psr\Http\Message\ResponseInterface
    {
        try {
            return $this->client->get($uri, $options);
        }
        catch (\Throwable $throwable)
        {
            // Do some stuff if needed
            throw $throwable;
        }
    }

    /**
     * @param array $data
     * @return DebitCard|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Throwable
     */
    public function createCard(array $data): ?DebitCard
    {
        $options = [
            'json' => $data
        ];
        $response = $this->post('cards/create', $options);

        $data = $this->decodeAnswer($response);

        return empty($data)
            ? null
            : new DebitCard($this, $data);
    }

    /**
     * @param int $cardId
     * @param int $pin
     * @return mixed|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Throwable
     */
    public function setPin(int $cardId, int $pin)
    {
        $options = [
            'json' => [
                'pin' => $pin
            ]
        ];
        $response = $this->post("cards/{$cardId}/update", $options);

        return $this->decodeAnswer($response);
    }

    /**
     * @param int $cardId
     * @return mixed|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Throwable
     */
    public function getPin(int $cardId)
    {
        $response = $this->get("cards/{$cardId}/pin");

        return $this->decodeAnswer($response);    }
    /**
     * @param int $cardId
     * @return DebitCard|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Throwable
     */
    public function getCard(int $cardId): ?DebitCard
    {
        $response = $this->get("cards/{$cardId}");

        $data = $this->decodeAnswer($response);

        return empty($data)
            ? null
            : new DebitCard($this, $data);
    }

    /**
     * @param int $cardId
     * @return mixed|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Throwable
     */
    public function getBalance(int $cardId)
    {
        $respone = $this->get("cards/{$cardId}/balance");

        return $this->decodeAnswer($respone);
    }

    /**
     * @param int $cardId
     * @return mixed|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Throwable
     */
    public function getHistory(int $cardId)
    {
        $respone = $this->get("cards/{$cardId}/history");

        return $this->decodeAnswer($respone);
    }

    /**
     * @param $responseCode
     * @return bool
     */
    protected function isResponseCodeOk($responseCode): bool
    {
        return $responseCode == 200;
    }

    /**
     * @param ResponseInterface $data
     * @return mixed|null
     */
    protected function decodeAnswer(ResponseInterface $data)
    {
        if($this->isResponseCodeOk($data->getStatusCode()))
        {
            return json_decode($data->getBody()->getContents(), true);
        }

        return null;
    }

    /**
     * @param int $cardId
     * @return mixed|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Throwable
     */
    public function activate(int $cardId)
    {
        $response = $this->post("cards/{$cardId}/activate");

        return $this->decodeAnswer($response);
    }

    /**
     * @param int $cardId
     * @return mixed|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Throwable
     */
    public function deactivate(int $cardId)
    {
        $response = $this->post("cards/{$cardId}/deactivate");

        return $this->decodeAnswer($response);    }

    /**
     * @param int $cardId
     * @param int $sum
     * @return mixed|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Throwable
     */
    public function load(int $cardId, int $sum)
    {
        $options = [
            'json' => [
                'load' => $sum
            ]
        ];
        $response = $this->post("cards/{$cardId}/load", $options);

        return $this->decodeAnswer($response);
    }

    /**
     * @return mixed|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Throwable
     */
    public function countries()
    {
        $response = $this->get("countries");

        return $this->decodeAnswer($response);
    }

    /**
     * @param int $countryId
     * @return mixed|null
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Throwable
     */
    public function getCountry(int $countryId)
    {
        $response = $this->get("countries/{$countryId}");

        return $this->decodeAnswer($response);
    }
}