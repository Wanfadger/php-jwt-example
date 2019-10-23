<?php

require_once 'vendor/firebase/php-jwt/src/JWT.php';
require_once 'vendor/firebase/php-jwt/src/BeforeValidException.php';
require_once 'vendor/firebase/php-jwt/src/ExpiredException.php';
require_once 'vendor/firebase/php-jwt/src/BeforeValidException.php';
require_once 'vendor/firebase/php-jwt/src/SignatureInvalidException.php';

use Firebase\JWT\JWT;

class Token {

private static $token = null;
private $secretKey = "JWTAPI1";

public static function createTokenInstance(){
    if (null == self::$token) {
        self::$token = new Token;
    }
    return self::$token;
}

   public function generateToken($data){
        
        $payload = [
            "iat" => time() , //when token is generated
            "iss" => "http://wewa.org.com" , //which user issued it
            "aud" => "http://wewa.users.com" , //target which audience
             "exp" => time() +(24*60) , //when the toke will expire , after 60 seconds(minute)
             "data" => [
                 "userId" => $data["id"] ,
                  "email" => $data["email"] , 
                  "name"=> $data["name"] 
                  ] // data
        ];
        //generate token
         $token = JWT::encode($payload , $this -> secretKey);
         
            return $token;
    }


   private function getAuthorizationHeader(){
        $headers = null;
       
        if (isset($_SERVER['Authorization'])) {
          $headers = trim($_SERVER["Authorization"]);
        }elseif (isset($_SERVER["HTTP_AUTHORIZATION"])) {
          //Nginx or fast CGI
          $headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
        }elseif (function_exists('apache_request_headers')) {
          $requestHeaders = apache_request_headers();
          /**
           * Server-side fix for bug in old Android versions (a nice side-effect of this fix means 
           * we don't care about capitalization for Authorization)
           */
          $requestHeaders = array_combine(array_map('ucwords' , array_keys($requestHeaders)) , array_values($requestHeaders));
         
          if (isset($requestHeaders['Authorization'])) {
            $headers = trim($requestHeaders['Authorization']);
          }
        }
        
         return $headers;
      }
  

   public function getBearerToken(){
        $headers = $this -> getAuthorizationHeader();
        //Header: get access token from header
      
        if (!empty($headers)) {
          if (preg_match("/Bearer\s(\S+)/" , $headers , $matches)) {
            return $matches[1];
          }
        }else{
          $this -> throwError('Access Token Not Found');
        }
      }

      public function readTokenData(){
          try {
              $token = $this -> getBearerToken();
              if (empty($token)) {
              //access denied
              http_response_code(401);
              return ["message" => "Access denied"];         
              }

              $data = JWT::decode($token , $this -> secretKey , ['HS256']);
             return $data -> data;
          } catch (\Throwable $th) {
              //access denied
              http_response_code(401);
              return ["error"=> $th -> getMessage() , "message" => "Access denied"];
          }
      }


}


?>