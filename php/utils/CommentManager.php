<?php

require_once(ROOT . '/class/Comment.php');
require_once(ROOT . '/utils/DB.php');

class CommentManager
{
    /**
     * @var DB The database connection instance.
     */
    private $db;

    /**
     * CommentManager constructor.
     *
     * @param DB $db The database connection instance.
     */
    public function __construct(DB $db)
    {
        $this->db = $db;
    }

    /**
     * Retrieve a list of all comments.
     *
     * @return Comment[] An array of Comment objects representing comments.
	 * 
	 * @throws \PDOException If there is an error executing the query.
     */
    public function listComments($newsId): array
    {
		$sql = 'SELECT * FROM `comment` WHERE `news_id` = ?';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$newsId]);

        $comments = [];
        foreach ($stmt->fetchAll(\PDO::FETCH_ASSOC) as $row) {
            $comments[] = new Comment($row['id'], $row['body'], $row['created_at'], $row['news_id']);
        }

        return $comments;
    }

    /**
     * Add a new comment for a specific news item.
     *
     * @param string $body   The body of the comment.
     * @param int    $newsId The ID of the associated news item.
     *
     * @return int The ID of the newly added comment.
	 * 
	 * @throws \PDOException If there is an error executing the query.
     */
    public function addCommentForNews($body, $newsId): int
    {
        $sql = 'INSERT INTO `comment` (`body`, `created_at`, `news_id`) VALUES (?, ?, ?)';
        $createdAt = date('Y-m-d');

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$body, $createdAt, $newsId]);

        return $this->db->lastInsertId();
    }

    /**
     * Delete a comment by its ID.
     *
     * @param int $id The ID of the comment to be deleted.
     *
     * @return int The number of affected rows (should be 1 if the deletion is successful).
	 * 
	 * @throws \PDOException If there is an error executing the query.
     */
    public function deleteComment($id): int
    {
		$sql = 'DELETE FROM `comment` WHERE `id` = ?';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);

        return $stmt->rowCount();
    }
}