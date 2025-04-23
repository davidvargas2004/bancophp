<?php

// toca crear base de datos en maria db
class Conexion {
    private $host = "localhost";
    private $db = "banco_hbc";
    private $user = "root";
    private $pass = "";
    private $port = 3307; 
    public $conn;

    public function conectar() {
        $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->db, $this->port);
        if ($this->conn->connect_error) {
            die("Conexión fallida: " . $this->conn->connect_error);
        }
        return $this->conn;
    }
}
?>
