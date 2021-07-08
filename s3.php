<?php

date_default_timezone_set('UTC');
require 'vendor/autoload.php';

$s3 = new Aws\S3\S3Client([
    'version' => 'latest',
    'region'  => 'us-east-1',
    'endpoint' => getenv("S3_ENDPOINT"),
    'use_path_style_endpoint' => true,
    'credentials' => [
            'key'    => getenv("S3_KEY"),
            'secret' => getenv("S3_SECRET"),
        ],
]);

$command = $s3->getCommand('GetObject', [
    'Bucket' => 'www',
    'Key'    => $_GET['uri'],
]);

// Create a pre-signed URL for a request with duration of 10 miniutes
$presignedRequest = $s3->createPresignedRequest($command, '+' . getenv('S3_TTL_MINUTES') . ' minutes');

// Get the actual presigned-url
$presignedUrl =  (string)  $presignedRequest->getUri();

header('Location: ' . $presignedUrl, true, 302)

?>