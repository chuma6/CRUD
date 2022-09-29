<?php
    class Conexion{
        var $servername;
        var $database;
        var $username;
        var $password;

        function __construct($servername, $database, $username, $password){
            $this->servername = $servername;
            $this->database = $database;
            $this->username = $username;
            $this->password = $password;
        }

        public function conectar(){
            $conn = mysqli_connect($this->servername, $this->username, $this->password, $this->database);

            if (!$conn) {
                die("<br>Conexión fallida" . mysqli_connect_error());
            }else{
                return $conn;
            }
        }

        public function desconectar($conn){
            mysqli_close($conn);
        }
    }
?>

