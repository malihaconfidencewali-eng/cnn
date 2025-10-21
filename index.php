<?php
include 'db.php';
$categories = ["Home", "Business", "World", "Politics", "Technology", "Sports", "Entertainment"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>CNN Clone</title>
<style>
    body { margin: 0; font-family: 'Poppins', sans-serif; background: #f3f3f3; color: #333; }
    header {
        background: #cc0000;
        color: #fff;
        padding: 20px;
        font-size: 28px;
        text-align: center;
        font-weight: bold;
    }
    nav {
        background: #222;
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
    }
    nav a {
        color: white;
        padding: 12px 20px;
        text-decoration: none;
        text-transform: uppercase;
        font-size: 14px;
        transition: background 0.3s;
    }
    nav a:hover { background: #cc0000; }
    .container {
        max-width: 1200px;
        margin: 30px auto;
        padding: 0 20px;
    }
    h2.section-title {
        border-left: 5px solid #cc0000;
        padding-left: 10px;
        margin-top: 40px;
    }
    .news-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        gap: 25px;
    }
    .news-card {
        background: white;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        overflow: hidden;
        transition: transform 0.2s;
    }
    .news-card:hover { transform: scale(1.02); }
    .news-card img {
        width: 100%;
        height: auto; /* full height automatically adjusts */
        display: block;
    }
    .news-card h3 {
        margin: 10px;
        font-size: 20px;
        color: #cc0000;
    }
    .news-card p {
        margin: 10px;
        font-size: 15px;
        color: #444;
        line-height: 1.5em;
    }
    .add-article-btn {
        display: inline-block;
        background: #cc0000;
        color: #fff;
        padding: 10px 18px;
        border-radius: 6px;
        text-decoration: none;
        margin: 20px;
        font-weight: bold;
        transition: 0.3s;
    }
    .add-article-btn:hover { background: #a80000; }
</style>
</head>
<body>

<header>CNN Clone</header>

<nav>
    <?php foreach ($categories as $cat): ?>
        <a href="?category=<?= urlencode($cat) ?>"><?= $cat ?></a>
    <?php endforeach; ?>
</nav>

<div class="container">
    <a href="add_article.php" class="add-article-btn">+ Add Article</a>

    <?php
    $selectedCategory = $_GET['category'] ?? 'Home';
    echo "<h2 class='section-title'>$selectedCategory News</h2>";

    if ($selectedCategory == 'Home') {
        $result = $conn->query("SELECT * FROM articles ORDER BY id DESC");
    } else {
        $stmt = $conn->prepare("SELECT * FROM articles WHERE category=? ORDER BY id DESC");
        $stmt->bind_param("s", $selectedCategory);
        $stmt->execute();
        $result = $stmt->get_result();
    }

    echo "<div class='news-grid'>";
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='news-card'>
                    <img src='uploads/" . htmlspecialchars($row['image']) . "' alt='News Image'>
                    <h3>" . htmlspecialchars($row['title']) . "</h3>
                    <p>" . nl2br(htmlspecialchars($row['description'])) . "</p>
                  </div>";
        }
    } else {
        echo "<p>No articles found in this category.</p>";
    }
    echo "</div>";
    ?>
</div>

</body>
</html>
