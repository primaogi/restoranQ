<?php include("../layout/header.php"); 

$id = isset($_GET['id']) ? $_GET['id'] : 0;

$sql = "select * from categories where id='$id'";
$result = mysqli_query($db, $sql);
$categories = $result->num_rows > 0 ? mysqli_fetch_assoc($result) : null;
?>

<h2 class='my-3'><?= $id > 0 ? "Edit" : "Add"; ?> Category</h2>
<form method="post" action="post-process.php">
    <div class="row">
        <div class="col-md-6">
            <input type="hidden" name="id" value="<?= $id ; ?>">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" name="name" value="<?= $categories? $categories['name'] : '' ; ?>" required>
            </div>
            <div class="mb-3">
                <label for="note" class="form-label">Note</label>
                <input type="text" class="form-control" name="note" value="<?= $categories? $categories['note'] : '' ; ?>" required>
            </div>
            <button type="submit" name="submit" class="btn btn-primary"><i class="bi bi-floppy"></i> Simpan</button>
            <a href="index.php" class="btn btn-secondary"><i class="bi bi-backspace"></i> Kembali</a>
        </div>
    </div>
</form>

<?php include("../layout/footer.php"); ?>
