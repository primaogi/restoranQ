<?php
include("../layout/header.php");

$id = isset($_GET['id']) ? $_GET['id'] : 0;

$sql = "SELECT * FROM receipts WHERE id=$id";
$result = mysqli_query($db, $sql);
$receipts = $result->num_rows > 0 ? mysqli_fetch_assoc($result) : null;

// Query untuk mengambil data kategori
$category_query = mysqli_query($db, "SELECT * FROM categories");
$receipt_query = mysqli_query($db, "SELECT status FROM receipts");
?>

<h2><?= $id ? "Edit" : "Add"; ?> Receipts</h2>

<form action="post-process.php" method="POST">
    <div class="row">
        <input type="hidden" name="id" value="<?= $id; ?>">
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
<div class="container text-center mt-5">
    <h1 class="display-4">Receipt Details</h1>
</div>
<a href="form.php" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#receiptModal">
    <i class="bi bi-person-fill-add"></i> Add
</a>

<!-- Modal -->
<div class="modal fade" id="receiptModal" tabindex="-1" aria-labelledby="receiptModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="receiptModalLabel">Add Receipt Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="process_receipt.php" method="post">
                    <div class="mb-3">
                        <label for="menu" class="form-label">Menu Category</label>
                        <select name="category_id" class="form-control">
                            <?php
                            while ($category = mysqli_fetch_assoc($category_query)) {
                                $selected = ($menus && $menus['category_id'] == $category['id']) ? 'selected' : '';
                                echo "<option value='{$category['id']}' $selected>{$category['name']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="amount" class="form-label">Amount (Qty)</label>
                        <input type="number" class="form-control" id="amount" name="amount" required>
                    </div>
                    <div class="mb-3">
                        <label for="note" class="form-label">Note</label>
                        <textarea class="form-control" id="note" name="note"></textarea>
                    </div>
                    <!-- Add other fields as needed -->
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </form>
            </div>
        </div>
    </div>
</div>

<table id="my-datatables" class="table table-striped table-bordered table-responsive">
    <thead>
        <tr>
            <th>No</th>
            <th>Name</th>
            <th>Category</th>
            <th>Note</th>
            <th>Price</th>
            <th>Amount</th>
            <th>Subtotal</th>
            <th class="col-md-2">Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 1;
        while ($user = mysqli_fetch_array($result)) {
        ?>
            <tr>
                <td><?= $i; ?></td>
                <td><?= $receipts_details['customer_name']; ?></td>
                <td><?= $receipts_details['category_name']; ?></td>
                <td><?= $receipts_details['note']; ?></td>
                <td><?= $receipts_details['price']; ?></td>
                <td><?= $receipts_details['amount']; ?></td>
                <td><?= $receipts_details['total']; ?></td>
                <td>
                    <div class="d-flex">
                        <a href="form.php?id=<?= $user["id"]; ?>" class="btn btn-sm btn-warning me-2">Edit</a>
                        <form action="delete-process.php" method="post">
                            <input type="hidden" name="id" value="<?= $user["id"]; ?>">
                            <button type="submit" name="submit" onclick="return confirm('Anda yakin menghapus data ini?');" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
        <?php $i++;
        } ?>
    </tbody>
</table>

<?php
include("../layout/footer.php");
?>