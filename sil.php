<?php
// Veritabanı bağlantısını dahil edin
include("baglanti.php");

// Gelen 'id' parametresini kontrol edin
if (isset($_GET['id'])) {
    // Gelen id değerini alın ve güvenlik amacıyla tam sayıya çevirin
    $id = intval($_GET['id']);

    // Silme sorgusu
    $sql = "DELETE FROM iletisim WHERE id = $id";

    // Sorguyu çalıştır ve sonucu kontrol et
    if ($baglan->query($sql) === TRUE) {
        // Başarılı silme işlemi sonrası mesaj ver ve yönlendirme yap
        echo "<script>alert('Kayıt başarıyla silindi.'); window.location.href='index.php';</script>";
    } else {
        // Hata durumunda hata mesajını göster
        echo "Hata: " . $baglan->error;
    }
} else {
    // Eğer 'id' parametresi yoksa uyarı ver
    echo "<script>alert('Geçersiz istek. ID bulunamadı.'); window.location.href='index.php';</script>";
}

// Veritabanı bağlantısını kapat
$baglan->close();
?>
