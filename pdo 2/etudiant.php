<?php
class Etudiant {
    public $id;
    public $name;
    public $birthday;
    public $image;
    public $section_id;

    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function create($name, $birthday, $image, $section_id) {
        $stmt = $this->conn->prepare("INSERT INTO etudiant (name, birthday, image, section_id) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("sssi", $name, $birthday, $image, $section_id);
        return $stmt->execute();
    }

    public function getAll() {
        return $this->conn->query("SELECT * FROM etudiant");
    }

    public function update($id, $name, $birthday, $image, $section_id) {
        $stmt = $this->conn->prepare("UPDATE etudiant SET name=?, birthday=?, image=?, section_id=? WHERE id=?");
        $stmt->bind_param("sssii", $name, $birthday, $image, $section_id, $id);
        return $stmt->execute();
    }

    public function delete($id) {
        $stmt = $this->conn->prepare("DELETE FROM etudiant WHERE id=?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>