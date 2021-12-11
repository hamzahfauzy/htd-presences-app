<?php

class JwtAuth
{
    static function get()
    {
        if(isset($_COOKIE[config('jwt_cookie_name')]))
        {
            $token = $_COOKIE[config('jwt_cookie_name')];
            return self::decode($token, config('jwt_secret'));
        }

        return [];
    }

    static function encode($payload, $secret)
    {
        $payload = json_encode($payload);
        // Create token header as a JSON string
        $header = json_encode(['typ' => 'JWT', 'alg' => 'HS256']);

        // Encode Header to Base64Url String
        $base64UrlHeader = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));

        // Encode Payload to Base64Url String
        $base64UrlPayload = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));

        // Create Signature Hash
        $signature = hash_hmac('sha256', $base64UrlHeader . "." . $base64UrlPayload, $secret, true);

        // Encode Signature to Base64Url String
        $base64UrlSignature = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));

        // Create JWT
        $jwt = $base64UrlHeader . "." . $base64UrlPayload . "." . $base64UrlSignature;

        return $jwt;
    }

    static function decode($jwt, $secret = 'secret')
    {
        $tokenParts = explode('.', $jwt);
        $header = base64_decode($tokenParts[0]);
        $payload = base64_decode($tokenParts[1]);
        $signature_provided = $tokenParts[2];
    
        return json_decode($payload);
    }

    // static function is_valid($jwt, $secret = 'secret') {
    //     $decode = self::decode($jwt, $secret);
    
    //     // check the expiration time - note this will cause an error if there is no 'exp' claim in the jwt
    //     $expiration = $decode->exp;
    //     $is_token_expired = ($expiration - time()) < 0;
    
    //     // build a signature based on the header and payload using the secret
    //     $base64_url_header = base64url_encode($header);
    //     $base64_url_payload = base64url_encode($payload);
    //     $signature = hash_hmac('SHA256', $base64_url_header . "." . $base64_url_payload, $secret, true);
    //     $base64_url_signature = base64url_encode($signature);
    
    //     // verify it matches the signature provided in the jwt
    //     $is_signature_valid = ($base64_url_signature === $signature_provided);
        
    //     if ($is_token_expired || !$is_signature_valid) {
    //         return FALSE;
    //     } else {
    //         return TRUE;
    //     }
    // }
}