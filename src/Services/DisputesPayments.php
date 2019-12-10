<?php

namespace Srmklive\PayPal\Services;

use Illuminate\Support\Collection;
use Srmklive\PayPal\Traits\PayPalDisputes as PayPalAPIRequest;
use Srmklive\PayPal\Traits\PayPalRequest;

class DisputesPayments
{
    // Integrate PayPal Request trait
    use PayPalRequest, PayPalAPIRequest;

    /**
     * ExpressCheckout constructor.
     *
     * @param array $config
     *
     * @throws \Exception
     */
    public function __construct(array $config = [])
    {
        // Setting PayPal API Credentials
        $this->setConfig($config);

        $this->httpBodyParam = 'form_params';

        $this->options = [];

        $this->headers = [
            "Content-Type" => "application/json",
            'Authorization' => 'Bearer '.$this->getOathToken()
        ];
    }

    /**
     * Set ExpressCheckout API endpoints & options.
     *
     * @param array $credentials
     *
     * @return void
     */
    public function setDisputesPaymentsOptions($credentials)
    {
        // Setting API Endpoints
        if ($this->mode === 'sandbox') {
            $this->config['api_url'] = 'https://api.sandbox.paypal.com/v1/';
        } else {
            $this->config['api_url'] = 'https://api.paypal.com/v1/';
        }

        // Adding params outside sandbox / live array
        $this->config['payment_action'] = $credentials['payment_action'];
        $this->config['notify_url'] = $credentials['notify_url'];
        $this->config['locale'] = $credentials['locale'];
    }

}
