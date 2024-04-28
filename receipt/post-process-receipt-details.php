<?php

include("../config/database.php");

$sql = "SELECT c.id, c.name, rd.note, rd.price, rd.amount
FROM categories c
JOIN receipt_details rd ON c.id = receipt_details.id";
$result = mysqli_query($db, $sql);
$categories_list = mysqli_fetch_all($result, MYSQLI_ASSOC);

if (isset($_POST['submit'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $categories = $_POST['category_id'];
    $note = $_POST['note'];
    $price = $_POST['price'];
    $price = $_POST['amount'];
    $total = $_POST['total'];
    try
    {
        if($id){
        $sql = "UPDATE receipt_details SET name='$name', category_id='$categories', note='$note', price='$price',
                amount='$amount', total='$total' WHERE id=$id";
    }else {
    $sql = "INSERT INTO menus(name, category_id, note, price, amount, total) VALUES ('$name', '$categories', 
            '$note', '$price', '$amount', '$total')";
    
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