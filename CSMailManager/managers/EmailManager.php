<?php

require_once 'entities/Mail.php';
require_once 'database/DBConnect.php';
require_once 'external_libraries/mandrill-api/src/Mandrill.php';

class EmailManager {
    
    public function addEmail(Email $email){
        $dataConnect = new DBConnect();
        $dataConnect->dbAddEmail($email);
    }
    
    private function sendMail(Email $email){

        try{
        $mandrill = new Mandrill('T3CoGhv8ZE1JSmqAXkidQg');
       
        $message = array(
        'text' => $email->getContent(),
        'subject' => $email->getSubject(),
        'to' => array(
            array(
                'email' => $email->getRecipient(),
                'type' => 'to'
                )
            ),
        );
        
        $async = false;
        $ip_pool = 'Main Pool';
        $send_at = 'example send_at';
        $result = $mandrill->messages->send($message, $async, $ip_pool, $send_at);
        print_r($result);
        
        }catch(Mandrill_Error $e){
            echo $e->getMessage();
        }
    }
    
    public function sendAllMails(){
        
        $dataConnect = new DBConnect();
        $dataConnect->dbGetFirstEmail();
        
        while($dataConnect->dbGetFirstEmail()){
            $mail = $dataConnect->dbGetFirstEmail();
            $this->sendMail($mail);
        }
    }
}
