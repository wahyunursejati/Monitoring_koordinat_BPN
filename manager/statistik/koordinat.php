<?php
    session_start();

    if ($_SESSION['level'] == "") {
        header("location:login.html?pesan=belum_login");
    }

    include 'koneksi.php';

    $districts = ['Sleman', 'Bantul', 'Kota Yogyakarta', 
    'Gunung Kidul','Kulon Progo'];
    $populationCounts = [];
    $query = $koneksi->prepare("SELECT * FROM hiostory JOIN sertifikat
    ON hiostory.Id_NoSertif = sertifikat.Id_NoSertif 
    INNER JOIN kabupaten ON sertifikat.Id_Kab = kabupaten.Id_Kab 
    WHERE kabupaten.Nama_Kab = ?");

    foreach ($districts as $district) {
        $query->bind_param("s", $district);
        $query->execute();
        $result = $query->get_result();
        $populationCounts[] = $result->num_rows;
    }

    $populationCountsString = implode(',', $populationCounts);
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Statistik</title>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="../css/penduduk.css">
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Move scripts to the head for better performance -->

    </head>
    <body>
        <div class="sidebar">
            <div class="logo"></div>
            <ul class="menu">
                <li><a href="../../homemanager.php"><i class="fas fa-tachometer-alt"></i><span>Dashboard</span></a></li>
                <li class="active"><a href="#"><i class="fas fa-chart-bar"></i><span>Statistik</span></a></li>
                <li><a href="../sertifikat.php"><i class="fa-solid fa-bell"></i><span>Aduan</span></a></li>
                <li><a href="../koordinat.php"><i class="fas fa-solid fa-scroll"></i><span>Sertifikat</span></a></li>
            </ul>
        </div>
        <div class="content">
            <section class="content-header">
                <h1>Statistik</h1>
                <ol class="breadcrumb"></ol>
            </section>
            <section class="con">
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box">
                            <div class="box-header">
                                <ul class="btn">
                                    <li><a href="../penduduk.php"><i class="fas fa-solid fa-scroll"></i>Sertifikat</a></li>
                                    <li class="active"><a href="#"><i class="fas fa-map-marker-alt"></i>Pergeseran</a></li>
                                    <li><a href="aduan.php"><i class="fa-solid fa-bell"></i>Aduan</a></li>
                                </ul>
                            </div>
                            <div class="statistik">
                                <div>
                                    <canvas id="pendudukChart" ></canvas>
                                </div>
                            </div>
                            <script>
                            var pendudukChart = document.getElementById('pendudukChart').getContext('2d');
                            var populationData = [<?php echo $populationCountsString; ?>];
                            var penduduk = new Chart(pendudukChart, {
                                type: 'bar',
                                data: {
                                    labels: ['Sleman', 'Bantul', 'Kota Yogyakarta', 'Gunung Kidul','Kulon Progo'],
                                    datasets: [{
                                        label: 'pergeseran',
                                        data: populationData,
                                        backgroundColor: ['rgba(255, 99, 132, 0.2)', 'rgba(255, 159, 64, 0.2)', 'rgba(255, 205, 86, 0.2)', 'rgba(75, 192, 192, 0.2)', 'rgba(54, 162, 235, 0.2)'],
                                        borderColor: ['rgb(255, 99, 132)', 'rgb(255, 159, 64)', 'rgb(255, 205, 86)', 'rgb(75, 192, 192)', 'rgb(54, 162, 235)'],
                                        borderWidth: 1
                                    }]
                                }
                            });
                        </script>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </body>
</html>
