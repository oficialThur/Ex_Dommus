<?php

class RequestReader {
    public function getId(): int
    {
        if (!isset($_GET['id'])) {
        throw new InvalidArgumentException("Id não informado", 422);        
        }
        return (int) $_GET['id'];
    }

    public function getRawBody(): string
    {
        $rawBody = file_get_contents('php://input');

        if ($rawBody === false || empty($rawBody)) {
            throw new InvalidArgumentException("Corpo não informado", 422);
        }
        return $rawBody;
    }
}
