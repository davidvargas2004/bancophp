<?php
class Auth {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function registrar($username, $password, $nombre_completo, $rol = 'empleado') {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->conn->prepare("INSERT INTO usuarios (username, password, nombre_completo, rol) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $username, $hashed, $nombre_completo, $rol);
        return $stmt->execute();
    }

    public function login($username, $password) {
        $stmt = $this->conn->prepare("SELECT id, username, password, nombre_completo, rol FROM usuarios WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                return $user;
            }
        }
        return false;
    }
}
?>