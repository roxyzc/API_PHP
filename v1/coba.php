<?php
include("../connection.php");

function getCoba1()
{
    global $connection;
    $query = "SELECT * FROM tb_coba";
    $response = array();
    $result = mysqli_query($connection, $query);
    while ($row = mysqli_fetch_array($result)) {
        $response[] = array("id" => $row["id"], "nama" => $row["coba"]);
    }
    header('Content-Type: application/json');
    echo json_encode($response);
}

function getCoba2($id = 0)
{
    global $connection;
    $query = "SELECT * FROM tb_coba";
    if ($id != 0) {
        $query .= " WHERE id=" . $id . " LIMIT 1";
    }
    $response = array();
    $result = mysqli_query($connection, $query);
    while ($row = mysqli_fetch_array($result)) {
        $response[] = array("coba" => $row["coba"]);
    }
    header('Content-Type: application/json');
    echo json_encode($response);
}

function insert_employee()
{
    global $connection;
    $data = json_decode(file_get_contents('php://input'), true);
    $nama = $data["nama"];
    echo $query = "INSERT INTO tb_coba SET 
     coba='" . $nama . "'";
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
            getCoba2($id);
        } else {
            getCoba1();
        }
        break;
    case 'POST':
        // Insert Product
        insert_employee();
        break;
    default:
        // Invalid Request Method
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}
