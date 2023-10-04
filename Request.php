<?php

ini_set('display_errors', true);
error_reporting(E_ALL);

require __DIR__ . '/vendor/autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\Pool;
use GuzzleHttp\Psr7\Request;
use JetBrains\PhpStorm\NoReturn;


class Requester
{
    public string|null $url;
    protected bool $responseStatus = true;
    protected int $responseCode = 200;
    protected string $responseMessage = 'Successfully done';

    protected array $data = [];

    #[NoReturn] public function __construct()
    {
        if (!$this->setUrl())
            $this->errorResponse(422);

        $result = $this->sendRequest();
        $this->data = $result;
        $this->response();
    }

    #[NoReturn] public function errorResponse(int $code = 500): void
    {
        $this->responseCode = $code;
        $this->responseMessage = 'url is missing in request body';
        $this->response();
    }

    /**
     * @param array $data
     * @return void
     */
    #[NoReturn] public function response(array $data = []): void
    {
        header("Content-Type: application/json");
        if (count($data))
            $this->data = $data;
        $baseResponse = $this->createResponse();
        $jsonResponse = json_encode($baseResponse);
        echo $jsonResponse;
        exit(0);
    }

    public function createResponse(): array
    {
        return [
            'status' => $this->responseStatus,
            'code' => $this->responseCode,
            'message' => $this->responseMessage,
            'data' => $this->data,
        ];
    }

    public function setUrl(): bool
    {
        $url = $this->input('url');
        if (!$url) return false;

        $this->url = $url;
        return true;
    }

    public function sendRequest(): array
    {
        $ch = curl_init($this->url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);

        $startTime = microtime(true);
        $response = curl_exec($ch);
        $endTime = microtime(true);
        $responseTimeMs = ($endTime - $startTime) * 1000;
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if (curl_errno($ch)) {
            $result = [
                'error' => 'cURL Error: ' . curl_error($ch),
                'time' => $responseTimeMs,
                'code' => $httpCode ,
                'is_failed' => true ,
            ];
        } else {
            $result = [
//                'response' => $response,
                'time' => (int) $responseTimeMs,
                'code' => $httpCode ,
                'is_failed' => false ,
            ];
        }
        curl_close($ch);
        return $result;
    }

    public function input(string $index): string|null
    {
        $requestInputs = array_merge($_GET, $_POST);
        return array_key_exists($index, $requestInputs) ? $requestInputs[$index] : null;
    }
}


$app = new Requester();
