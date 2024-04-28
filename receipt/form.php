<?php
include ("../layout/header.php");

$id = isset($_GET['id'])? $_GET['id']: 0;

$sql = "SELECT * FROM receipts WHERE id=$id";
$result = mysqli_query($db, $sql);
$receipts = $result->num_rows > 0 ? mysqli_fetch_assoc($result): null;

// Query untuk mengambil data kategori
$category_query = mysqli_query($db, "SELECT status FROM receipts");
?>

<h2><?= $id ? "Edit" : "Add"; ?> Receipts</h2>

<form action="post-process.php" method="POST">
    <div class="row">
        <input type="hidden" name="id" value="<?= $id ; ?>">
        <div class="col-md-6">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" name="name" value="<?= $receipts ? $receipts['name'] : ''; ?>" required>
            </div>
            <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" class="form-control">
                    <option value="Done" <?= ($receipts && $receipts['status'] == 'Done') ? 'selected' : ''; ?>>Done</option>
                </select>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <button type="submit" name="submit" class="btn btn-primary"><?= $id ? "Update" : "Submit"; ?></button>
            <a href="index.php" class="btn btn-secondary">Cancel</a>
        </div>
    </div>
</form>

<?php
include ("../layout/footer.php");
?>
