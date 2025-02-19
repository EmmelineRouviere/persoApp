<?php

abstract class CoreModel
{

  private $_engine = DB_ENGINE;
  private $_host = DB_HOST;
  private $_dbname = DB_NAME;
  private $_charset = DB_CHARSET;
  private $_dbuser = DB_USER;
  private $_dbpwd = DB_PWD;
  private $_db;

  /**
   * Constructor: Initializes the database connection
   */
  public function __construct()
  {
    $this->connect();
  }

  /**
   * Establishes a connection to the database
   * 
   * @return void
   * @throws PDOException if connection fails
   * 
   */
  private function connect(): void
  {
    try {
      $dsn = $this->_engine . ':host=' . $this->_host .  ';dbname=' . $this->_dbname . ';charset=' . $this->_charset;
      $this->_db = new PDO($dsn, $this->_dbuser, $this->_dbpwd, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]);
    } catch (PDOException $e) {
      die($e->getMessage());
    }
  }

  /**
   *  * Getter for the PDO database connection object
   * 
   * @return PDO The database connection object
   * 
   */
  protected function getDb(): PDO
  {
    return $this->_db;
  }


  /**
   * Executes a SQL query with optional parameters
   * 
   * @param string $sql The SQL query to execute
   * @param array $params Optional parameters for the query
   * @return PDOStatement|false The PDOStatement object on success, false on failure
   */
  public function makeRequest($sql, $params = [])
  {

    $pdo = $this->getDb();

    if (empty($params)) {
      return $pdo->query($sql);
    } else {

      if (($request = $pdo->prepare($sql)) !== false) {

        foreach ($params as $key => $value) {
          if (($request->bindValue($key, $value == '' ? null : $value)) === false) {
            return false;
          }
        }
        if ($request->execute()) {
          return $request;
        } else {
          return false;
        }
      }
    }
  }

  /**
   * Executes a SELECT query and returns the results
   * 
   * @param string $sql The SQL SELECT query to execute
   * @param array $params Optional parameters for the query
   * @return array|null|mixed Returns null if no results, a single row if one result, or an array of rows for multiple results
   */


  public function makeSelect($sql, $params = [])
  {
    $request = $this->makeRequest($sql, $params);
    $results = $request->fetchAll(PDO::FETCH_ASSOC);
    $request->closeCursor();

    if (empty($results)) {
      return null; // Return null if no result
    } elseif (count($results) === 1) {
      return $results[0]; // Return first element of the array if only one result
    }

    return $results; // Return complete array
  }
}
