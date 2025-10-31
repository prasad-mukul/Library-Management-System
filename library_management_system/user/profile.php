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
            $_SESSION['username'] = $username;
            $message = "<div class='alert alert-success text-center'>✅ Profile updated successfully!</div>";
        } else {
            $message = "<div class='alert alert-danger text-center'>❌ New passwords do not match!</div>";
        }
    } else {
        $message = "<div class='alert alert-danger text-center'>❌ Current password is incorrect!</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profile | Library System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(135deg, #eef2f3, #dfe9f3);
            font-family: 'Poppins', sans-serif;
        }
        .card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }
        .card-header {
            background: linear-gradient(90deg, #007bff, #00c6ff);
            color: white;
            border-radius: 20px 20px 0 0;
            text-align: center;
            padding: 1.2rem;
        }
        .btn-update {
            background: linear-gradient(90deg, #28a745, #00b894);
            border: none;
            color: white;
            border-radius: 25px;
            padding: 10px 30px;
            transition: 0.3s;
        }
        .btn-update:hover {
            opacity: 0.9;
        }
        .btn-back {
            border-radius: 25px;
        }
        label {
            font-weight: 500;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <div class="card mx-auto" style="max-width: 600px;">
        <div class="card-header">
            <h4 class="mb-0"><i class="bi bi-person-circle"></i> Update Profile</h4>
        </div>
        <div class="card-body p-4">
            <?php echo $message; ?>

            <form method="POST">
                <div class="mb-3">
                    <label><i class="bi bi-person-fill"></i> Username</label>
                    <input type="text" name="username" class="form-control" value="<?php echo htmlspecialchars($user['username']); ?>" required>
                </div>

                <div class="mb-3">
                    <label><i class="bi bi-lock"></i> Current Password</label>
                    <input type="password" name="current_password" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label><i class="bi bi-shield-lock"></i> New Password</label>
                    <input type="password" name="new_password" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label><i class="bi bi-shield-check"></i> Confirm New Password</label>
                    <input type="password" name="confirm_password" class="form-control" required>
                </div>

                <div class="text-center mt-4">
                    <button type="submit" name="update_profile" class="btn btn-update me-2">
                        <i class="bi bi-save"></i> Update
                    </button>
                    <a href="user_dashboard.php" class="btn btn-secondary btn-back">
                        <i class="bi bi-arrow-left"></i> Back
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>
