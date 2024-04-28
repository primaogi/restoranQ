<?php

include("../config/database.php");

if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $name = $_POST['customer_name'];
    $status = $_POST['status'];
    
    try
    {
        if($id){
        $sql = "UPDATE receipts SET customer_name='$name', status='$status' WHERE id=$id";
    }else {
    $sql = "INSERT INTO receipts(customer_name, status) VALUES ('$name', '$status')";
    
    }
    $result = mysqli_query($db, $sql);

    if ($result) {
        header("Location: index.php?success=Data tersimpan");
        } else {
            header("Location: index.php?error=Data tidak tersimpan");
        }
    } catch (Exception $exception) {
        header('Location: index.php?error=' . $exception->getMessage());
    }
    
    
    }
?>