<?php

namespace sarelvdwalt\eveESI;

use GuzzleHttp\Client;

class APIOauth
{
    protected $baseURL = 'https://login.eveonline.com';

    protected $clientID;
    protected $secretKey;

    protected $client;

    /**
     * APIOauth constructor.
     * @param string $clientID
     * @param string $secretKey
     */
    public function __construct($clientID, $secretKey)
    {
        $this->clientID = $clientID;
        $this->secretKey = $secretKey;

        $this->client = new Client();
    }

    /**
     * Gets the Access Token once the Authorization Code has teen returned by OAuth callback.
     * EVE Docs: http://eveonline-third-party-documentation.readthedocs.io/en/latest/sso/authentication.html#verify-the-authorization-code
     *
     * @param $authCode
     * @return TokenEnvelope
     */
    public function getAccessToken($authCode)
    {
        $response = $this->client->request('POST', $this->baseURL.'/oauth/token', [
            'auth' => [
                $this->clientID,
                $this->secretKey
            ],
            'form_params' => [
                'grant_type' => 'authorization_code',
                'code' => $authCode
            ]
        ]);

        $responseJSON = \GuzzleHttp\json_decode($response->getBody()->getContents());

        return (new TokenEnvelope())
            ->setAccessToken($responseJSON->access_token)
            ->setExpiresAt(new \DateTime('+ ' . $responseJSON->expires_in . ' seconds'))
            ->setRefreshToken($responseJSON->refresh_token)
            ->setTokenType($responseJSON->token_type);
    }

    /**
     * Refreshes the Access Token, using the refresh_token.
     * EVE Docs: http://eveonline-third-party-documentation.readthedocs.io/en/latest/sso/refreshtokens.html#refresh-tokens
     *
     * @param TokenEnvelope $tokenEnvelope
     * @return TokenEnvelope
     * @internal param TokenEnvelope $envelope
     */
    public function refreshAccessToken(TokenEnvelope $tokenEnvelope)
    {
        $response = $this->client->post($this->baseURL . '/oauth/token', [
            'auth' => [
                $this->clientID,
                $this->secretKey
            ],
            'form_params' => [
                'grant_type' => 'refresh_token',
                'refresh_token' => $tokenEnvelope->getRefreshToken()
            ]
        ]);

        $responseJSON = \GuzzleHttp\json_decode($response->getBody()->getContents());

        return $tokenEnvelope
            ->setAccessToken($responseJSON->access_token)
            ->setExpiresAt(new \DateTime('+ ' . $responseJSON->expires_in . ' seconds'))
            ->setRefreshToken($responseJSON->refresh_token)
            ->setTokenType($responseJSON->token_type);
    }

    /**
     * Gets the CharacterID (and details) using the access_token from tokenEnvelope
     * EVE Docs: http://eveonline-third-party-documentation.readthedocs.io/en/latest/sso/obtaincharacterid.html#obtaining-character-id
     *
     * @param TokenEnvelope $tokenEnvelope
     * @return mixed
     */
    public function obtainCharacterEnvelope(TokenEnvelope $tokenEnvelope)
    {
        $response = $this->client->get($this->baseURL.'/oauth/verify', [
            'headers' => [
                'Authorization' => [
                    'Bearer ' . $tokenEnvelope->getAccessToken()
                ]
            ]
        ]);

        return \GuzzleHttp\json_decode($response->getBody()->getContents());
    }
}