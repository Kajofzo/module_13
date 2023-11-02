<?php 
    require 'vendor/autoload.php';
    use Carbon\Carbon;

    // PDO connection
    $conn = new PDO("mysql:host=localhost;dbname=phpvids", "root", "");
    // Check if form is submitted
    if (isset($_POST['name']) && isset($_POST['comment'])) {
        // Insert data into database
        $stmt = $conn->prepare("INSERT INTO epicvidscomenter (name, comment) VALUES (:name, :comment)");
        $stmt->bindParam(':name', $_POST['name']);
        $stmt->bindParam(':comment', $_POST['comment']);
        $stmt->execute();
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>phpvids</title>
</head>
<body>
    <h1>php videos</h1>
    <!-- Comment submission form -->
    <iframe width="1519" height="589" src="https://www.youtube.com/embed/zZ6vybT1HQs" title="PHP Full Course for non-haters 🐘 (2023)" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
    <form action="#" method="post" enctype="multipart/form-data">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="" required>
        <br>
        <label for="comment">Comment:</label>
        <textarea id="comment" name="comment" rows="4" cols="50" required></textarea>
        <br>
        <input type="submit" value="Submit">
    </form>

    <!-- Comments -->
    <h2>Comments</h2>
    <?php 
        // Get comments from database
        $stmt = $conn->prepare("SELECT * FROM epicvidscomenter ORDER BY time");
        $stmt->execute();
        $comments = $stmt->fetchAll();
        foreach ($comments as $comment) {
            $formatted = htmlspecialchars($comment["comment"]);
            $formattedName = htmlspecialchars($comment["name"]);
            printf("<pre><p><strong>%s</strong>: %s</p><p>%s</p></pre>", $formattedName, $formatted, Carbon::parse($comment["time"])->diffForHumans());
        }
    ?>
</body>
</html>