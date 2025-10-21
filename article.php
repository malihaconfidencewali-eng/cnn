<?php
include 'config.php';

$id = $_GET['id'];
$stmt = $conn->prepare("SELECT * FROM articles WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$article = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <title><?= $article['title'] ?></title>
</head>
<body>
    <header>
        <h1><?= $article['title'] ?></h1>
    </header>
    <main>
        <img src="<?= $article['image'] ?>" alt="<?= $article['title'] ?>">
        <p><?= $article['content'] ?></p>
    </main>
</body>
</html>
