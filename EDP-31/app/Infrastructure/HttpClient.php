<?php

class Client
{
    public function put(string $url, array $payload): array
    {
        $jsonPayload = json_encode($payload);

        if ($jsonPayload === false) {
            throw new RuntimeException("Erro ao converter payload para JSON", 422);
        }
        
        $curl = curl_init($url);    

        curl_setopt_array($curl,[
            CURLOPT_CUSTOMREQUEST => 'PUT',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POSTFIELDS => $jsonPayload,
            CURLOPT_HTTPHEADER => [
                'Content-Type: application/json',
                'Content-Length: ' . strlen($jsonPayload)
            ]  
        ]);

        $responseBody = curl_exec($curl);
        $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        
        if($responseBody === false) {
            throw new RuntimeException(curl_error($curl), 422);
        }
        
        $curl = null;

        return [
            'status' => $statusCode,
            'body' => $responseBody
        ];
    }
}