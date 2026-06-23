<?php
// 1. Start the session to catch the logged-in user data
session_start();
include('db.php');

// Redirect back to login page if they accessed this page without logging in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get the current logged-in user's ID
$logged_in_id = $_SESSION['user_id'];

// 2. Fetch the ACTUAL logged-in user details for the welcome message
$query = mysqli_query($conn, "SELECT * FROM users WHERE id = '$logged_in_id'");
$row = mysqli_fetch_assoc($query);
$name = $row['name'] ?? 'Pengguna'; // Fallback if no user found

// Process form submission
if (isset($_POST['Submit'])) {
    // Get form data and prevent SQL injection
    $tarikh_keluar = mysqli_real_escape_string($conn, $_POST['tarikh_keluar']);
    $waktu_keluar  = mysqli_real_escape_string($conn, $_POST['waktu_keluar']);
    $tujuan        = mysqli_real_escape_string($conn, $_POST['tujuan']);
    $tt1           = mysqli_real_escape_string($conn, $_POST['tt1']);
    $tarikh_masuk  = mysqli_real_escape_string($conn, $_POST['tarikh_masuk']);
    $waktu_masuk   = mysqli_real_escape_string($conn, $_POST['waktu_masuk']);
    $tt2           = mysqli_real_escape_string($conn, $_POST['tt2']);
    $catatan       = mysqli_real_escape_string($conn, $_POST['catatan']);

    // 3. CRITICAL FIX: Save the $logged_in_id inside the user_id column
    $sql = "INSERT INTO record (tarikh_keluar, waktu_keluar, tujuan, tt1, tarikh_masuk, waktu_masuk, tt2, catatan, user_id) 
            VALUES ('$tarikh_keluar', '$waktu_keluar', '$tujuan', '$tt1', '$tarikh_masuk', '$waktu_masuk', '$tt2', '$catatan', '$logged_in_id')";

    // Execute query and alert user
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Rekod berjaya ditambah!'); window.location='view.php';</script>";
    } else {
        echo "<script>alert('Ralat: " . mysqli_error($conn) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="home.png">
    <style>
         body {
            background-color: rgb(234, 203, 255);
        }
        .add {
            border: 4px solid black;
            background-color: whitesmoke;
            width: 450px;
            font-family: monospace;
            font-size: 15px;
        }
    </style>
</head>
<body>
    <h1 id="home">InOutKVPJB</h1>

    <div class="menu">
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="add.php">Tambah Rekod</a></li>
            <li><a href="view.php">View Rekod</a></li>
            <li><a href="logout.php" onclick="return confirm('Adakah anda ingin Log keluar?');">Log Out</a></li>
        </ul>
    </div>

    <marquee direction="right" id="grr">SELAMAT DATANG KE SISTEM InOutKVPJB, <?php echo htmlspecialchars($name); ?>!</marquee>
    
    <center>
        <h1 id="home">Tambah Maklumat</h1>

        <div class="add">
            <form method="post" action="">
                <br>
                <label>Tarikh Keluar</label><br>
                <input type="date" name="tarikh_keluar" required> <br>
                
                <label>Waktu Keluar</label><br>
                <input type="text" name="waktu_keluar" required> <br>
                
                <label>Tujuan</label><br>
                <input type="text" name="tujuan" required> <br>
                
                <label>Tandatangan Warden</label><br>
                <input type="text" name="tt1"> <br>
                
                <label>Tarikh Masuk</label><br>
                <input type="date" name="tarikh_masuk" required> <br>
                
                <label>Waktu Masuk</label><br>
                <input type="text" name="waktu_masuk" required> <br>
                
                <label>Tandatangan Penjaga</label><br>
                <input type="text" name="tt2"> <br>
                
                <label>Catatan</label><br>
                <input type="text" name="catatan"> <br>
                <br>
                <input type="submit" name="Submit" value="Simpan"> <br>
                <br>
            </form>
        </div>
    </center>
</body>
</html>