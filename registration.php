<?php
    $consumerKey = '0dc2fcd81d7ee4f63b0edc9b39c5b9185149a22b2bac6049';
    $consumerSecret = 'w43HLgQmA9NpBka_nDjg48F4G5GbOuxvmemmBGPSYxwu0UJr';
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

        // setze die URL und andere Optionen
        curl_setopt($ch, CURLOPT_URL, $cookie['user_id'] . '?oauth_token=' . $cookie['access_token']);
        curl_setopt($ch, CURLOPT_HTTPGET, true);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // führe die Aktion aus und gebe die Daten an den Browser weiter
        $ret = curl_exec($ch);

        // schließe den cURL-Handle und gebe die Systemresourcen frei
        curl_close($ch);
        $userData = json_decode($ret, true);
        var_dump($userData['entry']);
        ?>
       <?php else: ?>
        <h1>Please register</h1>
       <?php endif ?>
    </body>
</html>