<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>İletişim Tablosu</title>
<style>
/* Genel sayfa stilleri */
body {
  font-family: Arial, Helvetica, sans-serif;
  background-color: #f4f4f9;
  margin: 0;
  padding: 0;
}

/* Başlık stilleri */
h1, h2 {
  text-align: center;
  color: #333;
}

form {
  background-color: #fff;
  padding: 10px;
  max-width: 100%;
  margin: 20px auto;
  border-radius: 8px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  display: flex;
  flex-wrap: wrap;
  gap: 10px;
  justify-content: space-between;
}

form input[type="text"], 
form input[type="email"], 
form textarea {
  width: 14%;
  padding: 12px;
  margin: 0;
  border: 2px solid #ddd;
  border-radius: 4px;
  box-sizing: border-box;
  font-size: 16px;
  transition: border-color 0.3s;
}

form textarea {
  width: 18%;
  resize: none;
}

form input[type="submit"] {
  background-color: #04AA6D;
  color: white;
  border: none;
  padding: 12px 20px;
  font-size: 16px;
  border-radius: 4px;
  cursor: pointer;
  transition: background-color 0.3s;
  width: 15%;
}

form input[type="submit"]:hover {
  background-color: #3e8e41;
}

/* Tablo stilleri */
#customers {
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 100%;
  margin-top: 30px;
}

#customers td, #customers th {
  border: 1px solid #ddd;
  padding: 10px;
}

#customers tr:nth-child(even) { background-color: #f9f9f9; }

#customers tr:hover { background-color: #f1f1f1; }

#customers th {
  background-color: #04AA6D;
  color: white;
  text-align: left;
  padding: 12px 20px;
}
    
/* Link stilleri */
a {
  color: #04AA6D;
  text-decoration: none;
}

a:hover {
  text-decoration: underline;
}

/* Çıkış yap ve listele butonlarının stili */
.exit-btn, .list-btn {
  background-color: #04AA6D;
  color: white;
  border: none;
  padding: 12px 20px;
  font-size: 16px;
  border-radius: 4px;
  cursor: pointer;
  position: fixed;
  bottom: 20px;
  transition: background-color 0.3s;
}

.list-btn {
  right: 150px;
}

.exit-btn {
  right: 20px;
}

.exit-btn:hover, .list-btn:hover {
  background-color: #3e8e41;
}
</style>
</head>
<body>

<h1>İletişim Tablosu</h1>

<!-- Veri eklemek için form -->
<h2>Yeni Veri Ekle</h2>
<form method="POST" action="">
  <input type="text" id="adsoyad" name="adsoyad" placeholder="Ad Soyad" required>
  <input type="text" id="telefon" name="telefon" placeholder="Telefon" required>
  <input type="email" id="email" name="email" placeholder="Email" required>
  <input type="text" id="konu" name="konu" placeholder="Konu" required>
  <textarea id="mesaj" name="mesaj" rows="1" placeholder="Mesaj" required></textarea>
  <input type="submit" name="submit" value="Veri Ekle">
</form>

<!-- Çıkış yap ve listele butonları -->
<form action="cikis.php" method="post">
  <button class="exit-btn" type="submit">Çıkış Yap</button>
</form>

<form action="listelenecek.php" method="post">
  <button class="list-btn" type="submit">Listele</button>
</form>

<!-- Veritabanındaki verileri listeleyen tablo -->
<table id="customers">
  <tr>
    <th>Ad Soyad</th>
    <th>Telefon</th>
    <th>Email</th>
    <th>Konu</th>
    <th>Mesaj</th>
    <th>İşlem</th>
  </tr>

<?php
session_start();
if ($_SESSION["user"] == "") {
    echo "<script>window.location.href='cikis.php'</script>";
} else {
    include("baglanti.php");

    // Veri ekleme işlemi
    if (isset($_POST['submit'])) {
        $adsoyad = $_POST['adsoyad'];
        $telefon = $_POST['telefon'];
        $email = $_POST['email'];
        $konu = $_POST['konu'];
        $mesaj = $_POST['mesaj'];

        $sql = "INSERT INTO iletisim (adsoyad, telefon, email, konu, mesaj) 
                VALUES ('$adsoyad', '$telefon', '$email', '$konu', '$mesaj')";

        if ($baglan->query($sql) === TRUE) {
            echo "Yeni veri başarıyla eklendi!";
        } else {
            echo "Hata: " . $sql . "<br>" . $baglan->error;
        }
    }

    // Veri güncelleme işlemi
    if (isset($_GET['update_id'])) {
        $update_id = $_GET['update_id'];
        $secili_veri = "SELECT * FROM iletisim WHERE id='$update_id'";
        $secili_sonuc = $baglan->query($secili_veri);
        $guncellenecek_veri = $secili_sonuc->fetch_assoc();

        echo "
        <h2>Veriyi Güncelle</h2>
        <form method='POST' action=''>
            <input type='hidden' name='id' value='" . $guncellenecek_veri['id'] . "'>
            <input type='text' name='adsoyad' value='" . $guncellenecek_veri['adsoyad'] . "' required>
            <input type='text' name='telefon' value='" . $guncellenecek_veri['telefon'] . "' required>
            <input type='email' name='email' value='" . $guncellenecek_veri['email'] . "' required>
            <input type='text' name='konu' value='" . $guncellenecek_veri['konu'] . "' required>
            <textarea name='mesaj' rows='3' required>" . $guncellenecek_veri['mesaj'] . "</textarea>
            <input type='submit' name='guncelle' value='Güncelle'>
        </form>
        ";
    }

    if (isset($_POST['guncelle'])) {
        $id = $_POST['id'];
        $adsoyad = $_POST['adsoyad'];
        $telefon = $_POST['telefon'];
        $email = $_POST['email'];
        $konu = $_POST['konu'];
        $mesaj = $_POST['mesaj'];

        $sql_guncelle = "UPDATE iletisim SET 
                          adsoyad='$adsoyad', 
                          telefon='$telefon', 
                          email='$email', 
                          konu='$konu', 
                          mesaj='$mesaj' 
                          WHERE id='$id'";

        if ($baglan->query($sql_guncelle) === TRUE) {
            echo "<script>alert('Veri başarıyla güncellendi!'); window.location.href='';</script>";
        } else {
            echo "Hata: " . $sql_guncelle . "<br>" . $baglan->error;
        }
    }

    // Veritabanındaki verileri listeleme
    $sec = "SELECT * FROM iletisim";
    $sonuc = $baglan->query($sec);

    if ($sonuc->num_rows > 0) {
        while ($cek = $sonuc->fetch_assoc()) {
            echo "
            <tr>
                <td>" . $cek['adsoyad'] . "</td>
                <td>" . $cek['telefon'] . "</td>
                <td>" . $cek['email'] . "</td>
                <td>" . $cek['konu'] . "</td>
                <td>" . $cek['mesaj'] . "</td>
                <td><a href='?update_id=" . $cek['id'] . "'>Güncelle</a> | <a href='sil.php?id=" . $cek['id'] . "'>Sil</a></td>
            </tr>";
        }
    } else {
        echo "Veritabanında kayıtlı veri bulunamadı.";
    }
}
?>
</table>

</body>
</html>
