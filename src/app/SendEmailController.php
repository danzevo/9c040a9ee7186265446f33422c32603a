<?php

//Load Composer's autoloader
require_once '../../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Exchange\AMQPExchangeType;
use PhpAmqpLib\Message\AMQPMessage;


require_once "../models/SendEMail.php";
require_once "../helper/response.php";

class SendEmailController {
    public function index() {
        try {
            $result = new SendEMail();
            $data = $result->getList();

            response(true, 200, $data);
        } catch(exception $e) {
            response(false, 400, null, $e->getMessage());
        }
    }

    public function show($id) {
        try {
            $result = new SendEMail();
            $data = $result->find($id);

            response(true, 200, $data);
        } catch(exception $e) {
            response(false, 400, null, $e->getMessage());
        }
    }

    public function store() {
        try {
            $result = new SendEMail();
            $item = array(
                'message' => $_POST['message'] ?? '',
                'email' => $_POST['email'] ?? '',
                'user_id' => $_POST['user_id'] ?? '',
            );

            $this->sendQueue($item);
            // $this->sendMail($_POST);
            // $data = $result->save($_POST);

            response(true, 200, null, "Data successful sent");
        } catch(exception $e) {
            response(false, 400, null, $e->getMessage());
        }
    }
    
    public function update($id) {
        try {
            $result = new SendEMail();
            $data = $result->update($_POST, $id);

            if($data)
                response(true, 200, null, "Data successful updated");
            else
                response(true, 200, null, "Data failed updated");
        } catch(exception $e) {
            response(false, 400, null, $e->getMessage());
        }
    }
    
    public function destroy($id) {
        try {
            $result = new SendEMail();
            $data = $result->delete($id);

            if($data)
                response(true, 200, null, "Data successful deleted");
            else
                response(true, 200, null, "Data failed deleted");
        } catch(exception $e) {
            response(false, 400, null, $e->getMessage());
        }
    }

    public function sendQueue($item = array()) {        
        $exchange = 'newEmail';
        $queue = 'email';

        $connection = new AMQPStreamConnection('localhost', '5672', 'guest', 'guest');
        $channel = $connection->channel();

        /*
            The following code is the same both in the consumer and the producer.
            In this way we are sure we always have a queue to consume from and an
                exchange where to publish messages.
        */

        /*
            name: $queue
            passive: false
            durable: true // the queue will survive server restarts
            exclusive: false // the queue can be accessed in other channels
            auto_delete: false //the queue won't be deleted once the channel is closed.
        */
        $channel->queue_declare($queue, false, true, false, false);

        /*
            name: $exchange
            type: direct
            passive: false
            durable: true // the exchange will survive server restarts
            auto_delete: false //the exchange won't be deleted once the channel is closed.
        */

        $channel->exchange_declare($exchange, AMQPExchangeType::HEADERS, false, true, false);

        $channel->queue_bind($queue, $exchange);

        // $messageBody = implode(' ', array_slice($argv, 1));
        $message = new AMQPMessage(json_encode($item), array('content_type' => 'text/plain', 'delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT));
        $channel->basic_publish($message, $exchange);

        $channel->close();
        $connection->close();
    }

    public function sendMail($post = array())
    {
        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true; 
            $mail->SMTPAutoTLS = false;
            $mail->Username   = 'dani.nugrahadi@gmail.com';                     //SMTP username
            $mail->Password   = 'kzrmjvsbdnzdalvr';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

            //Recipients
            $mail->setFrom('dani.nugrahadi@gmail.com', 'Mailer');
            $mail->addAddress($post['email'] ?:'dani.nugrahadi@gmail.com', 'Joe User');     //Add a recipient
            // $mail->addAddress('ellen@example.com');               //Name is optional
            // $mail->addReplyTo('info@example.com', 'Information');
            // $mail->addCC('cc@example.com');
            // $mail->addBCC('bcc@example.com');

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'gotest';
            $mail->Body    = $post['message'] ?: 'This is the HTML message body <b>in bold!</b>';
            // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            return true;
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}