<?php
require 'global.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
} else {
    echo json_encode(["status" => "error", "message" => "Método inválido"]);
}
