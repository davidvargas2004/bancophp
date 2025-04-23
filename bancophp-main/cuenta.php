<?php
interface Operaciones {
    public function depositar($monto);
    public function retirar($monto);
    public function consultarSaldo();
}

class Cuenta implements Operaciones {
    protected $numeroCuenta, $nombreCliente, $saldo, $conn;

    public function __construct($numeroCuenta, $nombreCliente, $saldo, $conn) {
        $this->numeroCuenta = $numeroCuenta;
        $this->nombreCliente = $nombreCliente;
        $this->saldo = $saldo;
        $this->conn = $conn;
    }

    public function depositar($monto) {
        $this->saldo += $monto;
        $this->actualizarSaldo();
    }

    public function retirar($monto) {
        // Este se sobreescribe en las hijas
    }

    public function consultarSaldo() {
        return $this->saldo;
    }

    protected function actualizarSaldo() {
        $sql = "UPDATE cuentas SET saldo = $this->saldo WHERE numero_cuenta = $this->numeroCuenta";
        $this->conn->query($sql);
    }
}

class CuentaAhorros extends Cuenta {
    private $interesMensual;

    public function __construct($numeroCuenta, $nombreCliente, $saldo, $conn, $interesMensual) {
        parent::__construct($numeroCuenta, $nombreCliente, $saldo, $conn);
        $this->interesMensual = $interesMensual;
    }

    public function retirar($monto) {
        if ($monto <= $this->saldo) {
            $this->saldo -= $monto;
            $this->actualizarSaldo();
        }
    }

    public function aplicarInteres() {
        $this->saldo += $this->saldo * ($this->interesMensual / 100);
        $this->actualizarSaldo();
    }
}

class CuentaCorriente extends Cuenta {
    public function retirar($monto) {
        $cobro = $monto * 0.004;
        $total = $monto + $cobro;
        if ($this->saldo + 300000 >= $total) {
            $this->saldo -= $total;
            $this->actualizarSaldo();
        }
    }
}
?>
