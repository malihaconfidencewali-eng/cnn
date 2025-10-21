<?php
function fetch_articles($conn, $category = null) {
    $query = "SELECT * FROM articles ORDER BY created_at DESC";
    if ($category) {
        $query .= " WHERE category = ?";
    }
    $stmt = $conn->prepare($query);
    if ($category) {
        $stmt->bind_param("s", $category);
    }
    $stmt->execute();
    return $stmt->get_result();
}
?>
