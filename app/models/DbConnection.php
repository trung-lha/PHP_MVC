<?php
class Apps_Libs_DbConnection {
    protected $userName="root";
    protected $passWord="root";
    protected $host="localhost";
    protected $database="Mini_project_php";
    protected $tableName;
    protected $queryParams = [];
    protected static $connection = null;

    public function __construct()
    {
        $this->connect();
    }

    public function connect () {
        if (self::$connection == null){
            try {
                self::$connection = new PDO('mysql:host=localhost;dbname='.$this->database, $this->userName, $this->passWord);
                // set the PDO error mode to exception
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch(PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
                die();
            }
        }
    }

    public function buildQueryParams ($params) {
        $default = [
            "select" => "",
            "where" => "",
            "other" => "",
            "params" => "",
            "values" => [], 
            "field" => "",
        ];
        $this->queryParams = array_merge($default,$params);
        return $this;
    }

    public function buildCondition ($condition) {
        if (trim($condition)){
            return "where " . $condition;
        } else {
            return "";
        }
    }
    public function query ($sql, $param = []){
        $q = self::$connection->prepare($sql);
        if ($param && is_array($param)){
            $q->execute($param);
        } else {
            $q->execute();
        }
        return $q;
    }

    public function selectAll () {
        
        $sql = "select ".$this->queryParams["select"] . " from " . $this->tableName . " " 
        . $this->buildCondition($this->queryParams["where"] . " " . $this->queryParams["other"]);
        
        $query = $this->query($sql,$this->queryParams["params"]);
        
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function selectOne () {
        $this->queryParams["other"] = "limit 1";
        $data  = $this->selectAll();
        if($data){
            return $data[0];
        } else return [];
    }

    public function insert () {
        $sql = "insert into ". $this->tableName . " " . $this->queryParams["field"];
        $result = $this->query($sql,$this->queryParams["values"]);
        
        if ($result){
            // return self::$connection->lastInsertId();
            return $this->queryParams["values"];
        } else return FALSE; 
    }

    public function delete () {
        $sql = "delete from  " . $this->tableName . " " .
        $this->buildCondition($this->queryParams["where"]) . " " . $this->queryParams["other"];
        return $this->query($sql);
    }

    public function update () {
        $sql = "update " . $this->tableName . " set " .$this->queryParams["values"] . 
        $this->buildCondition($this->queryParams["where"]) . " " . $this->queryParams["other"];
        return $this->query($sql);
    }

    public function updateProduct ($data) {
        $convert = [
            'id' => $data[0],
            'name' => $data[1],
            'price' => $data[2],
            'quantity' => $data[3],
            'code' => $data[4],
        ];
        $sql = "update ". $this->tableName ." set name=:name, price=:price, quantity=:quantity, code=:code where id=:id";
        $stmt= self::$connection->prepare($sql);
        $stmt->execute($convert);
    }
}