<?php
include("../connection.php");
include("./function.php");

$db = new dbObject();
$connection = $db->getConnstring();
$request_method = $_SERVER["REQUEST_METHOD"];
switch ($request_method) {
    case 'GET':
        // Retrive mahasiswa
        if (!empty($_GET["id"])) {
            $id = intval($_GET["id"]);
            getMahasiswaById($id);
        } else {
            getMahasiswa();
        }
        break;
    case 'POST':
        // Insert mahasiswa
        insert_mahasiswa();
        break;
    case 'PUT':
        // Update mahasiswa
        $id = intval($_GET["id"]);
        update_mahasiswa($id);
        break;
    case 'DELETE':
        // Delete mahasiswa
        $id = intval($_GET["id"]);
        delete_mahasiswa($id);
        break;
    default:
        // Invalid Request Method
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}
