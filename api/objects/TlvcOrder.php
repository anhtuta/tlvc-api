<?php
class TlvcOrder
{
  // database connection and table name
  private $conn;
  private $table_name = "tlvc_order";

  // object properties
  public $id;
  public $name;
  public $phone;
  public $address;
  public $order_date;
  public $message;
  public $status;
  public $idList;

  // constructor with $conn as database connection
  public function __construct($conn)
  {
    $this->conn = $conn;
  }

  function read()
  {
    $page = isset($_GET['page']) ? $_GET['page'] : 0;
    $size = isset($_GET['size']) ? $_GET['size'] : 10;
    $offset = $page * $size;
    $query = "SELECT * FROM " .
      $this->table_name .
      " ORDER BY order_date DESC" .
      " LIMIT " . $size . " OFFSET " . $offset;

    $stmt = $this->conn->prepare($query);
    $stmt->execute();

    return $stmt;
  }

  function countTotal()
  {
    $query = "SELECT COUNT(*) AS totalCount FROM tlvc_order";
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
      "id IN (" . $this->idList . ")" ;

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
