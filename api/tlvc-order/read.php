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
$page = isset($_GET['page']) ? $_GET['page'] : 0;
$size = isset($_GET['size']) ? $_GET['size'] : 10;
$sortBy = isset($_GET['sortBy']) ? $_GET['sortBy'] : 'id';
$sortOrder = isset($_GET['sortOrder']) ? $_GET['sortOrder'] : 'desc';

$tlvc_order = new TlvcOrder($conn);
$stmt = $tlvc_order->read($page, $size, $sortBy, $sortOrder);
$stmt2 = $tlvc_order->countTotal();
// $num = $stmt->rowCount();

// tlvc_order array
$tlvc_order_arr = array();
$tlvc_order_arr["list"] = array();

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
    "product" => $product,
    "message" => $message,
    "status" => $status
  );

  array_push($tlvc_order_arr["list"], $tlvc_order_item);
}

$totalCount = 0;
while ($row = $stmt2->fetch(PDO::FETCH_ASSOC)) {
  $totalCount = $row['totalCount'];
}
$totalPages = ceil($totalCount / $size);
$tlvc_order_arr["totalCount"] = intval($totalCount, 10);
$tlvc_order_arr["totalPages"] = $totalPages;

// set response code - 200 OK
http_response_code(200);

// show tlvc_orders data in json format
$res = Result::successRes($tlvc_order_arr);
echo json_encode($res);
