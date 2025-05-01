<?php
// Veritabanı bağlantısını dahil et
include("baglanti.php");

session_start();

// Oturum kontrolü - admin girişi yapılmış mı
if ($_SESSION["user"] == "") {
    echo "<script>window.location.href='panelgiris.php'</script>";
    exit;
}

// Veritabanından verileri çekme işlemi
$sec = "SELECT * FROM iletisim";
$sonuc = $baglan->query($sec);

?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kayıtlar | KodLab</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

    <h2>İletişim Kayıtları</h2>

    <table id="customers">
        <tr>
            <th>Ad Soyad</th>
            <th>Telefon</th>
            <th>Email</th>
            <th>Konu</th>
            <th>Mesaj</th>
        </tr>

        <?php
        // Eğer veritabanında sonuç varsa, her birini listele
        if ($sonuc->num_rows > 0) {
            while ($cek = $sonuc->fetch_assoc()) {
                echo "
                <tr>
                    <td>" . $cek['adsoyad'] . "</td>
                    <td>" . $cek['telefon'] . "</td>
                    <td>" . $cek['email'] . "</td>
                    <td>" . $cek['konu'] . "</td>
                    <td>" . $cek['mesaj'] . "</td>
                </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>Veritabanında kayıtlı veri bulunamadı.</td></tr>";
        }
        ?>
    </table>

</body>
</html>
