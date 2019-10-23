<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if ("application/json" != $_SERVER["CONTENT_TYPE"]) {
    http_response_code(400);
die(json_encode(["message" => "content must be of type json"] , JSON_PRETTY_PRINT));
}

// // get posted data
$data = json_decode(file_get_contents("php://input"));

?>