<?php

require_once(ROOT . '/class/News.php');
require_once(ROOT . '/utils/DB.php');

class NewsManager
{
	private $db;

    public function __construct(DB $db)
    {
        $this->db = $db;
    }

	/**
     * Retrieve a list of all comments.
     *
     * @return News[] An array of News objects representing comments.
	 * 
	 * @throws \PDOException If there is an error executing the query.
     */
    public function listNews(): array
    {
        $stmt = $this->db->prepare('SELECT * FROM `news`');
        $stmt->execute();

        $news = [];
        foreach ($stmt->fetchAll(\PDO::FETCH_ASSOC) as $row) {
            $news[] = new News($row['id'], $row['title'], $row['body'], $row['created_at']);
        }

        return $news;
    }

	/**
     * Add a news
     * @param string $title   The title of the news.
     * @param string $body   The body of the news.
     *
     * @return int The ID of the newly added comment.
	 * 
	 * @throws \PDOException If there is an error executing the query.
     */
    public function addNews($title, $body): int
    {
        $sql = 'INSERT INTO `news` (`title`, `body`, `created_at`) VALUES (?, ?, ?)';
        $createdAt = date('Y-m-d');

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$title, $body, $createdAt]);

        return $this->db->lastInsertId();
    }

	/**
     * Delete a comment by its ID.
     *
     * @param int $id The ID of the news to be deleted.
     *
     * @return int The number of affected rows (should be 1 if the deletion is successful).
	 * 
	 * @throws \PDOException If there is an error executing the query.
     */
    public function deleteNews($id): int
    {
        $sql = 'DELETE FROM `news` WHERE `id` = ?';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);

        return $stmt->rowCount();
    }
}