<?php
include("../connection.php");

function getMahasiswa()
{
    global $connection;
    $query = "SELECT * FROM tb_mahasiswa";
    $response = array();
    $result = mysqli_query($connection, $query);
    while ($row = mysqli_fetch_array($result)) {
        $response[] = array("id" => $row["id"], "nama_mahasiswa" => $row["nama"], "kelas_mahasiswa" => $row["kelas"], "nim_mahasiswa" => $row["nim"]);
    }
    header('Content-Type: application/json');
    echo json_encode($response);
}

function getMahasiswaById($id = 0)
{
    global $connection;
    $query = "SELECT * FROM tb_mahasiswa";
    if ($id != 0) {
        $query .= " WHERE id=" . $id . " LIMIT 1";
    }
    $response = array();
    $result = mysqli_query($connection, $query);
    while ($row = mysqli_fetch_array($result)) {
        $response[] = array("id" => $row["id"], "nama_mahasiswa" => $row["nama"], "kelas_mahasiswa" => $row["kelas"], "nim_mahasiswa" => $row["nim"]);
    }
    header('Content-Type: application/json');
    echo json_encode($response);
}

function insert_mahasiswa()
{
    global $connection;
    $data = json_decode(file_get_contents('php://input'), true);
    $nama = $data["nama"];
    $kelas = $data["kelas"];
    $nim = $data["nim"];
    echo $query = "INSERT INTO tb_mahasiswa SET 
     nama='" . $nama . "', kelas='" . $kelas . "', nim='" . $nim . "'";
    if (mysqli_query($connection, $query)) {
        $response = array(
            'status' => 1,
            'status_message' => 'Employee Added Successfully.'
        );
    } else {
        $response = array(
            'status' => 0,
            'status_message' => 'Employee Addition Failed.'
        );
    }
    header('Content-Type: application/json');
    echo json_encode($response);
}

$db = new dbObject();
$connection = $db->getConnstring();
$request_method = $_SERVER["REQUEST_METHOD"];
switch ($request_method) {
    case 'GET':
        // Retrive Products
        if (!empty($_GET["id"])) {
            $id = intval($_GET["id"]);
            getMahasiswaById($id);
        } else {
            getMahasiswa();
        }
        break;
    case 'POST':
        // Insert Product
        insert_mahasiswa();
        break;
    default:
        // Invalid Request Method
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}
