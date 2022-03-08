<?php

namespace App\Security;

use App\Security\Exception\InvalidToken;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class Session
{
    /** @var HttpClientInterface */
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
     * @return string
     * @throws ClientExceptionInterface
     * @throws InvalidToken
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     */
    public function getAuthorizationHeader(): string
    {
        $token = $this->token();
        if (!isset($token['token_type']) || !isset($token['access_token'])) {
            throw new InvalidToken();
        }

        return sprintf('Authorization: %s %s', $token['token_type'], $token['access_token']);
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    private function token()
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
}