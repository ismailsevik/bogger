<?php
// Veritabanı ayarları
$servername = "localhost"; // Veritabanı sunucu adı (genellikle 'localhost')
$username = "root";        // Veritabanı kullanıcı adı (varsayılan olarak 'root')
$password = "";            // Veritabanı şifresi (boş bırakılmış olabilir veya şifrenizi buraya girin)
$dbname = "simple_cms";    // Veritabanı adı (bu örnekte 'simple_cms')

// Veritabanı bağlantısını oluştur
$mysqli = new mysqli($servername, $username, $password, $dbname);

// Bağlantıyı kontrol et
if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}
?>
