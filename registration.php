<?php
    $consumerKey = 'consumer key';
    $consumerSecret = 'consumer secret';
    $cookieKey = 'vz_' . $consumerKey;


    if ($loggedInWithVzId = isset($_COOKIE[$cookieKey])) {
        // check if VZ-ID cookie exists and is valid
        $cookie = array();
        parse_str($_COOKIE[$cookieKey], $cookie);

        $baseString = $cookie['access_token'] . $cookie['issued_at'] . $cookie['user_id'];
        $signature = base64_encode(hash_hmac('sha1', $baseString, $consumerSecret, true));
        $retrievedSignature = $cookie['signature'];

        // check if given signature equals calculated signature which used the
        // consumer secret in order to avoid user id manipulation
        if ($signature !== $retrievedSignature) {
            throw new Exception('invalid cookie signature');
        }
    }   
?>
<html>
    <head>
        <title>Registration</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    </head>
    <body>
       <?php if ($loggedInWithVzId): ?>
        <h1>Successuflly logged in with VZ-ID</h1>
        <?php

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $cookie['user_id'] . '?oauth_token=' . $cookie['access_token']);
        curl_setopt($ch, CURLOPT_HTTPGET, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $ret = curl_exec($ch);
        curl_close($ch);

        $userData = json_decode($ret, true);
        var_dump($userData['entry']);
        ?>
       <?php else: ?>
        <h1>Please register or log in</h1>
        <!--
       <?php endif ?>
    </body>
</html>