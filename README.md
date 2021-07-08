# php-s3-test

Test/Proof Of Concept for creating a presigned S3 URL, with TTL.

## Prerequisites

* PHP
* Composer

## Installation

Install the project with:

```
composer install
``` 

## Configuration

in s3.php include the S3 server endpoint, key and secret.

```php
$s3 = new Aws\S3\S3Client([
    'version' => 'latest',
    'region'  => 'us-east-1',
    'endpoint' => '************',
    'use_path_style_endpoint' => true,
    'credentials' => [
            'key'    => '****************',
            'secret' => '****************',
        ],
]);
```

## How it Works

After browsing to s3.php and setting the request `uri` parameter containing the resource, the server will respond with a `302` http status code. The HyperText Transfer Protocol (HTTP) 302 Found redirect status response code indicates that the resource requested has been temporarily moved to the URL given by the Location header.

This location contains a signed TTL (time to live) url of 10 minutes from the s3 server

for example:

```
http://localhost:3000/s3.php?uri=content/cube3/cube3_-_I_m_Waiting.mp3
```

# Dockerize

```
docker build . -t ccmixter-s3
```

Run the container, setting your s3 endpoint, key, secret and Time to Live (TTL) in 10 minutes:

```
docker run -p 127.0.0.1:47360:80 -e S3_ENDPOINT="<<your_endpoint>>" -e S3_KEY="<<your_key>>" -e S3_SECRET="<<your_secret>>" -e S3_TTL_MINUTES=10 --name ccmixter-s3 ccmixter-s3
```