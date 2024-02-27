<?php 
session_start();
require 'koneksi.php';

$id_no_sertif = '';
$history_data = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && 
isset($_POST['id_no_sertif'])) {
    $id_no_sertif = mysqli_real_escape_string(
        $koneksi, $_POST['id_no_sertif']);
    $history_query = "SELECT * FROM hiostory,sertifikat 
    WHERE hiostory.Id_NoSertif = sertifikat.Id_NoSertif 
    AND hiostory.Id_NoSertif = ? 
    ORDER BY tanggal_kejadian DESC";
    
    if ($stmt = mysqli_prepare($koneksi, $history_query)) {
        mysqli_stmt_bind_param($stmt, 's', $id_no_sertif);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) > 0) {
            $history_data = mysqli_fetch_all
            ($result, MYSQLI_ASSOC);
        }
        mysqli_stmt_close($stmt);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>History Pergeseran</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/riwayat.css">
</head>
<body>
    <div class="container">
        <div class="title">
            <h1>History Pergeseran</h1>
        </div>
        <div class="history">
            <?php if ($_SERVER['REQUEST_METHOD'] != 'POST'): ?>
                <p>Invalid request.</p>
            <?php elseif (empty($history_data)): ?>
                <p> ID: <?= htmlspecialchars($id_no_sertif) ?> Belum memiliki History Pergeseran</p>
            <?php else: ?>
                <ul>
                    <?php foreach ($history_data as $row): ?>
                        <div class="date">
                            <li class="history-item"><p><?= htmlspecialchars($row['tanggal_kejadian']) ?> </p></li>
                        </div>
                        <div class="data">
                            <li class= "history-item">
                                <p>Longitude Awal = <?= htmlspecialchars($row['longitude']) ?></p> 
                                <p>Latitude Awal = <?= htmlspecialchars($row['latitude']) ?></p>
                            </li>
                            <li class= "history-item">
                                <p>Longitude_Akhir = <?= htmlspecialchars($row['longitude_baru']) ?></p>
                                <p>Latitude_Akhir = <?= htmlspecialchars($row['longitude_baru']) ?></p>
                            </li>
                            <li class="jarak">
                                <p>Jarak = <?= htmlspecialchars($row['jarak']) ?></p>
                            </li>
                        </div>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>

