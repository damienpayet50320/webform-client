<?php

namespace Proloweb\WebformClient;
use GuzzleHttp\Psr7\Response as GuzzleResponse;

class Response
{
    private ?string $data = null;

    private GuzzleResponse $origin;

    /**
     * @param GuzzleResponse $guzzleResponse
     */
    public function __construct(GuzzleResponse $guzzleResponse)
    {
        $this->origin = $guzzleResponse;

        if ($guzzleResponse->getStatusCode() === 200) {
            $this->data = $guzzleResponse->getBody()->getContents();
        }
    }

    /**
     * @return string
     */
    public function getResponseData(): string
    {
        return empty($this->data) ? '' : $this->data;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return empty($this->data) ? [] : json_decode($this->data, true);
    }

    /**
     * @return GuzzleResponse
     */
    public function getOrigin(): GuzzleResponse
    {
        return $this->origin;
    }
}
