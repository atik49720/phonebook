<?php
session_start();
include 'config/db.php';

if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password != $confirm_password) {
        echo "<script>
                window.alert('Passwords do not match.'); 
                window.location.href='register.php';
            </script>";
    } else {
        if ($conn->query("SELECT id FROM users WHERE username = '$username'")->num_rows > 0) {
            echo "<script>
                    window.alert('User already exists.');
                    window.location.href='register.php';
                </script>";
            exit();
        }
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO users (username, password) VALUES ('$username', '$hashed_password')";
        $result = mysqli_query($conn, $query);
        if ($result) {
            echo "<script>
                    window.alert('Registration successful.');
                    window.location.href='login.php';
                </script>";
        } else {
            echo "<script>
                    window.alert('Registration failed.');
                    window.location.href='register.php';
                </script>";
        }
    }
}

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $query);
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $hashed_password = $user['password'];
        if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header("Location: index.php");
        } else {
            echo "<script>
                    window.alert('Invalid password.');
                    window.location.href='login.php';
                </script>";
        }
    } else {
        echo "<script>
                window.alert('User not found.');
                window.location.href='login.php';
            </script>";
    }
}

if (isset($_POST['logout'])) {
    session_start();
    session_unset();
    session_destroy();
    header("Location: login.php");
    exit();
}

if (isset($_POST['add'])) {
    $user_id = $_SESSION['user_id'];
    $name = $_POST['name'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];
    $company = $_POST['company'];
    $address = $_POST['address'];

    $query = "INSERT INTO contacts (user_id, name, mobile, email, company, address) 
            VALUES ('$user_id','$name', '$mobile', '$email', '$company', '$address')";

    $result = mysqli_query($conn, $query);

    if ($result) {
        header("Location: index.php");
    } else {
        echo "<script>
                window.alert('Something went wrong.');
                window.location.href='index.php';
            </script>";
    }
}

if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $mobile = $_POST['mobile'];
    $email = $_POST['email'];
    $company = $_POST['company'];
    $address = $_POST['address'];

    $query = "UPDATE contacts SET name = '$name', mobile = '$mobile', email = '$email', company = '$company', address = '$address' WHERE id = $id";

    $result = mysqli_query($conn, $query);
    if ($result) {
        header("Location: index.php");
    } else {
        echo "<script>
                window.alert('Something went wrong.');
                window.location.href='index.php';
            </script>";
    }
}

if (isset($_POST['delete'])) {
    $id = $_POST['id'];

    $query = "DELETE FROM contacts WHERE id = $id";

    $result = mysqli_query($conn, $query);
    if ($result) {
        header("Location: index.php");
    } else {
        echo "<script>
                window.alert('Something went wrong.');
                window.location.href='index.php';
            </script>";
    }
}
