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

$data = json_decode(file_get_contents("php://input"));

$tlvc_order = new TlvcOrder($conn);
$tlvc_order->idList = $data->idList;
$tlvc_order->status = $data->status;

if ($tlvc_order->updateStatus()) {
  http_response_code(200);
  $res = Result::successRes("Status of List of TlvcOrder were updated");
  echo json_encode($res, JSON_UNESCAPED_UNICODE);
} else {
  http_response_code(503);
  $res = Result::failRes("Unable to update tlvc_order");
  echo json_encode($res, JSON_UNESCAPED_UNICODE);
}
