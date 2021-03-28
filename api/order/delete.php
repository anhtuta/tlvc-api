<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// include database and object file
include_once '../config/database.php';
include_once '../objects/TlvcOrder.php';

// get database connection
$database = new Database();
$conn = $database->getConnection();

// prepare tlvc_order object
$tlvc_order = new TlvcOrder($conn);

// get tlvc_order id
$data = json_decode(file_get_contents("php://input"));

// set tlvc_order id to be deleted
$tlvc_order->id = $data->id;

// delete the tlvc_order
if ($tlvc_order->delete()) {

  // set response code - 200 ok
  http_response_code(200);

  // tell the user
  echo json_encode(array("message" => "TlvcOrder was deleted."));
}

// if unable to delete the tlvc_order
else {

  // set response code - 503 service unavailable
  http_response_code(503);

  // tell the user
  echo json_encode(array("message" => "Unable to delete tlvc_order."));
}
