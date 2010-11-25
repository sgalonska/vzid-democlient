<?php
    $consumerKey = 'consumer key';
    $consumerSecret = 'consumer secret';
    $cookieKey = 'vz_' . $consumerKey;
    $requiredFields = array('name', 'emails');
    $redirectUrl = 'http://path/to/vzid-democlient/callback.html';
    $registrationUrl = 'http://path/to/vzid-democlient/registration.php';
?>
<html>
    <head>
        <title>Index</title>
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
        if (c.error) {
            console.log(c);
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