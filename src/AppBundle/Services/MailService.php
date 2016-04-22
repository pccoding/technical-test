<?php
/**
 * Created by PhpStorm.
 * User: razvanp
 * Date: 22/04/2016
 * Time: 12:10
 */

namespace AppBundle\Services;


use AppBundle\Entity\Mail as MailRow;

class MailService {

    /**
     * @var \Mandrill
     */
    protected $mandrill;

    /**
     * @return void
     */
    public function __construct() {
        //TODO - bad dependency - code using an interface and bind it to container
        //TODO - get the api key from config
        $this->mandirll = new \Mandrill('DS2Mwlxq1Gr5k5TcUq8P5g');
    }

    public function send(MailRow $entity) {

        try {

            // TODO - place it in mandrill config
            $async = false;

            //good to have if you need to group the emails
            //$ip_pool
            $message = $this->mapEntityToMessage($entity);
            $result = $this->mandirll->messages->send($message, $async);
            // TODO - extract status into a constant
            if (isset($result[0]) &&  isset($result[0]['status']) && $result[0]['status'] == "sent" ) {
                return true;
            }

        } catch (\Mandrill_Error $e) {
            // TODO - log the error or trow new exception or collect it in command and use a log class
            //throw $e;
        }
        return false;
    }

    /**
     * @param MailRow $entity
     * @return array
     */
    protected function mapEntityToMessage(MailRow $entity) {

        $message = [];
        $message['text'] = $entity->getContent();
        $message['subject'] = $entity->getSubject();
        //bad - has to be in config
        $message['from_email'] = "test@test.com";
        $message['from_name'] = "Test";

        $message['to']['email'] = $entity->getRecipient();

        return $message;

    }

}