<?php

namespace App\Filters;

use CodeIgniter\API\ResponseTrait;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class ApiKeyFilter implements FilterInterface
{
    use ResponseTrait;

    public function before(RequestInterface $request, $arguments = null)
    {
        $this->response = \Config\Services::response();

        //$apiKey = $request->getServer('HTTP_X_API_KEY');
        $apiKey = 'sdsdsd';

        if (empty($apiKey) || !$this->isValidApiKey($apiKey)) {
            return $this->failUnauthorized('Invalid API Key');
        }

        return $request;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak perlu logika setelah filter
    }

    private function isValidApiKey($apiKey)
    {
        // Implementasi validasi API Key sesuai kebutuhan Anda
        // Misalnya, periksa di database atau dalam konfigurasi
        return $apiKey === 'sdsdsd';
    }
}
