<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// include database and object files
include_once '../config/database.php';
include_once '../objects/TlvcOrder.php';
include_once '../objects/Result.php';

$database = new Database();
$conn = $database->getConnection();

$tlvc_order = new TlvcOrder($conn);

// get id of tlvc_order to be edited
$data = json_decode(file_get_contents("php://input"));

// set ID property of tlvc_order to be edited
$tlvc_order->id = $data->id;

// set tlvc_order property values
$tlvc_order->name = $data->name;
$tlvc_order->phone = $data->phone;
$tlvc_order->address = $data->address;
$tlvc_order->order_date = $data->order_date;
$tlvc_order->message = $data->message;
$tlvc_order->status = $data->status;

// update the tlvc_order
if ($tlvc_order->update()) {
  http_response_code(200);
  $res = Result::successRes("TlvcOrder was updated");
  echo json_encode($res);
}

// if unable to update the tlvc_order, tell the user
else {
  http_response_code(503);
  $res = Result::failRes("Unable to update tlvc_order");
  echo json_encode($res);
}
