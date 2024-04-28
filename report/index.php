<?php include("../layout/header.php");

$sql = "SELECT 
r.id, 
r.customer_name, 
r.status, 
r.receipt_date, 
rd.price, 
u.name 
FROM receipts r 
JOIN receipt_details rd 
ON r.id = rd.receipt_id 
JOIN users u ON r.user_id = u.id
ORDER BY r.receipt_date DESC
LIMIT 1000";

$query = mysqli_query($db, $sql);

?>

<div class="container">
    <p class="alert alert-success">Selamat Datang <span class="text-primary fw-bolder"><?= $_SESSION['name']; ?></span> di Halaman Report</p>
    <?php
    if (isset($_GET['error'])) {
    ?>
        <div class="alert alert-danger">
            <?= $_GET['error'] ?>
        </div>
    <?php
    }
    ?>
    <?php
    if (isset($_GET['success'])) {
    ?>
        <div class="alert alert-success">
            <?= $_GET['success'] ?>
        </div>
    <?php
    }
    ?>
    <div class="container text-center mt-5">
        <h1 class="display-4">Today Report</h1>
    </div>
    <table id="my-datatables" class="table table-striped table-bordered table-responsive">
        <thead>
            <tr>
                <th>No</th>
                <th>Date</th>
                <th>Name</th>
                <th>Price</th>
                <th>Status</th>
                <th>User</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 1;
            while ($receipts = mysqli_fetch_array($query)) {
            ?>
                <tr>
                    <td><?= $i; ?></td>
                    <td><?= $receipts['receipt_date']; ?></td>
                    <td><?= $receipts['customer_name']; ?></td>
                    <td><?= $receipts['price']; ?></td>
                    <td><?= $receipts['status']; ?></td>
                    <td><?= $receipts['name']; ?></td>
                    <td>
                    </td>
                </tr>
            <?php $i++;
            } ?>
        </tbody>
    </table>
</div>

<?php include("../layout/footer.php"); ?>
