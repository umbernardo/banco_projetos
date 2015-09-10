<?php

class CupMailer extends CupNucleo {

    public $template = 'email_template';
    public $from;
    public $to;
    public $subject;
    public $message;
    public $replyTo;

    public function __construct(array $config) {
        $this->from = 'bot@' . $_SERVER["HTTP_HOST"];
        return parent::__construct($config);
    }

    public function enviaEmail($dados, $to = null, $subject = 'Contato através do site', $viewEmail = 'email_contato', $replyTo = '') {
        $this->to = $to;
        $this->subject = $subject;
        $this->replyTo = $replyTo;

        if (is_null($this->to)) {
            $this->to = $this->retornaEmail();
        }
        $this->message = $this->renderizar($viewEmail, array('dados' => $dados, 'subject' => $this->subject), true);
        return $this->send();
    }

    private function send() {
        $mail = new PHPMailer;
        if (!empty($this->config->mailer)) {
            //$mail->SMTPDebug = 3;                               // Enable verbose debug output
            $mail->isSMTP();                                      // Set mailer to use SMTP
            $mail->Host = $this->config->mailer->Host;  // Specify main and backup SMTP servers
            $mail->SMTPAuth = $this->config->mailer->SMTPAuth;                               // Enable SMTP authentication
            $mail->Username = $this->config->mailer->Username;                 // SMTP username
            $mail->Password = $this->config->mailer->Password;                           // SMTP password
            if (isset($this->config->mailer->SMTPSecure)) {
                $mail->SMTPSecure = $this->config->mailer->SMTPSecure;                            // Enable TLS encryption, `ssl` also accepted
            }
            $mail->Port = $this->config->mailer->Port;                                    // TCP port to connect to
            $mail->From = $this->config->mailer->From;
            $mail->FromName = $this->config->mailer->FromName;
        } else {
            $mail->From = $this->from;
            $mail->FromName = $this->config->site->titulo;
            $mail->isMail();
        }
        if (!empty($this->replyTo)) {
            $mail->addReplyTo($this->replyTo);
        }
        $mail->addAddress($this->to);     // Add a recipient
        $mail->addReplyTo($this->to);
        $mail->CharSet = 'UTF-8';
        $mail->isHTML(true);                                  // Set email format to HTML

        $mail->Subject = $this->subject;
        $mail->Body = $this->message;

        if (!$mail->send()) {
            if (true == $this->config->debug) {
                die('Mailer Error: ' . $mail->ErrorInfo);
            }
            return false;
        } else {
            return true;
        }
    }

}
