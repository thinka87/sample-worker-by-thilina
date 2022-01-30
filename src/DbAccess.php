<?php

/**
 * DbAccess Class
 *
 * Using this class can access to mysql database via PDO Object
 */
class DbAccess {

    const DB_HOST = 'localhost';  //database host name
    const DB_NAME = 'speqta_workers'; //database name
    const DB_USER = 'root'; //database username
    const DB_PASSWORD = ''; //databse password
    const DB_PORT = 3307;  // mysql =3306 , maria db =3307

    /**
     * To store new PDO instance
     * @type object
     * @access private
     */
    private $pdo = null;

    /**
     * To get a PDO instance if not exist
     * @type object
     * @access private
     */
    private static $instance = null;

    /**
     * Open the database connection
     */
    public function __construct() {
        // open database connection
        $conStr = sprintf("mysql:host=%s;port=%s;dbname=%s", self::DB_HOST, self::DB_PORT, self::DB_NAME);
        try {
            $this->pdo = new PDO($conStr, self::DB_USER, self::DB_PASSWORD);
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    }

    /**
     * Get a PDO instance if not exist
     * @access public
     * Returns PDO object instance if not exist
     * @return object
     */
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new DbAccess();
        }
        return self::$instance;
    }

    /**
     * Get new URL job by worker
     * @access public
     * Returns the selected database row ,Upon failure returns false.
     * @return array|bool
     */
    public function getURLJob() {

        try {

            //select very firdt job for worker
            $this->pdo->beginTransaction();

            $sql = 'SELECT * FROM url_list WHERE status=:status LIMIT 1 FOR UPDATE';
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(array(":status" => "NEW"));
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            //if result set
            if ($result) {

                //change the status of url into "PROCESSING"
                $sql_update_from = 'UPDATE url_list
				SET status=:status
				WHERE id = :id';
                $stmt = $this->pdo->prepare($sql_update_from);
                $stmt->execute(array(":status" => "PROCESSING", ":id" => $result["id"]));
            }

            $this->pdo->commit();

            return $result;
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            die($e->getMessage());
        }
    }

    /**
     * Get total job count that need to run by workers
     * @access public
     * Returns the number of rows that need run by workers.
     * @return int
     */
    public function getAvailableJobCount() {

        $sql = 'SELECT COUNT(*) FROM url_list WHERE status=:status';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(array(":status" => "NEW"));
        $row_count = $stmt->fetchColumn();
        $stmt->closeCursor();
        return $row_count;
    }

    /**
     * Update URL status after URL processed by worker
     * @access public
     * Returns true ,Upon failure throw exception.
     * @return bool|PDOException
     */
    public function updateUrlStatus($id, $status, $http_code) {
        try {

            $this->pdo->beginTransaction();
            $sql_update_from = 'UPDATE url_list SET status=:status, http_code=:http_code WHERE id = :id';
            $stmt = $this->pdo->prepare($sql_update_from);
            $stmt->execute(array(":status" => $status, ":http_code" => $http_code, ":id" => $id));
            $stmt->closeCursor();
            $this->pdo->commit();
            return true;
        } catch (PDOException $e) {

            $this->pdo->rollBack();
            die($e->getMessage());
        }
    }

    //close the database connection

    public function __destruct() {
        $this->pdo = null;
    }

    //Reset the database table for testing purpose
    public function resetAll() {

        $sql_update_from = 'UPDATE url_list SET status=:status,http_code=:http_code';
        $stmt = $this->pdo->prepare($sql_update_from);
        $stmt->execute(array(":status" => "NEW", ":http_code" => NULL));
        $stmt->closeCursor();
        return true;
    }

}
