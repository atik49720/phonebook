<?php
session_start();
include 'include/header.php';
include 'config/db.php';

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $contacts = $conn->query("SELECT * FROM contacts WHERE user_id = $user_id");
} else {
    header("Location: login.php");
}
?>
<div class="container mt-5">
    <h2 class="text-center mb-4">My Phonebook (<?php echo $_SESSION['username']; ?>)</h2>
    <div class="d-flex justify-content-between mb-3">
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addContactModal">Add Contact</button>
        <form action="actions.php" method="POST">
            <button type="submit" name="logout" class="btn btn-secondary">Logout</button>
        </form>
    </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Mobile</th>
                <th>Email</th>
                <th>Company</th>
                <th>Address</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $contacts->fetch_assoc()) : ?>
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['name'] ?></td>
                    <td><?= $row['mobile'] ?></td>
                    <td><?= $row['email'] ?></td>
                    <td><?= $row['company'] ?></td>
                    <td><?= $row['address'] ?></td>
                    <td>
                        <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editContactModal-<?= $row['id'] ?>">Edit</button>
                        <form action="actions.php" method="POST" class="d-inline">
                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                            <button type="submit" name="delete" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<!-- Add Contact Modal -->
<div class="modal fade" id="addContactModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="actions.php" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title">Add Contact</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" class="form-control" id="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="mobile" class="form-label">Mobile</label>
                        <input type="text" name="mobile" class="form-control" id="mobile" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" id="email">
                    </div>
                    <div class="mb-3">
                        <label for="company" class="form-label">Company</label>
                        <input type="text" name="company" class="form-control" id="company">
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" name="address" class="form-control" id="address">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="add" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Edit Contact Modal -->
<?php
$contacts = $conn->query("SELECT * FROM contacts WHERE user_id = $user_id");
while ($row = $contacts->fetch_assoc()) : ?>
    <div class="modal fade" id="editContactModal-<?= $row['id'] ?>">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="actions.php" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Contact</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" value="<?= $row['id'] ?>">
                        <div class="mb-3">
                            <label for="name-<?= $row['id'] ?>" class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" id="name-<?= $row['id'] ?>" value="<?= $row['name'] ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="mobile-<?= $row['id'] ?>" class="form-label">Mobile</label>
                            <input type="text" name="mobile" class="form-control" id="mobile-<?= $row['id'] ?>" value="<?= $row['mobile'] ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="email-<?= $row['id'] ?>" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" id="email-<?= $row['id'] ?>" value="<?= $row['email'] ?>">
                        </div>
                        <div class="mb-3">
                            <label for="company-<?= $row['id'] ?>" class="form-label">Company</label>
                            <input type="text" name="company" class="form-control" id="company-<?= $row['id'] ?>" value="<?= $row['company'] ?>">
                        </div>
                        <div class="mb-3">
                            <label for="address-<?= $row['id'] ?>" class="form-label">Address</label>
                            <input type="text" name="address" class="form-control" id="address-<?= $row['id'] ?>" value="<?= $row['address'] ?>">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="edit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<?php endwhile; ?>
<?php include 'include/footer.php'; ?>