<?php
session_start();
include('dbcon.php');
date_default_timezone_set('Asia/Manila');
$date = date("m/d/Y H:i");

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

//Reject Orders
if (isset($_POST['reject_btn'])) {
    $key = $_POST['reject_btn'];

    $status = "rejected";

    if (empty($_POST["comment"])) {
        $comment = "";
    } else {
        $comment = $_POST["comment"];
    }

    $updateData = [
        'status' => $status,
        'rejectdate' =>  $date,
        'remarks' =>  $comment,
        'cancelledby' => 'Seller',
    ];


    $ref_table = '/Orders/' . $key;
    $updatequery_result = $database->getReference($ref_table)->update($updateData);

    if ($updatequery_result) {
        $_SESSION['orders'] = "Order has been rejected";
        header('Location: pending-orders.php');
    } else {
        $_SESSION['orders'] = "Order has been not rejected";
        header('Location: pending-orders.php');
    }
}

//Approve Orders
if (isset($_POST['approve_btn'])) {
    list($key, $userid, $cartId) = explode('|', $_POST['approve_btn']);
    $status = "approved";

    $ref_tables = '/Notifications/' . $userid . '/pending';


    $updateData = [
        'status' => $status,
        'confirmdate' =>  $date,
        'status_userid' => $status . '_' . $userid,
    ];

    $postData = [
        'ordersid' => $key,
        'userid' => $userid,
        'cartId' => $cartId,
        'notify' => false,
    ];


    $postquery_result = $database->getReference($ref_tables)->set($postData);

    $postquery_key = $postquery_result->getKey();

    $ref_table = '/Orders/' . $key;
    $updatequery_result = $database->getReference($ref_table)->update($updateData);

    if ($updatequery_result) {
        $_SESSION['orders'] = "Order has been approved";
        header('Location: pending-orders.php');
    } else {
        $_SESSION['orders'] = "Order has been not approved";
        header('Location: pending-orders.php');
    }
}

//Shipped Orders
if (isset($_POST['shipping_btn'])) {
    list($key, $userid, $cartId) = explode('|', $_POST['shipping_btn']);
    $status = "receiving";

    $ref_tables = '/Notifications/' . $userid . '/shipping';

    $updateData = [
        'status' =>  $status,
        'shipdate' =>  $date,
        'status_userid' => $status . '_' . $userid,
    ];

    $postData = [
        'ordersid' => $key,
        'userid' => $userid,
        'cartId' => $cartId,
        'notify' => false,
    ];



    $postquery_result = $database->getReference($ref_tables)->set($postData);


    $ref_table = '/Orders/' . $key;
    $updatequery_result = $database->getReference($ref_table)->update($updateData);

    if ($updatequery_result) {
        $_SESSION['orders'] = "Order has been shipped";
        header('Location: shipping-orders.php');
    } else {
        $_SESSION['orders'] = "Order has been shipped";
        header('Location: shipping-orders.php');
    }
}


//Received Orders
if (isset($_POST['receiving_btn'])) {
    list($key, $userid, $cartId) = explode('|', $_POST['receiving_btn']);
    $status = "completed";

    $ref_tables = '/Notifications/' . $userid . '/receiving';

    $postData = [
        'ordersid' => $key,
        'userid' => $userid,
        'cartId' => $cartId,
        'notify' => false,
    ];

    $updateData = [
        'status' => $status,
        'notify' => '0',
    ];

    $postquery_result = $database->getReference($ref_tables)->set($postData);

    $ref_table = '/Orders/' . $key;
    $updatequery_result = $database->getReference($ref_table)->update($updateData);

    if ($updatequery_result) {
        $_SESSION['orders'] = "Order has been received";
        header('Location: receiving-orders.php');
    } else {
        $_SESSION['orders'] = "Order has been received";
        header('Location: receiving-orders.php');
    }
}

//Products Update
if (isset($_POST['update_product'])) {

    $key = $_POST['key'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $description = $_POST['description'];
    $status = $_POST['status'];
    $image = $_POST['image'];

    $updateData = [
        'name' => $name,
        'price' => $price,
        'category' => $category,
        'description' => $description,
        'status' => $status,
        'image' => $image
    ];

    $ref_table = '/Products/' . $key;
    $updatequery_result = $database->getReference($ref_table)->update($updateData);

    if ($updatequery_result) {
        $_SESSION['status'] = "Product Updated Sucessfully";
        header('Location: products.php');
    } else {
        $_SESSION['status'] = "Product Not Updated";
        header('Location: products.php');
    }
}

//Products Delete
if (isset($_POST['delete_btn'])) {

    $del_id = $_POST['delete_btn'];
    $ref_table = '/Products/' . $del_id;
    $deletequery_result = $database->getReference($ref_table)->remove();

    if ($deletequery_result) {
        $_SESSION['status'] = "Product Deleted Sucessfully";
        header('Location: products.php');
    } else {
        $_SESSION['status'] = "Product Not Deleted";
        header('Location: products.php');
    }
}

//Products Create
if (isset($_POST['save_product'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $status = $_POST['status'];
    $image = $_POST['image'];

    $postData = [
        'name' => $name,
        'description' =>  $description,
        'price' =>  $price,
        'category' => $category,
        'status' =>  $status,
        'image' => $image
    ];

    $ref_table = "/Products";
    $postRef_result = $database->getReference($ref_table)->push($postData);


    if ($postRef_result) {
        $_SESSION['status'] = "Product Added Sucessfully";
        header('Location: products.php');
    } else {
        $_SESSION['status'] = "Product Not Added";
        header('Location: products.php');
    }
}
