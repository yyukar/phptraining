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
    $new_password = $_POST['new_password'];
    $iletisim = $_POST['iletisim'];
    $adres = $_POST['adres'];
    $kisiseldetay = $_POST['kisiseldetay'];

    // SQL sorgusunu hazırlayın
    if (!empty($new_password)) {
        $sql = "UPDATE users SET password = ?, iletisim = ?, adres = ?, kisiseldetay = ? WHERE username = ?";
        $stmt = $mysqli->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("sssss", $new_password, $iletisim, $adres, $kisiseldetay, $username);
        } else {
            echo "Hata: " . $mysqli->error;
            exit();
        }
    } else {
        $sql = "UPDATE users SET iletisim = ?, adres = ?, kisiseldetay = ? WHERE username = ?";
        $stmt = $mysqli->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("ssss", $iletisim, $adres, $kisiseldetay, $username);
        } else {
            echo "Hata: " . $mysqli->error;
            exit();
        }
    }

    if ($stmt->execute()) {
        echo "Kullanıcı bilgileri başarıyla güncellendi.";
        echo '<br><br> Panele 5 saniye içinde yönlendiriliyorsunuz...';
        header("refresh:5;url=panel.php");
    } else {
        echo "Hata: " . $stmt->error;
    }

    // Bağlantıyı kapatın
    $stmt->close();
    $mysqli->close();
} else {
    echo "Geçersiz istek.";
}
?>

