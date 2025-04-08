<?php
class User {
    public $id;
    public $username;
    public $email;
    public $role;

    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function create($username, $email, $role) {
        $stmt = $this->conn->prepare("INSERT INTO user (username, email, role) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $role);
        return $stmt->execute();
    }

    public function getAll() {
        return $this->conn->query("SELECT * FROM user");
    }

    public function update($id, $username, $email, $role) {
        $stmt = $this->conn->prepare("UPDATE user SET username=?, email=?, role=? WHERE id=?");
        $stmt->bind_param("sssi", $username, $email, $role, $id);
        return $stmt->execute();
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM user WHERE id=?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>
