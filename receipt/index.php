<?php include("../layout/header.php");

$sql = "SELECT rcp.*, ifnull(sum(rcp_det.price * rcp_det.amount),0)  as total, users.name as user_name FROM receipts as rcp
left join receipt_details as rcp_det on rcp.id=rcp_det.receipt_id
inner join users on users.id = rcp.user_id
where rcp.status='entry' group by rcp.id";

$query = mysqli_query($db, $sql);
?>

<h1 class="text-center">Receipt List</h1>

<?php
    if(isset($_GET["error"])) :  ?>
<div class="alert alert-warning alert-dismissible fade show" role="alert">
    <strong><?= $_GET["error"]; ?></strong>
</div>
<?php endif;
if(isset($_GET["success"])) :
    ?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong><?= $_GET["success"]; ?></strong>
</div>
<?php endif;?>

<a href="form.php" class="btn btn-primary my-3" style="width:100px">Add</a>

<div class="table-responsive">
    <table id="data" class="table table-striped table-bordered" style="width:100%">

        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Date</th>
                <th scope="col">Name</th>
                <th scope="col">Price</th>
                <th scope="col">Status</th>
                <th scope="col">User</th>

                <th scope="col" width="10%">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 1;
while($menu = mysqli_fetch_array($query)) {
    ?>
            <tr>
                <td scope="row"><?= $i; ?></td>
                <td scope="row"><?= date("d/m/Y H:i:s", strtotime($menu["receipt_date"])); ?></td>
                <td scope="row"><?= $menu["customer_name"]; ?></td>
                <td scope="row" class="text-end"><?= number_format($menu["total"], 0, '.', '.'); ?></td>
                <td scope="row"><?= $menu["status"]; ?></td>
                <td scope="row"><?= $menu["user_name"]; ?></td>
                <td scope="row">
                    <div class="d-flex justify-content-center">
                        <a type="button" href="form.php?id=<?= $menu["id"]; ?>"
                            class="btn btn-warning btn-sm me-2">Edit</a>
                        <form action="delete-process.php" method="post">
                            <input type="hidden" name="id" value="<?=  $menu["id"]; ?>">
                            <button type="submit" name="submit"
                                onclick="return confirm('Anda yakin menghapus data ini?');"
                                class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
            <?php
        $i++;
} ?>

        </tbody>
    </table>
</div>

<?php include("../layout/footer.php");
