<?php

namespace App\Tests;

use App\Security\Session;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\CurlHttpClient;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class SessionTest extends TestCase
{
    private static $spotifyApiTokenUrl = 'https://accounts.spotify.com/api/token';
    private static $clientId = 'fad982f0a029456a966efd41e4f014ec';
    private static $clientSecret = '82825c82636c4054a8d05b467458fd9f';

    /**
     * @var HttpClientInterface
     */
    private $client;
    /**
     * @var Session
     */
    private $session;


    protected function setUp(): void
    {
        $this->client = new CurlHttpClient();
        $this->session = new Session(
            $this->client,
            self::$spotifyApiTokenUrl,
            self::$clientId,
            self::$clientSecret
        );
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function testGenerationToken()
    {
        $credential = base64_encode(sprintf('%s:%s', self::$clientId, self::$clientSecret));
        $options = [
            'headers' => [
                sprintf('Authorization: Basic %s', $credential),
                'Content-Type: application/x-www-form-urlencoded'
            ],
            'body' => [
                'grant_type' => 'client_credentials'
            ]
        ];

        $tokenArr = [
            'token_type' => 'bearer',
            'access_token' => 'NgCXRKcDuFohMzYjw',
            'expires_in' => 3600
        ];

        $this->client->request(Request::METHOD_POST, self::$spotifyApiTokenUrl, $options);

        $token = $this->session->token();

        self::assertSame($tokenArr, $token);

    }
}