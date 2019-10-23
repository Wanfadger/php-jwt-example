
<?php
require_once '../http_headers.php';
require_once '../admin.php';
require_once '../token.php';

if ((null != $data) && isset($data)) {
    $admin = new Admin();
      //get token data
      $token = Token::createTokenInstance() -> readTokenData();
      $admin -> setId($token -> userId);
      $admin -> setName($data -> name);
      $admin -> setEmail($data -> email);
      $admin -> setPassword($data -> password);

      if ($admin -> updateAdmin($admin)) {
         //regenerate token
         $newToken = Token::createTokenInstance() -> generateToken(["id" => $admin -> getId() , "name" => $admin -> getName() , "email"=> $admin->getEmail()]);
        http_response_code(200);
        die(json_encode(["message" => "user successfully updated" , "token" => $newToken]));
        
      }else{
          http_response_code(403);
          json_encode(["message" => "failed to update"]);
      }
      
}else{
    die(json_encode(["message" => "missing required data"]));
}

  
?>