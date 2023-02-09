<?php

namespace SoerBV\Shipsgo;

class Client
{
    protected string $host = 'https://shipsgo.com/api/v1.1/ContainerService/';
    protected string $authCode;

    public function __construct(string $authCode)
    {
        $this->authCode = $authCode;
    }

    /**
     * @throws \Exception
     */
    public function sendRequest($endpoint, $method, $params = [], $data = null): bool|string
    {
        $curl = curl_init();

        switch ($method) {
            case "GET":
                $url = $this->host . $endpoint . "/?authCode=" . $this->authCode . "&". http_build_query($params);
                curl_setopt($curl, CURLOPT_HTTPGET, 1);
                break;
            case "POST":
                $url = $this->host . $endpoint;
                curl_setopt($curl, CURLOPT_POST, 1);
                if ($data) {
                    $data = http_build_query($data);
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                }
                break;
            default:
                break;
        }

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/x-www-form-urlencoded',
            'Accept: application/json',
        ));

        $result = curl_exec($curl);
        $headerInfo = curl_getinfo($curl);

        // Throw error if $result returns other header then status 200, 201 or 204
        $acceptedHeaders = [200, 201, 204];

        if ($headerInfo['http_code'] != in_array($headerInfo['http_code'], $acceptedHeaders)) {
            throw new \Exception('Status ' . $headerInfo['http_code'] . ' received: ' . $result);
        }

        curl_close($curl);


        return $result;
    }

    /**
    * Create a tracking request with Master Bill of Lading Number using the Custom Form.
    */
    public function createTrackingWithBl($containerNumber, $shippingLine, $emailAddress, $referenceNo, $blContainersRef): bool|string
    {
        try  {
            $this->getVoyageData($blContainersRef);
            return 'Container already exists.';
        } catch (\Exception $exception) {
            // do nothing
        }

        $data = [
            'authCode' => $this->authCode,
            'containerNumber' => $containerNumber,
            'shippingLine' => $shippingLine,
            'emailAddress' => $emailAddress,
            'referenceNo' => $referenceNo,
            'blContainersRef' => $blContainersRef
        ];

        return $this->sendRequest('PostCustomContainerFormWithBl', 'POST', [], $data);
    }

    /**
     * Create a tracking request with Container Number using the Custom Form.
     */
    public function createTrackingWithContainerNumber($containerNumber, $shippingLine, $emailAddress, $referenceNo): bool|string
    {
        try  {
            $this->getVoyageData($containerNumber);
            return 'Container already exists.';
        } catch (\Exception $exception) {
            // do nothing
        }

        $data = [
            'authCode' => $this->authCode,
            'containerNumber' => $containerNumber,
            'shippingLine' => $shippingLine,
            'emailAddress' => $emailAddress,
            'referenceNo' => $referenceNo,
        ];

        return $this->sendRequest('PostCustomContainerForm', 'POST', [], $data);
    }

    /**
     * Get full voyage date of a shipment.
     */
    public function getVoyageData($requestId): bool|string
    {
        $params = [
            'requestId' => $requestId,
        ];

        return $this->sendRequest('GetContainerInfo', 'GET', $params);
    }

}
