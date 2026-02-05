<?php

class XmlToArrayConverter{
    public function convert(string $xml, int $id): array
    {
        $xmlObject = simplexml_load_string($xml);

        if ($xmlObject === false) {
            throw new InvalidArgumentException("XML inválido", 422);
        }

        return [
            'id' => $id,
            'title' => (string) $xmlObject->title,
            'body' => (string) $xmlObject->body,
            'userId' => (int) $xmlObject->userId
        ];
    }
}