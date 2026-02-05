<?php

require 'models/RequestReader.php';
require 'models/XmlToArrayConverter.php';
require 'models/HttpClient.php';
require 'service/UpdatePostService.php';

try {
    $service = new UpdatePostService(
        new RequestReader(),
        new XmlToArrayConverter(),
        new Client()
    );

    $service->execute();

} catch (Exception $e) {
    http_response_code($e->getCode() ?: 500);
    echo $e->getMessage();
}
