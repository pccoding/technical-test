<?php

class Mail {
    
    private $id_email=0;
    private $recipient="";
    private $subject="";
    private $content="";

    public function setMailVariables($id_email, $recipient, $subject, $content){
        $this->id_email = $id_email;
        $this->recipient = $recipient;
        $this->content = $content;
        $this->subject = $subject;
    }
    
    function getId_email() {
        return $this->id_email;
    }

    function setId_email($id_email) {
        $this->id_email = $id_email;
    }
    
    function getRecipient() {
        return $this->recipient;
    }

    function getSubject() {
        return $this->subject;
    }

    function getContent() {
        return $this->content;
    }

    function setRecipient($recipient) {
        $this->recipient = $recipient;
    }

    function setSubject($subject) {
        $this->subject = $subject;
    }

    function setContent($content) {
        $this->content = $content;
    }
}
