<?php
session_start();

// Kullanıcının oturum açıp açmadığını kontrol et
if (!isset($_SESSION['username'])) {
    die("Bu sayfayı görüntülemek için giriş yapmalısınız.</a>");
}

// Kullanıcı adını oturumdan al
$username = $_SESSION['username'];

// MySQLi bağlantısı oluştur
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'final';
$mysqli = new mysqli($host, $user, $pass, $db);

if ($mysqli->connect_error) {
    die('Bağlantı hatası (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Formdan gelen verileri alın
    $username = $_POST['username'];
    $password = $_POST['password'];
    $iletisim = $_POST['iletisim'];
    $adres = $_POST['adres'];
    $kisiseldetay = $_POST['kisiseldetay'];

    // SQL sorgusunu hazırlayın ve çalıştırın
    $sql = "INSERT INTO users (username, password, iletisim, adres, kisiseldetay) VALUES (?, ?, ?, ?, ?)";
    $stmt = $mysqli->prepare($sql);
    if ($stmt) { // Hazırlama işleminin başarılı olup olmadığını kontrol edin
        $stmt->bind_param("sssss", $username, $password, $iletisim, $adres, $kisiseldetay);

        if ($stmt->execute()) {
            echo "Yeni kullanıcı başarıyla eklendi.";
            echo '<br><br> Panele 5 saniye içinde yönlendiriliyorsunuz...';
            header("refresh:5;url=panel.php");
        } else {
            echo "Hata: " . $stmt->error;
        }

        // Bağlantıyı kapatın
        $stmt->close();
    } else {
        echo "Hata: " . $mysqli->error;
    }
    $mysqli->close();
} else {
    echo "Geçersiz istek.";
}
?>

