<?php

/**
 * Class VzId
 *
 * @author sgalonska
 * 
 */
class VzId {

    public function authorize()
    {
        $baseString = $access_token . $issued_at . $user_id . $expires_in;
        $signature = base64_encode(hash_hmac('sha1', $baseString, $consumerSecret, true));;
        if ($signature !== $retrievedSignature) {
            throw new Exception('invalid signature');
        }
    }
    
}