<?php

function get_products()
{
    global $connection;
    $query = "SELECT * FROM tb_products";
    $response = array();
    $result = mysqli_query($connection, $query);
    while ($row = mysqli_fetch_array($result)) {
        $response[] = array("id" => $row["id"], "nama_product" => $row["nama"], "harga_product" => $row["harga"], "stok_product" => $row["stok"]);
    }
    header('Content-Type: application/json');
    echo json_encode($response);
}

function get_product($id = 0)
{
    global $connection;
    $query = "SELECT * FROM tb_products";
    if ($id != 0) {
        $query .= " WHERE id=" . $id . " LIMIT 1";
    }
    $response = array();
    $result = mysqli_query($connection, $query);
    while ($row = mysqli_fetch_array($result)) {
        $response[] = array("id" => $row["id"], "nama_product" => $row["nama"], "harga_product" => $row["harga"], "stok_product" => $row["stok"]);
    }
    header('Content-Type: application/json');
    echo json_encode($response);
}

function insert_product()
{
    global $connection;
    $data = json_decode(file_get_contents('php://input'), true);
    $nama_product = $data["nama"];
    $harga_product = $data["harga"];
    $stok_product = $data["stok"];
    echo $query = "INSERT INTO tb_products SET 
     nama='" . $nama_product . "', 
     harga='" . $harga_product . "', 
    stok='" . $harga_product . "'";
    if (mysqli_query($connection, $query)) {
        $response = array(
            'status' => 1,
            'status_message' => 'product Added Successfully.'
        );
    } else {
        $response = array(
            'status' => 0,
            'status_message' => 'product Addition Failed.'
        );
    }
    header('Content-Type: application/json');
    echo json_encode($response);
}

function update_product($id)
{
    global $connection;
    $data = json_decode(file_get_contents('php://input'), true);
    $nama_product = $data["nama"];
    $harga_product = $data["harga"];
    $stok_product = $data["stok"];
    $query = "UPDATE tb_products SET nama='" . $nama_product . "', 
     harga='" . $harga_product . "', 
    stok='" . $stok_product . "' WHERE id=" . $id;
    if (mysqli_query($connection, $query)) {
        $response = array(
            'status' => 1,
            'status_message' => 'product Updated Successfully.'
        );
    } else {
        $response = array(
            'status' => 0,
            'status_message' => 'product Updation Failed.'
        );
    }
    header('Content-Type: application/json');
    echo json_encode($response);
}

function delete_product($id)
{
    global $connection;
    $query = "DELETE FROM tb_products WHERE id=" . $id;
    if (mysqli_query($connection, $query)) {
        $response = array(
            'status' => 1,
            'status_message' => 'product Deleted Successfully.'
        );
    } else {
        $response = array(
            'status' => 0,
            'status_message' => 'product Deletion Failed.'
        );
    }
    header('Content-Type: application/json');
    echo json_encode($response);
}
