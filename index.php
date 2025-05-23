<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Management</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header>
    <div class="header-content">
        <h1>User Management</h1>
    </div>
</header>

<main class="container">
    <div class="table-wrapper">
        <table>
            <thead>
                <button class="btn btn-primary" onclick="openModal('addUserModal')">➕ Add User</button>
                <tr><th>#</th><th>Name</th><th>Email</th><th>Number</th><th>Actions</th></tr>
            </thead>
            <tbody>
                <?php
                $result = $conn->query("SELECT * FROM users");
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>
                            <td>{$row['id']}</td>
                            <td>{$row['name']}</td>
                            <td>{$row['email']}</td>
                            <td>{$row['number']}</td>
                            <td>
                                <button class='btn btn-warning' onclick=\"openEditModal({$row['id']}, '{$row['name']}', '{$row['email']}', '{$row['number']}')\">✏️</button>
                                <button class='btn btn-danger' onclick=\"openDeleteModal({$row['id']})\">🗑️</button>
                            </td>
                        </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</main>

<!-- Add User Modal -->
<div id="addUserModal" class="modal">
    <div class="modal-content">
        <h2>Add User</h2>
        <form action="create.php" method="POST">
            <input type="text" name="name" placeholder="Full Name" required>
            <input type="email" name="email" placeholder="Email Address" required>
            <input type="text" name="number" id="add-number" placeholder="Phone Number" required pattern="\d{11}" title="Phone number must be exactly 11 digits" maxlength="11">
            <div class="modal-actions">
                <button type="submit" class="btn btn-primary">Add</button>
                <button type="button" class="btn btn-secondary" onclick="closeModal('addUserModal')">Cancel</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit User Modal -->
<div id="editUserModal" class="modal">
    <div class="modal-content">
        <h2>Update User</h2>
        <form id="editForm" action="update.php" method="POST">
            <input type="hidden" name="id" id="edit-id">
            <input type="text" name="name" placeholder="Full Name" id="edit-name" required>
            <input type="email" name="email" placeholder="Email Address" id="edit-email" required>
            <input type="text" name="number" id="edit-number" placeholder="Phone Number" required pattern="\d{11}" title="Phone number must be exactly 11 digits" maxlength="11">
            <div class="modal-actions">
                <button type="submit" class="btn btn-warning">Update</button>
                <button type="button" class="btn btn-secondary" onclick="closeModal('editUserModal')">Cancel</button>
            </div>
        </form>
    </div>
</div>

<!-- Delete User Modal -->
<div id="deleteUserModal" class="modal">
    <div class="modal-content">
        <h2>Are you sure?</h2>
        <form id="deleteForm" action="delete.php" method="POST">
            <input type="hidden" name="id" id="delete-id">
            <div class="modal-actions">
                <button type="submit" class="btn btn-danger">Delete</button>
                <button type="button" class="btn btn-secondary" onclick="closeModal('deleteUserModal')">Cancel</button>
            </div>
        </form>
    </div>
</div>

<script>
function openModal(id) {
    document.getElementById(id).style.display = 'flex';
}

function closeModal(id) {
    document.getElementById(id).style.display = 'none';
}

function openEditModal(id, name, email, number) {
    document.getElementById('edit-id').value = id;
    document.getElementById('edit-name').value = name;
    document.getElementById('edit-email').value = email;
    document.getElementById('edit-number').value = number;
    openModal('editUserModal');
}

function openDeleteModal(id) {
    document.getElementById('delete-id').value = id;
    openModal('deleteUserModal');
}

// Restrict input to digits only, max 11 digits
document.querySelectorAll('input[name="number"]').forEach(input => {
    input.addEventListener('input', () => {
        input.value = input.value.replace(/\D/g, '').slice(0, 11);
    });
});

// Alert if email is not valid
document.querySelectorAll('input[type="email"]').forEach(input => {
    input.addEventListener('blur', () => {
        if (!input.checkValidity()) {
            alert("Please enter a valid email address.");
        }
    });
});
</script>

</body>
</html>
