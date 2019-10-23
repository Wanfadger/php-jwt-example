
<?php
require_once '../http_headers.php';
require_once '../admin.php';
require_once '../token.php';
  
    //get token data
    $token = Token::createTokenInstance() -> readTokenData();
    http_response_code(200);
    die(json_encode(["message" => "access granted" , "data" => ["name" => $token -> name ,"id" => $token -> userId , $token ->email ]]));
    print_r($token);

?>