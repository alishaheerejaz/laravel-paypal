<?php

namespace Srmklive\PayPal\Traits;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\BadResponseException as HttpBadResponseException;
use GuzzleHttp\Exception\ClientException as HttpClientException;
use GuzzleHttp\Exception\ServerException as HttpServerException;

trait PayPalDisputes
{

    /**
     * Perform PayPal API request & return response.
     *
     * @throws \Exception
     *
     * @return OAuth token
     */
    protected function getOathToken()
    {
        $endPoint = $this->apiUrl.'oauth2/token';
        $this->options =  [
            'grant_type' => 'client_credentials'
        ];

        try {
            return json_decode($this->client->post($endPoint, [
                    'auth' => [
                        $this->config['api_client_id'],
                        $this->config['api_secret']
                    ],
                    $this->httpBodyParam => $this->options,
            ])->getBody()->getContents())->access_token;
        } catch (HttpClientException $e) {
            throw new \Exception($e->getMessage());
        } catch (HttpServerException $e) {
            throw new \Exception($e->getRequest().' '.$e->getResponse(). ' '.$e->getMessage());
        } catch (HttpBadResponseException $e) {
            throw new \Exception($e->getRequest().' '.$e->getResponse(). ' '.$e->getMessage());
        }
    }

    /**
     * Perform PayPal API request & return response.
     *
     * @throws \Exception
     *
     * @return All disuputes for given access token
     */
    public function getAllDisputes()
    {
        $endPoint = $this->apiUrl.'customer/disputes/';
        try {
            return json_decode($this->client->get($endPoint, [
                'headers' => $this->headers,
            ])->getBody()->getContents());
        } catch (HttpClientException $e) {
            throw new \Exception($e->getMessage());
        } catch (HttpServerException $e) {
            throw new \Exception($e->getRequest().' '.$e->getResponse(). ' '.$e->getMessage());
        } catch (HttpBadResponseException $e) {
            throw new \Exception($e->getRequest().' '.$e->getResponse(). ' '.$e->getMessage());
        }
    }

    /**
     * Perform PayPal API request & return response.
     *
     * @throws \Exception
     *
     * @return Show detail of selected dispute
     */
    public function getDisputeDetail( $disputeID )
    {
        $endPoint = $this->apiUrl.'customer/disputes/'.$disputeID;
        try {
            return json_decode($this->client->get($endPoint, [
                'headers' => $this->headers
            ])->getBody()->getContents());
        } catch (HttpClientException $e) {
            throw new \Exception($e->getMessage());
        } catch (HttpServerException $e) {
            throw new \Exception($e->getRequest().' '.$e->getResponse(). ' '.$e->getMessage());
        } catch (HttpBadResponseException $e) {
            throw new \Exception($e->getRequest().' '.$e->getResponse(). ' '.$e->getMessage());
        }
    }

    /**
     * Perform PayPal API request & return response.
     *
     * @throws \Exception
     *
     * @return Reply on dispute
     */
    public function sendReplyOnDispute( $disputeID, $message )
    {
        $this->options = [
            'message' => $message
        ];
        $endPoint = $this->apiUrl.'customer/disputes/'.$disputeID.'/send-message';
        try {
            return $this->client->request('POST', $endPoint, [
                'body' => json_encode($this->options),
                'headers' => $this->headers
            ])->getBody()->getContents();
        } catch (HttpClientException $e) {
            throw new \Exception($e->getMessage());
        } catch (HttpServerException $e) {
            throw new \Exception($e->getRequest().' '.$e->getResponse(). ' '.$e->getMessage());
        } catch (HttpBadResponseException $e) {
            throw new \Exception($e->getRequest().' '.$e->getResponse(). ' '.$e->getMessage());
        }
    }
}
