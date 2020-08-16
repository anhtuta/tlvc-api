<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

// database connection will be here
// include database and object files
include_once '../config/database.php';
include_once '../objects/TlvcOrder.php';
include_once '../objects/Result.php';

// instantiate database
$database = new Database();
$conn = $database->getConnection();

$tlvc_order = new TlvcOrder($conn);
$stmt = $tlvc_order->read();
$stmt2 = $tlvc_order->countTotal();
// $num = $stmt->rowCount();

// tlvc_order array
$tlvc_order_arr = array();
$tlvc_order_arr["records"] = array();

// retrieve our table contents
// fetch() is faster than fetchAll()
// http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
  // extract row
  // this will make $row['name'] to
  // just $name only
  extract($row);

  $tlvc_order_item = array(
    "id" => $id,
    "name" => $name,
    "phone" => $phone,
    "address" => $address,
    "order_date" => $order_date,
    "message" => $message,
    "status" => $status
  );

  array_push($tlvc_order_arr["records"], $tlvc_order_item);
}

while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
  $tlvc_order_arr["totalCount"] = $row['totalCount'];
}

// set response code - 200 OK
http_response_code(200);

// show tlvc_orders data in json format
$res = Result::successRes($tlvc_order_arr);
echo json_encode($res);
