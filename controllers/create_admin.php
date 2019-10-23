
<?php
require_once '../http_headers.php';
require_once '../admin.php';

if ((null !=$data) && isset($data)) {
    $admin = new Admin();
    $admin -> setName($data -> name);
    $admin -> setPassword($data -> password);
    $admin -> setEmail($data -> email);

    if (!($admin -> emailExists($admin -> getEmail()))) {
        if($admin -> createAdmin($admin)){
            http_response_code(200);
                die(json_encode(["message" => "user successfully created"]));
             }else{
                 http_response_code(403);
                 die(json_encode(["message" => "failed to create user"]));
             }
         
    }else{
    http_response_code(208);
    die(json_encode(["message" => "email already exists"] , JSON_PRETTY_PRINT));
    }
    

}else{
    echo json_encode(["message" => "missing required data"]);
}




?>