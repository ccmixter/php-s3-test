<?php

date_default_timezone_set('America/Los_Angeles');
require 'vendor/autoload.php';

$s3 = new Aws\S3\S3Client([
    'version' => 'latest',
    'region'  => 'us-east-1',
    'endpoint' => '*********',
    'use_path_style_endpoint' => true,
    'credentials' => [
            'key'    => '*********',
            'secret' => '*********',
        ],
]);

$command = $s3->getCommand('GetObject', [
    'Bucket' => 'www',
    'Key'    => $_GET['uri']
]);

// Create a pre-signed URL for a request with duration of 10 miniutes
$presignedRequest = $s3->createPresignedRequest($command, '+10 minutes');

// Get the actual presigned-url
$presignedUrl =  (string)  $presignedRequest->getUri();

header('Location: ' . $presignedUrl, true, 302)

?>