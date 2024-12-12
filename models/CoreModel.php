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

    public function __construct()
    {
      $this->connect();
    }

    /**
     * Connexion a la base de donnée
     * 
     * @return void
     * 
     */
    private function connect() : void
    {
      try
      {
        $dsn = $this->_engine . ':host=' . $this->_host .  ';dbname='.$this->_dbname .';charset='.$this->_charset;
        $this->_db = new PDO($dsn, $this->_dbuser, $this->_dbpwd, [PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC]);
      } catch(PDOException $e)
      {
        die($e->getMessage());
      }
    }

    /**
     * Getter de _db qui nous retourne un objet PDO
     * 
     * @return PDO
     * 
     */
    protected function getDb() : PDO
    {
      return $this->_db;
    }


    public function makeRequest($sql, $params = []){

      $pdo = $this->getDb();
    
      if(empty($params)){
        return $pdo->query($sql);
      } else {
    
        if(($request = $pdo->prepare($sql)) !== false){
    
          foreach($params as $key => $value){
            if(($request->bindValue($key, $value == '' ? null : $value)) === false){
              return false;
            }
          }
          if($request->execute()){
            return $request;
          }else{
            return false;
          }
    
        }
      }
    
    }
    
    
    
    public function makeSelect($sql, $params = []){
    
      $request = $this->makeRequest($sql, $params);
    
      $results = $request->fetchAll(PDO::FETCH_ASSOC);
      $request->closeCursor();
      if(($results !== false) && (count($results) < 2) ){
        return $results[0];
      }
    
      return $results;
    
    }

    

    public function cleanInput($data) 
    {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }

}