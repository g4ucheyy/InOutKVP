<?php
include('db.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
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
</style>
<body>

    <h1 id="home">InOutKVPJB</h1>

    <div class="menu">
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="add.php">Tambah Rekod</a></li>
            <li><a href="view.php">View Rekod</a></li>
        </ul>
    </div>
    <br>
    <center>
        <div style="margin-bottom: 20px; font-family: sans-serif;">
        
       
    </div>
  <table border="1" id="data-table" style="border-collapse: collapse; width: 80%; text-align: left; font-family: sans-serif;">
        <thead>
            <tr style="background-color: #2c3e50; color: black;">
                <th style="padding: 10px;">Tarikh</th>
                <th style="padding: 10px;">Lokasi</th>
                <th style="padding: 10px;">Warden Terlibat</th>
                <th style="padding: 10px;">Tarikh Pulang</th>
                <th style="padding: 10px;">Penjaga</th>
                <th style="padding: 10px;">Catatan</th>
            </tr>
        </thead>
        
        <!-- JavaScript HANYA akan kacau kawasan tbody ini sahaja -->
        <tbody>
            <tr>
                <td colspan="6" style="text-align: center; color: #888; padding: 15px;">
                   
                </td>
            </tr>
        </tbody>
    </table>
</center>

<script>
document.getElementById('csv-file').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (!file) return;

    const reader = new FileReader();
    
    reader.onload = function(e) {
        const text = e.target.result;
        const lines = text.split('\n');
        
        // Kita sasarkan TBODY, jadi THEAD (th) terselamat daripada dipadam
        const tableBody = document.getElementById('data-table').getElementsByTagName('tbody')[0];
        
        // Kosongkan kandungan tbody sahaja
        tableBody.innerHTML = '';

        for (let i = 0; i < lines.length; i++) {
            const rowText = lines[i].trim();
            if (rowText === '') continue;

            const columns = rowText.split(',');
            const row = tableBody.insertRow();

            for (let j = 0; j < 6; j++) {
                const cell = row.insertCell();
                cell.textContent = columns[j] ? columns[j].trim() : ''; 
                cell.style.padding = '8px';
            }
        }
    };

    reader.readAsText(file);
});
</script>
</body>
</html>