<?php
namespace Core\Thirdparty\Pkbsamsatjateng;

interface PkbSamsatJatengInterface {
    public function GetParameterPajak(array $params);
}

class PkbSamsatJateng implements PkbSamsatJatengInterface {
    private $endpoint;

    public function __construct($args = []) {
        $this->endpoint = "http://192.168.66.164/open-api";
        if (count($args) > 0) {
            $this->endpoint = $args[0];
        }
    }

    public function GetParameterPajak(array $params) {
        $body = [
            "params" => $params
        ];
        $jsonValue = json_encode($body);

        // API URL
        $url = $this->endpoint."/get_parameter_pajak";

        // Create a new cURL resource
        $ch = curl_init($url);

        // Setup request to send json via POST
        $payload = $jsonValue;

        // Attach encoded JSON string to the POST fields
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

        // Set the content type to application/json
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

        // Return response instead of outputting
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

        curl_setopt($ch, CURLOPT_TIMEOUT, 3);

        // Execute the POST request
        $result = curl_exec($ch);
        if ($result == false) {
            throw new \Exception(curl_error($ch));
        }

        // Close cURL resource
        curl_close($ch);

        return json_decode($result);
    }
}