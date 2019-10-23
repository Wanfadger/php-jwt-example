
<?php
require_once '../http_headers.php';
require_once '../admin.php';
require_once '../token.php';

if ((null !=$data) && isset($data)) {
    $admin = new Admin();
   //check if password is correct and email exists
      
     $user = $admin -> fetchAdminByEmail($data -> email);

     if ((null != $user) && password_verify($data -> password , $user["password"])) {
        //generate token
        $token  = Token::createTokenInstance() -> generateToken($user);

        http_response_code(200);
        die(json_encode(["token" => $token , "message" => "successfully logged in"]));
     }else{
         http_response_code(404);
         die(json_encode(["message" => "invalid email or password"]));
     }


    //generate a token



}else{
    echo json_encode(["message" => "missing required data"]);
}




?>