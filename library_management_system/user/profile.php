<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'user') {
    header("Location: ../index.php");
    exit();
}

include('../includes/db.php');
$message = "";

// Fetch current user info
$user_id = $_SESSION['user_id'];
$result = $conn->query("SELECT * FROM users WHERE id=$user_id");
$user = $result->fetch_assoc();

// Update username or password
if (isset($_POST['update_profile'])) {
    $username = $_POST['username'];
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Check current password
    if ($current_password === $user['password']) {

        // Check new password confirmation
        if ($new_password === $confirm_password) {
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $conn->query("UPDATE users SET username='$username', password='$hashed_password' WHERE id=$user_id");
            $_SESSION['username'] = $username; // update session
            $message = "✅ Profile updated successfully!";
        } else {
            $message = "❌ New passwords do not match!";
        }
    } else {
        $message = "❌ Current password is incorrect!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Profile | Library System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h3>Update Profile</h3>
    <hr>
    <?php if ($message) echo "<div class='alert alert-info'>$message</div>"; ?>
    <form method="POST">
        <div class="mb-3">
            <label>Username</label>
            <input type="text" name="username" class="form-control" value="<?php echo $user['username']; ?>" required>
        </div>
        <div class="mb-3">
            <label>Current Password</label>
            <input type="password" name="current_password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>New Password</label>
            <input type="password" name="new_password" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Confirm New Password</label>
            <input type="password" name="confirm_password" class="form-control" required>
        </div>
        <button type="submit" name="update_profile" class="btn btn-success">Update</button>
        <a href="user_dashboard.php" class="btn btn-secondary">Back</a>
    </form>
</div>

</body>
</html>
