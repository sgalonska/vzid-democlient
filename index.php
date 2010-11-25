<?php
    $consumerKey = '0dc2fcd81d7ee4f63b0edc9b39c5b9185149a22b2bac6049';
    $consumerSecret = 'w43HLgQmA9NpBka_nDjg48F4G5GbOuxvmemmBGPSYxwu0UJr';
    $cookieKey = 'vz_' . $consumerKey;
    $requiredFields = array('name', 'emails');
    $redirectUrl = 'http://localhost:8062/vzid-democlient/callback.html';
    $registrationUrl = 'http://localhost:8062/vzid-democlient/registration.php';
?>
<html>
    <head>
        <title>Callback</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    </head>
    <body>
        <script src="http://static.pe.studivz.net/Js/id/v2/library.js"
        data-authority="platform-redirect.vz-modules.net/r"
        data-authorityssl="platform-redirect.vz-modules.net/r" type="text/javascript">
        </script>
    </body>
    <script type="text/javascript">
    function logResponse(c) {
        if (c.error) { alert('error');
            return;
        }

        var parameters = 'access_token=' + c.access_token;
        parameters += '&user_id=' + c.user_id;
        parameters += '&signature=' + c.signature;
        parameters += '&issued_at=' + c.issued_at;

        document.cookie = '<?php echo $cookieKey ?>' + '=' +  encodeURIComponent(parameters);
        document.location.href = '<?php echo $registrationUrl ?>';
    }
    </script>
    
    <script type="vz/login">
       client_id : <?php echo $consumerKey . PHP_EOL ?>
       redirect_uri : <?php echo $redirectUrl . PHP_EOL ?>
       callback : logResponse
       fields : <?php echo implode(',', $requiredFields) . PHP_EOL ?>
    </script>
</html>