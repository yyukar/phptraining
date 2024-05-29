<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Kontrol Sayfası</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <!-- Navbar Başlangıç -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid mb-2">
            <a class="navbar-brand" href="panel.php">Panel</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="giris.html">Giriş'e gitmek için tıklayın.</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled" aria-disabled="true">MB0032 Internet Teknolojileri ve Web Programlama</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Navbar Bitiş -->

    <div class="container-fluid pt-3">
        <?php
        session_start();

        // Kullanıcı girdilerini al
        $username = $_POST['user'];
        $password = $_POST['pass'];

        // Boş alanları kontrol et
        if (empty($username) || empty($password)) {
            die("Kullanıcı adı ve şifre alanları boş bırakılamaz.");
        }

        // Bağlantı ayarları
        $host = 'localhost';
        $user = 'root';
        $pass = '';
        $db = 'final';

        // MySQLi bağlantısı oluştur
        $mysqli = new mysqli($host, $user, $pass, $db);

        // Bağlantı hatasını kontrol et
        if ($mysqli->connect_error) {
            die('Bağlantı Hatası (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
        }

        // Kullanıcı girdilerini temizle ve güvenli hale getir
        // $username = $mysqli->real_escape_string($username);
        // $password = $mysqli->real_escape_string($password);

        // SQL sorgusunu hazırlama ve çalıştırma
        $query = "SELECT * FROM users WHERE username = ? AND password = ?";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param('ss', $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        // Sonuçları kontrol et
        if ($row = $result->fetch_assoc()) {
            // Kullanıcıyı oturumda sakla
            $_SESSION['username'] = $row['username'];
            echo "Başarıyla giriş yapıldı. Hoş geldin, " . $row['username'];
            echo '<br><br> Panele 5 saniye içinde yönlendiriliyorsunuz...';
            header("refresh:5;url=panel.php");
        } else {
            echo "Giriş yapılamadı. Lütfen kullanıcı adınızı ve şifrenizi kontrol edin.";
            echo ' Giriş sayfasına gitmek için <a href="giris.html">tıklayınız.</a>';
        }

        // Bağlantıyı kapat
        $stmt->close();
        $mysqli->close();
        ?>
    </div>
</body>
</html>



