<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Panel Sayfası</title>
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
<!-- Navbar Bitiş-->

<!-- Kontrol Başlangıç-->
<div class="container-fluid">
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
        die('Connect Error (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
    }
    ?>
</div>
<!-- Kontrol Bitiş-->

<!-- Giriş Bilgileri Başlangıç-->
<div class="container py-4">
    <?php
    echo "Panel sayfasına hoş geldiniz, " . htmlspecialchars($username) . ". ";
    echo '<span><br>Connection OK: ' . $mysqli->host_info . '</span>';
    echo '<span><br>Server: ' . $mysqli->server_info . '<br><br></span>'; 
    $sorgu = mysqli_query($mysqli, "SELECT * FROM users WHERE username = 'yyukar'");
    while ($row = mysqli_fetch_array($sorgu)) {
        echo $row['username'] . "'ın bilgileri:" ;
        echo "<br>iletisim bilgileri: " . $row['iletisim'];
        echo "<br>adres bilgileri: " . $row['adres'];
        echo "<br>kisisel bilgileri: " . $row['kisiselDetay'];
    }
    ?>
</div>
<!-- Giriş Bilgileri Bitiş-->

<!-- Tüm Kullanıcı Bilgileri Başlangıç-->
<div class="container py-2">
    <strong>Sistemde kayıtlı tüm kullanıcılar</strong> <br>
    <?php
    // Tüm kullanıcı adlarını seçmek için SQL sorgusu
    $sorgu = mysqli_query($mysqli, "SELECT username FROM users");
    if ($sorgu) {
        // Sonuçları döngü ile yazdır
        while ($row = mysqli_fetch_array($sorgu)) {
            echo "<span><br>" . htmlspecialchars($row['username']) . "</span>";
        }

        // Sonuç kümesindeki satır sayısını döndür
        $rowcount = mysqli_num_rows($sorgu);
        printf("<br>Sonuç kümesi %d satır içeriyor.\n", $rowcount);
    } else {
        echo "Sorgu başarısız: " . $mysqli->error;
    }
    ?>
</div>
<!-- Tüm Kullanıcı Bilgileri Bitiş-->

<!-- Form Başlangıç -->
<div class="container py-4">
    <div class="row">
        <!-- Yeni Kullanıcı Ekleme Formu Başlangıç-->
        <div class="col-sm">
            <h3>Yeni Kullanıcı Ekle</h3>
            <form action="add_user.php" method="post">
                <div class="mb-3">
                    <label class="form-label">Kullanıcı Adı:</label>
                    <input type="text" name="username" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Şifre:</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">İletişim:</label>
                    <input type="text" name="iletisim" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Adres:</label>
                    <input type="text" name="adres" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Kişisel Detay:</label>
                    <textarea name="kisiseldetay" class="form-control" required></textarea>
                </div>
                <button type="submit" class="btn btn-secondary">Ekle</button>
            </form>
        </div>
        <!-- Yeni Kullanıcı Ekleme Formu Bitiş-->

        <!-- Kullanıcı Güncelleme Formu Başlangıç-->
        <div class="col-sm">
            <h3>Kullanıcı Bilgilerini Güncelle</h3>
            <form action="update_user.php" method="post">
                <div class="mb-3">
                    <label class="form-label">Kullanıcı Adı:</label>
                    <input type="text" name="username" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Yeni Şifre:</label>
                    <input type="password" name="new_password" class="form-control">
                </div>
                <div class="mb-3">
                    <label class="form-label">İletişim:</label>
                    <input type="text" name="iletisim" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Adres:</label>
                    <input type="text" name="adres" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Kişisel Detay:</label>
                    <textarea name="kisiseldetay" class="form-control" required></textarea>
                </div>
                <button type="submit" class="btn btn-secondary">Güncelle</button>
            </form>
        </div>
        <!-- Kullanıcı Güncelleme Formu Bitiş-->
    </div>
</div>
<!-- Form Bitiş -->

</body>
</html>


