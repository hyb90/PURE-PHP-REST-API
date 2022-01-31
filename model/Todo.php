<?php
    class Todo{

        // Connection
        private $conn;

        // Table
        private $db_table = "todos";

        // Columns
        public $id;
        public $title;
        public $description;
        public $done;
        public $createdAt;

        // Db connection
        public function __construct($db){
            $this->conn = $db;
        }

        // GET ALL
        public function getTodos(){
            $sqlQuery = "SELECT id, title, description, done, createdAt FROM " . $this->db_table . "";
            $stmt = $this->conn->prepare($sqlQuery);
            $stmt->execute();
            return $stmt;
        }

        // CREATE
        public function createTodo(){
            $sqlQuery = "INSERT INTO
                        ". $this->db_table ."
                    SET
                        title = :title, 
                        description = :description, 
                        done = :done, 
                        createdAt = :createdAt";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            // sanitize
            $this->title=htmlspecialchars(strip_tags($this->title));
            $this->description=htmlspecialchars(strip_tags($this->description));
            $this->done=htmlspecialchars(strip_tags($this->done));
            $this->createdAt=htmlspecialchars(strip_tags($this->createdAt));
        
            // bind data
            $stmt->bindParam(":title", $this->title);
            $stmt->bindParam(":description", $this->description);
            $stmt->bindParam(":done", $this->done);
            $stmt->bindParam(":createdAt", $this->createdAt);
        
            if($stmt->execute()){
               return true;
            }
            return false;
        }

        // UPDATE
        public function getSingleTodo(){
            $sqlQuery = "SELECT
                        id, 
                        title, 
                        description, 
                        done, 
                        createdAt
                      FROM
                        ". $this->db_table ."
                    WHERE 
                    id = ?
                 LIMIT 0,1";

            $stmt = $this->conn->prepare($sqlQuery);

            $stmt->bindParam(1, $this->id);

            $stmt->execute();

            $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);
            if(is_array($dataRow))
            {$this->title = $dataRow['title'];
            $this->description = $dataRow['description'];
            $this->done = $dataRow['done'];
            $this->createdAt = $dataRow['createdAt'];}
        }        

        // UPDATE
        public function updateTodo(){
            $sqlQuery = "UPDATE
                        ". $this->db_table ."
                    SET
                        title = :title, 
                        description = :description, 
                        done = :done
                    WHERE 
                        id = :id";
        
            $stmt = $this->conn->prepare($sqlQuery);
        
            $this->title=htmlspecialchars(strip_tags($this->title));
            $this->description=htmlspecialchars(strip_tags($this->description));
            $this->done=htmlspecialchars(strip_tags($this->done));
            $this->id=htmlspecialchars(strip_tags($this->id));
        
            // bind data
            $stmt->bindParam(":title", $this->title);
            $stmt->bindParam(":description", $this->description);
            $stmt->bindParam(":done", $this->done);
            $stmt->bindParam(":id", $this->id);
        
            if($stmt->execute()){
               return true;
            }
            return false;
        }

        // DELETE
        function deleteTodo(){
            $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE id = ?";
            $stmt = $this->conn->prepare($sqlQuery);
        
            $this->id=htmlspecialchars(strip_tags($this->id));
        
            $stmt->bindParam(1, $this->id);
        
            if($stmt->execute()){
                return true;
            }
            return false;
        }

    }
?>

