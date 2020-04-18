<?php
class User
{
    private $connection;
    private $tableName = "user_master";

    public $id;
    public $name;
    public $email;
    public $password;

    public function __construct($databaseObject)
    {
        $this->connection = $databaseObject;
    }

    function read()
    {
        $sqlQuery = "SELECT user.id, user.name, user.email, user.password   FROM $this->tableName as user";
        $statement = $this->connection->prepare($sqlQuery);
        $statement->execute();

        return $statement;
    }

    function  create()
    {
        $sqlQuery = "INSERT INTO
                " . $this->tableName . "
            SET
                name=:name, email=:email, password=:password";

        $statement = $this->connection->prepare($sqlQuery);

        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = htmlspecialchars(strip_tags($this->password));

        $statement->bindParam(":name", $this->name);
        $statement->bindParam(":email", $this->email);
        $statement->bindParam(":password", $this->password);

        if($statement->execute()){
            return true;
        }

        return false;
    }
    function userById()
    {
        $sqlQuery = "SELECT user.id, user.name, user.email, user.password   FROM $this->tableName as user WHERE user.id = ?";
        $statement = $this->connection->prepare($sqlQuery);

        $statement->bindParam(1, $this->id);
        $statement->execute();

        $row = $statement->fetch(PDO::FETCH_ASSOC);

        $this->name = $row['name'];
        $this->email = $row['email'];
    }
    function update()
    {
        $sqlQuery = "UPDATE
                " . $this->tableName . "
            SET
                name = :name,
                email = :email,
                password = :password
            WHERE
                id = :id";

        $statement = $this->connection->prepare($sqlQuery);

        $this->name = htmlspecialchars(strip_tags($this->name));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = htmlspecialchars(strip_tags($this->password));

        $statement->bindParam(':name', $this->name);
        $statement->bindParam(':email', $this->email);
        $statement->bindParam(':password', $this->password);
        $statement->bindParam(':id', $this->id);

        if($statement->execute()){
            return true;
        }

        return false;
    }
    function delete()
    {
        $sqlQuery = "DELETE FROM " . $this->tableName . " WHERE id = ?";
        $statement = $this->connection->prepare($sqlQuery);
        $this->id = htmlspecialchars(strip_tags($this->id));
        $statement->bindParam(1, $this->id);

        if($statement->execute()){
            return true;
        }

        return false;
    }
}
