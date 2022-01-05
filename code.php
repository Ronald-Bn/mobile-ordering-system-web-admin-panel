<?php
session_start();
include('dbcon.php');
date_default_timezone_set('Asia/Manila');
$date = date("m/d/Y H:i");
$reportDate = date("m/d/Y");

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

//Reject Orders
if (isset($_POST['reject_btn'])) {
    list($key, $userid, $cartId) = explode('|', $_POST['key']);
    $rej_reason = $_POST['rej_reason'];
    $comment = $_POST['comment'];
    $status = "rejected";


    if ($rej_reason == "Others") {
        $rej_reason = $comment;
    } else {
        $rej_reason = $rej_reason;
    }

    $updateData = [
        'status' => $status,
        'rejectdate' =>  $date,
        'rejected' => $reportDate,
        'remarks' =>  $rej_reason,
        'status_userid' => $status . '_' . $userid,
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
        'approved' => $reportDate,
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
        'shipping' => $reportDate,
        'status_userid' => $status . '_' . $userid,
        'notify' => "0",
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
        'notify' => true,
    ];

    $updateData = [
        'received' => $reportDate,
        'notify' => '1',
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
