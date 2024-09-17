<?php
$mysqli = new mysqli("localhost", "root", "", "simple_cms");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

session_start();

$admin_mode = isset($_GET['admin']);
$logged_in = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;

if ($admin_mode) {
    if (isset($_POST['login'])) {
        // Admin giriş bilgileri (bu örnekte sabit kodlanmış)
        $username = $_POST['username'];
        $password = $_POST['password'];
        if ($username === 'admin' && $password === 'password') {
            $_SESSION['logged_in'] = true;
            $logged_in = true;
        } else {
            $login_error = "Geçersiz kullanıcı adı veya şifre.";
        }
    }

    if (!$logged_in) {
        if (isset($login_error)) {
            echo "<p style='color: red;'>$login_error</p>";
        }
        echo '<h1>Admin Girişi</h1>';
        echo '<form method="post" action="">
                <label>Kullanıcı Adı:</label>
                <input type="text" name="username" required>
                <br>
                <label>Şifre:</label>
                <input type="password" name="password" required>
                <br>
                <input type="submit" name="login" value="Giriş Yap">
              </form>';
    } else {
        if (isset($_POST['submit'])) {
            $title = $mysqli->real_escape_string($_POST['title']);
            $content = $mysqli->real_escape_string($_POST['content']);
            
            $query = "INSERT INTO posts (title, content) VALUES ('$title', '$content')";
            $mysqli->query($query);
        }

        $results = $mysqli->query("SELECT * FROM posts ORDER BY created_at DESC");

        echo '<h1>Admin Paneli</h1>';
        echo '<form method="post" action="">
                <label>Başlık:</label>
                <input type="text" name="title" required>
                <br>
                <label>İçerik:</label>
                <textarea name="content" rows="5" required></textarea>
                <br>
                <input type="submit" name="submit" value="Gönderi Ekle">
              </form>';

        echo '<h1>Gönderiler</h1>';
        echo '<ul>';
        while ($row = $results->fetch_assoc()) {
            echo '<li>
                    <h2>' . htmlspecialchars($row['title']) . '</h2>
                    <p>' . nl2br(htmlspecialchars($row['content'])) . '</p>
                    <small>' . $row['created_at'] . '</small>
                  </li>';
        }
        echo '</ul>';
        echo '<a href="index.php">Ana Sayfaya Dön</a> | ';
        echo '<a href="?admin=true&logout=true">Çıkış Yap</a>';

        if (isset($_GET['logout'])) {
            session_destroy();
            header("Location: index.php?admin=true");
            exit;
        }
    }
} else {
    echo '<h1>Gönderiler</h1>';
    $results = $mysqli->query("SELECT * FROM posts ORDER BY created_at DESC");
    echo '<ul>';
    while ($row = $results->fetch_assoc()) {
        echo '<li>
                <h2>' . htmlspecialchars($row['title']) . '</h2>
                <p>' . nl2br(htmlspecialchars($row['content'])) . '</p>
                <small>' . $row['created_at'] . '</small>
              </li>';
    }
    echo '</ul>';
    echo '<a href="index.php?admin=true">Admin Paneline Geç</a>';
}
?>
