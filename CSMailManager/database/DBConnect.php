<?php

class DBConnect {
    
    private $pass = "hzhVhJuMKhJLXCzP";
    private $user = "mail_test";
    private $host = "localhost";
    private $dbname = "mail_manager";
    private $dbHandler;
    
    public function __construct() {
        try{
            $this->dbHandler = new PDO('mysql:host='.$this->host.';dbname='.$this->dbname,$this->user,$this->pass);
        }
        catch(PDOException $e){
            echo $e->getMessage();
            die();
        }
    }
    
    public function dbAddEmail(Mail $email){
        $sqlInsertEmail = "INSERT INTO db_email(recipient,subject,content) VALUES(?,?,?)";
        $query = $this->dbHandler->prepare($sqlInsertEmail);
        $query->execute(array($email->getRecipient(),$email->getSubject(),$email->getContent()));
        return $this->dbHandler->lastInsertId();
    }
    
    public function dbGetFirstEmail(){
        /* TODO there should be if statement checking if there is next mail */
        $sqlGetFirstEmail = "SELECT * FROM db_email LIMIT 1";
        $sqlDeleteEmail = "DELETE FROM db_email where id_email = ?";
        
        $queryGet = $this->dbHandler->query($sqlGetFirstEmail);
        $obj = $queryGet->fetch(PDO::FETCH_OBJ);
        $mail = new Mail();
        $mail->setMailVariables($obj->id_email,$obj->recipient, $obj->subject, $obj->content);
        
        $queryRemove = $this->dbHandler->prepare($sqlDeleteEmail);
        $queryRemove->execute(array($mail->getId_email()));

        return $mail;
    }
}