<?php

class UpdatePostService 
{
    private const API_URL =  'https://jsonplaceholder.typicode.com/posts/';

    public function __construct(
        private RequestReader $requestReader,
        private XmlToArrayConverter $xmlToArrayConverter,
        private Client $httpClient
    ) {}

    public function execute(): void
    {
        $id = $this->requestReader->getId();
        
        $rawBody = $this->requestReader->getRawBody();

        $payload = $this->xmlToArrayConverter->convert($rawBody, $id);

        $response = $this->httpClient->put(self::API_URL . $id, $payload);

        http_response_code($response['status']);
        echo $response['body'];
    }

}