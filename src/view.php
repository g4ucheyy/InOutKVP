<?php
// 1. Start the session to track who is logged in
session_start();
include('db.php');

// 2. Redirect back to login page if they accessed this page without logging in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); 
    exit();
}

// Get the logged-in user's ID from the session
$logged_in_id = $_SESSION['user_id'];

// 3. ONLY fetch the data of the user who is logged in
$query_user = mysqli_query($conn, "SELECT * FROM users WHERE id = '$logged_in_id'");
$row_user = mysqli_fetch_assoc($query_user);

$name = $row_user['name'];
$id = $row_user['id'];
$pwd = $row_user['pwd'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Rekod</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="home.png">
</head>
<style>
     body {
        background-color:rgb(234, 203, 255);
    }
    table, tr, th, td {
        border-collapse: collapse;
        border: 2px solid black;
        padding: 10px;
        background: whitesmoke;
    }

    .info {
        background-color: whitesmoke;
        border: 4px solid black;
        border-radius: 5px;
        width: 350px;
        font-family: monospace;
    }

    /* Print Button Styling */
    .print-btn {
        background-color: #2e7d32;
        color: white;
        border: 2px solid black;
        padding: 10px 20px;
        font-weight: bold;
        font-family: sans-serif;
        cursor: pointer;
        border-radius: 4px;
        margin-bottom: 20px;
    }
    .print-btn:hover {
        background-color: #1b5e20;
    }

    /* ==========================================================
       THE PRINT FIX: This hides everything unneeded during print 
       ========================================================== */
    @media print {
        body {
            background-color: white !important;
        }
        /* Hide the main title, menus, buttons, and user detail cards */
        #home, .menu, .info, .print-btn {
            display: none !important;
        }
        /* Expand table to fill the paper width cleanly */
        #data-table {
            width: 100% !important;
        }
    }
</style>
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
    <br>
    <center>

<div class="info">
    <h2>Nama User: <?php echo $name; ?> </h2>
    <h2>ID User: <?php echo $id; ?> </h2>
</div>
<br>

<button class="print-btn" onclick="window.print()">🖨️ Cetak Rekod</button>

  <table border="1" id="data-table" style="border-collapse: collapse; width: 80%; text-align: left; font-family: sans-serif;">
      
            <tr style="background-color: #2c3e50; color: black;">
                <th style="padding: 10px;">Bil</th>
                <th style="padding: 10px;">Tarikh Keluar</th>
                <th style="padding: 10px;">Waktu keluar</th>
                <th style="padding: 10px;">Tujuan/Destinasi</th>
                <th style="padding: 10px;">TT Warden/Penyelia</th>
                <th style="padding: 10px;">Tarikh Masuk</th>
                <th style="padding: 10px;">Waktu Masuk</th>
                <th style="padding: 10px;">TT Penjaga</th>
                <th style="padding: 10px;">Catatan</th>                
            </tr>

            <?php
            $bil = 1;

            // 4. CRITICAL FIX: Only grab records matching this user's ID
            $query_records = mysqli_query($conn, "SELECT * FROM record WHERE user_id = '$logged_in_id' ORDER BY tarikh_keluar DESC");

            while ($row = mysqli_fetch_assoc($query_records)) {
                echo "
                <tr>
                <td>".$bil++."</td>
                <td>".$row['tarikh_keluar']."</td>
                <td>".$row['waktu_keluar']."</td>
                <td>".$row['tujuan']."</td>
                <td>".$row['tt1']."</td>
                <td>".$row['tarikh_masuk']."</td>
                <td>".$row['waktu_masuk']."</td>
                <td>".$row['tt2']."</td>
                <td>".$row['catatan']."</td>
                </tr>
                ";
            }
            ?>
    </table>
</center>

</body>
</html>