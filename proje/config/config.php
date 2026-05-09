<?php
// config.php
$host = 'localhost';
$dbname = 'kampus_cozum_merkezi'; // phpMyAdmin'deki veritabanı adınız
$username = 'root'; // XAMPP varsayılan kullanıcı adı
$password = ''; // XAMPP varsayılan şifre (genelde boştur)

try {
    $db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    // Hata modunu exception olarak ayarla
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Veritabanı bağlantı hatası: " . $e->getMessage());
}
?>
