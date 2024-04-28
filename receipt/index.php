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
    <p class="alert alert-success">Selamat Datang <span class="text-primary fw-bolder"><?= $_SESSION['name']; ?></span> di Receipt List</p>
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
        <h1 class="display-4">Receipt List</h1>
    </div>
    <a href="form.php" class="btn btn-primary mb-3"><i class="bi bi-person-fill-add"></i> Add Data</a>
    <table id="my-datatables" class="table table-striped table-bordered table-responsive">
        <thead>
            <tr>
                <th>No</th>
                <th>Date</th>
                <th>Name</th>
                <th>Price</th>
                <th>Status</th>
                <th>User</th>
                <th class="col-md-2">Action</th>
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
                        <div class="d-flex">
                            <a href="form.php?id=<?= $receipts["id"]; ?>" class="btn btn-sm btn-warning me-2">Edit</a>
                            <form action="delete-process.php" method="post">
                                <input type="hidden" name="id" value="<?= $receipts["id"]; ?>">
                                <button type="submit" name="submit" onclick="return confirm('Anda yakin menghapus data ini?');" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            <?php $i++;
            } ?>
        </tbody>
    </table>
</div>

<?php include("../layout/footer.php"); ?>