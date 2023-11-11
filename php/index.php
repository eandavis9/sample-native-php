<?php
define('ROOT', __DIR__);
require_once(ROOT . '/class/News.php');
require_once(ROOT . '/class/Comment.php');
require_once(ROOT . '/utils/DB.php');
require_once(ROOT . '/utils/NewsManager.php');
require_once(ROOT . '/utils/CommentManager.php');

// Instantiate the DB class
$db = new DB();

// Create instances of NewsManager and CommentManager
$newsManager = new NewsManager($db);
$commentManager = new CommentManager($db);

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submit_news'])) {
        // Handle adding news
        $title = $_POST['news_title'];
        $body = $_POST['news_body'];
        $newsManager->addNews($title, $body);
    } elseif (isset($_POST['submit_comment'])) {
        // Handle adding comments
        $commentBody = $_POST['comment_body'];
        $newsId = $_POST['news_id'];
        $commentManager->addCommentForNews($commentBody, $newsId);
    } elseif (isset($_POST['delete_news'])) {
        // Handle deleting news
        $newsId = $_POST['delete_news_id'];
        $newsManager->deleteNews($newsId);
    } elseif (isset($_POST['delete_comment'])) {
        // Handle deleting comment
        $commentId = $_POST['delete_comment_id'];
        $commentManager->deleteComment($commentId);
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News and Comments</title>
</head>
<body>

<h1>News and Comments</h1>

<!-- Form to add news -->
<form method="post" action="">
    <h2>Add News</h2>
    <label for="news_title">Title:</label>
    <input type="text" name="news_title" required>
    <br>
    <label for="news_body">Body:</label>
    <textarea name="news_body" required></textarea>
    <br>
    <input type="submit" name="submit_news" value="Add News">
</form>

<hr>

<!-- Form to delete news -->
<form method="post" action="">
    <h2>Delete News</h2>
    
    <label for="delete_news_id">Select News:</label>
    <select name="delete_news_id" required>
        <?php
        foreach ($newsManager->listNews() as $news) {
            echo "<option value=\"{$news->getId()}\">{$news->getTitle()}</option>";
        }
        ?>
    </select>
    
    <br>
    <input type="submit" name="delete_news" value="Delete News">
</form>

<hr>

<!-- Display existing news and comments -->
<?php
foreach ($newsManager->listNews() as $news) {
    echo "<h3>News #" . $news->getId() . ": " . $news->getTitle() . "</h3>";
    echo "<p>" . $news->getBody() . "</p>";

    $newsComments = $commentManager->listComments($news->getId());

    foreach ($newsComments as $comment) {
        echo "<p>Comment #" . $comment->getId() . ": " . $comment->getBody() . "</p>";
        echo "<form method='post' action=''>";
        echo "<input type='hidden' name='delete_comment_id' value='{$comment->getId()}'>";
        echo "<input type='submit' name='delete_comment' value='Delete Comment'>";
        echo "</form>";
    }

    echo "<br><form method='post' action=''>";
    echo " <label for='comment_body'>Comment Body:</label>";
    echo "<textarea name='comment_body' required></textarea>";
    echo "<input type='hidden' name='news_id' value='{$news->getId()}'>";
    echo "<input type='submit' name='submit_comment' value='Add Comment'>";
    echo "</form>";
}
?>

</body>
</html>