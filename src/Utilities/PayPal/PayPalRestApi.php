<?php

namespace Utilities\PayPal;

use Utilities\PayPal\PayPalOrder;

class PayPalRestApi
{
    private $_baseUrl;
    private $_clientId;
    private $_clientSecret;
    private $_token;
    private $_tokenExpiration;

    public function __construct(string $clientId, string $clientSecret, $environment = "sandbox")
    {
        $this->_clientId = $clientId;
        $this->_clientSecret = $clientSecret;

        // Sandbox o producción
        $this->_baseUrl = ($environment === "sandbox")
            ? "https://api-m.sandbox.paypal.com"
            : "https://api-m.paypal.com";
    }

    // ============================================
    // OBTENER TOKEN
    // ============================================

    public function getAccessToken()
    {
        if ($this->_token === null || $this->_tokenExpiration < time()) {
            $this->requestAccessToken();
        }

        return $this->_token;
    }

    private function requestAccessToken()
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $this->_baseUrl . "/v1/oauth2/token",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "grant_type=client_credentials",
            CURLOPT_USERPWD => $this->_clientId . ":" . $this->_clientSecret,
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/x-www-form-urlencoded"
            ]
        ]);

        $response = curl_exec($curl);
        curl_close($curl);

        $data = json_decode($response);

        if (!isset($data->access_token)) {
            die(" ERROR: PayPal no devolvió token. Respuesta: " . $response);
        }

        $this->_token = $data->access_token;
        $this->_tokenExpiration = time() + $data->expires_in;
    }

    // ============================================
    // CREAR ORDEN PAYPAL
    // ============================================

    public function createOrder(PayPalOrder $order)
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $this->_baseUrl . "/v2/checkout/orders",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($order->getOrder()),
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json",
                "Authorization: Bearer " . $this->getAccessToken(),
                "Prefer: return=representation"
            ]
        ]);

        $response = curl_exec($curl);
        curl_close($curl);

        return json_decode($response);
    }

    // ============================================
    // CAPTURAR ORDEN
    // ============================================

    public function captureOrder($orderId)
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $this->_baseUrl . "/v2/checkout/orders/" . $orderId . "/capture",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json",
                "Authorization: Bearer " . $this->getAccessToken(),
                "Prefer: return=representation"
            ]
        ]);

        $response = curl_exec($curl);
        curl_close($curl);

        return json_decode($response);
    }
}
