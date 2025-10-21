<?php
include 'db.php';
$categories = ["Business", "World", "Politics", "Technology", "Sports", "Entertainment"];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $imageName = "";

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $targetDir = "uploads/";
        if (!is_dir($targetDir)) mkdir($targetDir);
        $imageName = time() . "_" . basename($_FILES['image']['name']);
        $targetFile = $targetDir . $imageName;
        move_uploaded_file($_FILES['image']['tmp_name'], $targetFile);
    }

    $stmt = $conn->prepare("INSERT INTO articles (title, description, category, image) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $title, $description, $category, $imageName);
    $stmt->execute();

    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Add New Article</title>
<style>
    body {
        font-family: 'Poppins', sans-serif;
        background: linear-gradient(135deg, #cc0000, #660000);
        color: white;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
    }
    form {
        background: white;
        color: #333;
        padding: 30px;
        border-radius: 12px;
        width: 450px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.3);
    }
    h2 {
        text-align: center;
        color: #cc0000;
        margin-bottom: 20px;
    }
    input, textarea, select {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border-radius: 8px;
        border: 1px solid #ccc;
        font-size: 15px;
    }
    button {
        width: 100%;
        padding: 10px;
        background: #cc0000;
        color: white;
        border: none;
        border-radius: 8px;
        font-weight: bold;
        cursor: pointer;
        font-size: 16px;
    }
    button:hover { background: #a80000; }
    a {
        display: block;
        text-align: center;
        margin-top: 15px;
        color: #cc0000;
        text-decoration: none;
        font-weight: bold;
    }
</style>
</head>
<body>
<form method="POST" enctype="multipart/form-data">
    <h2>Add New Article</h2>
    <input type="text" name="title" placeholder="Article Title" required>
    <textarea name="description" placeholder="Article Description" rows="6" required></textarea>
    <select name="category" required>
        <option value="">Select Category</option>
        <?php foreach ($categories as $cat): ?>
            <option value="<?= $cat ?>"><?= $cat ?></option>
        <?php endforeach; ?>
    </select>
    <input type="file" name="image" accept="image/*" required>
    <button type="submit">Add Article</button>
    <a href="index.php">← Back to Home</a>
</form>
</body>
</html>
