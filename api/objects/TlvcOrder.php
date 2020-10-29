<?php

// Ban đầu bảng này tên là tlvc_order, nhưng sau đó có thêm cột để lưu cả lục bình order nữa
// Vậy nên mới đổi tên bảng thành landing_page_order, nhưng object cứ giữ nguyên,
// do ko muốn sửa nhiều chỗ
class TlvcOrder
{
  // database connection and table name
  private $conn;
  private $table_name = "landing_page_order";

  // object properties
  public $id;
  public $name;
  public $phone;
  public $address;
  public $order_date;
  public $product;
  public $message;
  public $status;
  public $idList;

  // constructor with $conn as database connection
  public function __construct($conn)
  {
    $this->conn = $conn;
  }

  function read($page, $size, $sortBy, $sortOrder)
  {
    $offset = $page * $size;
    $query = "SELECT * FROM " .
      $this->table_name .
      " ORDER BY " . $sortBy . " " . $sortOrder .
      " LIMIT " . $size . " OFFSET " . $offset;
    $stmt = $this->conn->prepare($query);
    $stmt->execute();

    return $stmt;
  }

  function countTotal()
  {
    $query = "SELECT COUNT(*) AS totalCount FROM " . $this->table_name;
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt;
  }

  function create()
  {
    $query = "INSERT INTO " . $this->table_name . "
          SET name=:name, phone=:phone, address=:address, " .
      "order_date=:order_date, message=:message, status=:status";
    $stmt = $this->conn->prepare($query);

    $this->name = htmlspecialchars(strip_tags($this->name));
    $this->phone = htmlspecialchars(strip_tags($this->phone));
    $this->address = htmlspecialchars(strip_tags($this->address));
    $this->order_date = htmlspecialchars(strip_tags($this->order_date));
    $this->message = htmlspecialchars(strip_tags($this->message));
    $this->status = htmlspecialchars(strip_tags($this->status));

    // bind values
    $stmt->bindParam(":name", $this->name);
    $stmt->bindParam(":phone", $this->phone);
    $stmt->bindParam(":address", $this->address);
    $stmt->bindParam(":order_date", $this->order_date);
    $stmt->bindParam(":message", $this->message);
    $stmt->bindParam(":status", $this->status);

    if ($stmt->execute()) {
      return true;
    }

    return false;
  }

  function update()
  {
    $query = "UPDATE " . $this->table_name .
      " SET " .
      "name = :name, " .
      "phone = :phone, " .
      "address = :address, " .
      "order_date = :order_date, " .
      "message = :message, " .
      "status = :status " .
      "WHERE " .
      "id = :id";

    $stmt = $this->conn->prepare($query);

    $this->name = htmlspecialchars(strip_tags($this->name));
    $this->phone = htmlspecialchars(strip_tags($this->phone));
    $this->address = htmlspecialchars(strip_tags($this->address));
    $this->order_date = htmlspecialchars(strip_tags($this->order_date));
    $this->message = htmlspecialchars(strip_tags($this->message));
    $this->status = htmlspecialchars(strip_tags($this->status));
    $this->id = htmlspecialchars(strip_tags($this->id));

    // bind new values
    $stmt->bindParam(':name', $this->name);
    $stmt->bindParam(':phone', $this->phone);
    $stmt->bindParam(':address', $this->address);
    $stmt->bindParam(':order_date', $this->order_date);
    $stmt->bindParam(':message', $this->message);
    $stmt->bindParam(':status', $this->status);
    $stmt->bindParam(':id', $this->id);

    if ($stmt->execute()) {
      return true;
    }

    return false;
  }

  function updateStatus()
  {
    $this->status = htmlspecialchars(strip_tags($this->status));
    $this->idList = htmlspecialchars(strip_tags($this->idList));

    $query = "UPDATE " . $this->table_name .
      " SET " .
      "status = :status " .
      "WHERE " .
      "id IN (" . $this->idList . ")";

    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':status', $this->status);
    if ($stmt->execute()) {
      return true;
    }

    return false;
  }

  function delete()
  {
    $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
    $stmt = $this->conn->prepare($query);
    $this->id = htmlspecialchars(strip_tags($this->id));
    $stmt->bindParam(1, $this->id);

    if ($stmt->execute()) {
      return true;
    }

    return false;
  }
}
