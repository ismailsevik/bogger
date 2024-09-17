<?php
$mysqli = new mysqli("localhost", "root", "", "simple_cms");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

if (isset($_POST['submit'])) {
    $title = $mysqli->real_escape_string($_POST['title']);
    $content = $mysqli->real_escape_string($_POST['content']);
    
    $query = "INSERT INTO posts (title, content) VALUES ('$title', '$content')";
    $mysqli->query($query);
}

$results = $mysqli->query("SELECT * FROM posts ORDER BY created_at DESC");

?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Paneli</title>
</head>
<body>
    <h1>Gönderi Ekle</h1>
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
</body>
</html>
