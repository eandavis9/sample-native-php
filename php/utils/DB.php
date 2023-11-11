<?php

require_once(ROOT . '/vendor/autoload.php'); // Include Composer autoload

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(ROOT); // Specify the path to .env file
$dotenv->load();

class DB
{
    private $pdo;
	
    private $dbName;
    private $dbHost;
    private $dbUser;
    private $dbPassword;
	
    /**
     * Database constructor.
     *
     * Connects to the database using PDO and sets error mode to exception.
     *
     * @throws \PDOException If the database connection fails.
     */
    public function __construct()
    {   
        $this->dbName = $_ENV['DB_NAME'];
        $this->dbHost = $_ENV['DB_HOST'];
        $this->dbUser = $_ENV['DB_USER'];
        $this->dbPassword = $_ENV['DB_PASSWORD'];

        $dsn = 'mysql:dbname=' . $this->dbName . ';host=' . $this->dbHost;

        try {
            $this->pdo = new \PDO($dsn, $this->dbUser, $this->dbPassword);
            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            throw new \PDOException("Database connection failed: " . $e->getMessage());
        }
    }

    /**
     * Prepare SQL statement
     */
	public function prepare($sql)
    {
        return $this->pdo->prepare($sql);
    }

    /**
     * Get last insert id
     */
    public function lastInsertId(): int
    {
        return $this->pdo->lastInsertId();
    }
    
}