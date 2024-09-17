<?php
$mysqli = new mysqli("localhost", "root", "", "simple_cms");

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$results = $mysqli->query("SELECT * FROM posts ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Gönderiler</title>
</head>
<body>
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
