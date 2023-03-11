<?php
include("../connection.php");

function get_employees()
{
    global $connection;
    $query = "SELECT * FROM tb_employee";
    $response = array();
    $result = mysqli_query($connection, $query);
    while ($row = mysqli_fetch_array($result)) {
        $response[] = array("nama" => $row["employee_name"], "salary" => $row["employee_salary"], "age" => $row["employee_age"]);
    }
    header('Content-Type: application/json');
    echo json_encode($response);
}

function get_employee($id = 0)
{
    global $connection;
    $query = "SELECT * FROM tb_employee";
    if ($id != 0) {
        $query .= " WHERE id=" . $id . " LIMIT 1";
    }
    $response = array();
    $result = mysqli_query($connection, $query);
    while ($row = mysqli_fetch_array($result)) {
        $response[] = array("nama" => $row["employee_name"], "salary" => $row["employee_salary"], "age" => $row["employee_age"]);
    }
    header('Content-Type: application/json');
    echo json_encode($response);
}

function insert_employee()
{
    global $connection;
    $data = json_decode(file_get_contents('php://input'), true);
    $employee_name = $data["employee_name"];
    $employee_salary = $data["employee_salary"];
    $employee_age = $data["employee_age"];
    echo $query = "INSERT INTO tb_employee SET 
     employee_name='" . $employee_name . "', 
     employee_salary='" . $employee_salary . "', 
    employee_age='" . $employee_age . "'";
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

function update_employee($id)
{
    global $connection;
    $post_vars = json_decode(file_get_contents("php://input"), true);
    $employee_name = $post_vars["employee_name"];
    $employee_salary = $post_vars["employee_salary"];
    $employee_age = $post_vars["employee_age"];
    $query = "UPDATE tb_employee SET employee_name='" . $employee_name . "', 
     employee_salary='" . $employee_salary . "', 
    employee_age='" . $employee_age . "' WHERE id=" . $id;
    if (mysqli_query($connection, $query)) {
        $response = array(
            'status' => 1,
            'status_message' => 'Employee Updated Successfully.'
        );
    } else {
        $response = array(
            'status' => 0,
            'status_message' => 'Employee Updation Failed.'
        );
    }
    header('Content-Type: application/json');
    echo json_encode($response);
}

function delete_employee($id)
{
    global $connection;
    $query = "DELETE FROM tb_employee WHERE id=" . $id;
    if (mysqli_query($connection, $query)) {
        $response = array(
            'status' => 1,
            'status_message' => 'Employee Deleted Successfully.'
        );
    } else {
        $response = array(
            'status' => 0,
            'status_message' => 'Employee Deletion Failed.'
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
            get_employee($id);
        } else {
            get_employees();
        }
        break;
    case 'POST':
        // Insert Product
        insert_employee();
        break;
    case 'PUT':
        // Update Product
        $id = intval($_GET["id"]);
        update_employee($id);
        break;
    case 'DELETE':
        // Delete Product
        $id = intval($_GET["id"]);
        delete_employee($id);
        break;
    default:
        // Invalid Request Method
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}
