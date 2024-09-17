<?php
$mysqli = new mysqli("localhost", "root", "", "simple_cms");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$admin_mode = isset($_GET['admin']);

if ($admin_mode && isset($_POST['submit'])) {
    $title = $mysqli->real_escape_string($_POST['title']);
    $content = $mysqli->real_escape_string($_POST['content']);
    
    $query = "INSERT INTO posts (title, content) VALUES ('$title', '$content')";
    $mysqli->query($query);
}

if ($admin_mode) {
    $results = $mysqli->query("SELECT * FROM posts ORDER BY created_at DESC");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Basit CMS</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        h1 {
            color: #333;
        }
        form {
            margin-bottom: 20px;
        }
        input[type="text"], textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
        }
        input[type="submit"] {
            padding: 10px 20px;
        }
        ul {
            list-style-type: none;
            padding: 0;
        }
        li {
            border-bottom: 1px solid #ddd;
            padding: 10px 0;
        }
    </style>
</head>
<body>
    <?php if ($admin_mode): ?>
        <h1>Admin Paneli</h1>
        <form method="post" action="">
            <label>Başlık:</label>
            <input type="text" name="title" required>
            <br>
            <label>İçerik:</label>
            <textarea name="content" rows="5" required></textarea>
            <br>
            <input type="submit" name="submit" value="Gönderi Ekle">
        </form>

        <h1>Gönderiler</h1>
        <ul>
            <?php while ($row = $results->fetch_assoc()): ?>
                <li>
                    <h2><?php echo htmlspecialchars($row['title']); ?></h2>
                    <p><?php echo nl2br(htmlspecialchars($row['content'])); ?></p>
                    <small><?php echo $row['created_at']; ?></small>
                </li>
            <?php endwhile; ?>
        </ul>
        <a href="index.php">Ana Sayfaya Dön</a>
    <?php else: ?>
        <h1>Gönderiler</h1>
        <?php
        $results = $mysqli->query("SELECT * FROM posts ORDER BY created_at DESC");
        ?>
        <ul>
            <?php while ($row = $results->fetch_assoc()): ?>
                <li>
                    <h2><?php echo htmlspecialchars($row['title']); ?></h2>
                    <p><?php echo nl2br(htmlspecialchars($row['content'])); ?></p>
                    <small><?php echo $row['created_at']; ?></small>
                </li>
            <?php endwhile; ?>
        </ul>
        <a href="index.php?admin=true">Admin Paneline Geç</a>
    <?php endif; ?>
</body>
</html>
