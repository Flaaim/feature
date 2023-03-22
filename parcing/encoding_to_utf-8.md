    $response = $guzzle->request('GET', $url);

    $type = $response->getHeader('content-type');
    $parsed = Psr7\parse_header($type);

    $original_body = (string)$response->getBody();
    $utf8_body = mb_convert_encoding($original_body, 'UTF-8', $parsed[0]['charset'] ?: 'UTF-8');
