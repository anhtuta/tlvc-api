<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
date_default_timezone_set('Asia/Ho_Chi_Minh');

// get database connection
include_once '../config/database.php';
include_once '../objects/TlvcOrder.php';
include_once '../objects/Result.php';

$database = new Database();
$conn = $database->getConnection();

$tlvc_order = new TlvcOrder($conn);

// get posted data
$data = json_decode(file_get_contents("php://input"));

// set tlvc_order property values
$tlvc_order->name = !empty($data->name) ? $data->name : "";
$tlvc_order->phone = !empty($data->name) ? $data->phone : "";
$tlvc_order->address = !empty($data->address) ? $data->address : "";
$tlvc_order->order_date = date('Y-m-d H:i:s');
$tlvc_order->product = !empty($data->product) ? $data->product : "";
$tlvc_order->message = !empty($data->message) ? $data->message : "";
$tlvc_order->status = "CHƯA XỬ LÝ";

// create the tlvc_order
if ($tlvc_order->create()) {
    http_response_code(201);
    $res = Result::successRes("TlvcOrder was created");
    echo json_encode($res);
}

// if unable to create the tlvc_order, tell the user
else {
    http_response_code(503);
    $res = Result::failRes("Unable to create tlvc_order");
    echo json_encode($res);
}
