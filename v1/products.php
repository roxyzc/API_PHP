<?php
include("../connection.php");
include("./services.php");

$db = new dbObject();
$connection = $db->getConnstring();
$request_method = $_SERVER["REQUEST_METHOD"];
switch ($request_method) {
    case 'GET':
        // Retrive Products
        if (!empty($_GET["id"])) {
            $id = intval($_GET["id"]);
            get_product($id);
        } else {
            get_products();
        }
        break;
    case 'POST':
        // Insert Product
        insert_product();
        break;
    case 'PUT':
        // Update Product
        $id = intval($_GET["id"]);
        update_product($id);
        break;
    case 'DELETE':
        // Delete Product
        $id = intval($_GET["id"]);
        delete_product($id);
        break;
    default:
        // Invalid Request Method
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}
