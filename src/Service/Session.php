<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class Session
{
    /**
     * @var HttpClientInterface
     */
    private $client;

    private $spotifyApiToken;

    private $clientId;

    private $clientSecret;

    public function __construct(HttpClientInterface $client, $spotifyApiToken, $spotifyClientId, $spotifyClientSecret)
    {
        $this->client = $client;
        $this->spotifyApiToken = $spotifyApiToken;
        $this->clientId = $spotifyClientId;
        $this->clientSecret = $spotifyClientSecret;
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function token()
    {
        $credential = base64_encode(sprintf('%s:%s', $this->clientId, $this->clientSecret));

        $request = $this->client->request(Request::METHOD_POST, $this->spotifyApiToken,
            [
                'headers' => [
                    sprintf('Authorization: Basic %s', $credential),
                    'Content-Type: application/x-www-form-urlencoded'
                ],
                'body' => [
                    'grant_type' => 'client_credentials'
                ]
            ]
        );

        return json_decode($request->getContent(), true);
    }

    public static function authorizationHeader(array $token): string
    {
        if (null === $token['token_type'] || null === $token['access_token']) {
            // todo throw exception
        }

        return sprintf('Authorization: %s %s', $token['token_type'], $token['access_token']);
    }
}