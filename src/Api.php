<?php

namespace Proloweb\WebformClient;

use \GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class Api
{
    const API_ENDPOINT_SHOW_WEBFORM = '/web/webform/show/';
    const API_ENDPOINT_SUBMIT_WEBFORM = '/web/webform/submit/';

    private Client $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => App::getEnv('CRM_API_URL')
        ]);
    }

    /**
     * @param string $instanceId
     * @param string $slug
     * @return Response
     * @throws GuzzleException
     */
    public function getWebformBySlug(string $instanceId, string $slug): Response
    {
        $query = http_build_query([
            'instance_id' => $instanceId
        ]);

        return new Response($this->client->get(self::API_ENDPOINT_SHOW_WEBFORM . $slug . '?' . $query));
    }

    /**
     * @param string $instanceId
     * @param string $slug
     * @param string $formResponse
     * @param string $ip
     * @throws GuzzleException
     */
    public function sendFormResponse(string $instanceId, string $slug, string $formResponse, string $ip): void
    {
        $postData = [
            'instanceId' => $instanceId,
            'response' => $formResponse,
            'clientIp' => $ip
        ];

        $this->client->post(self::API_ENDPOINT_SUBMIT_WEBFORM . $slug, [
            'json' => $postData
        ]);
    }
}
