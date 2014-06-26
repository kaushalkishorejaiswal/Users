<?php
namespace Users\Service;

use Zend\Mail;
use Zend\Mail\Transport\Smtp as SmtpTransport;
use Zend\Mail\Transport\SmtpOptions;
use Zend\Mime\Part;
use Zend\Mime\Message;

class UserMailServices
{

    protected $serviceManager;
    
    public function __construct($serviceManager)
    {
        $this->serviceManager = $serviceManager;
    }
    /**
     * common functionality for send email
     *
     * @param array $mailOptions
     *            use mailTo,mailFrom,mailFromNickName,mailSubject,mailBody,...
     *            as options
     * @author Kaushal
     * @method sendMail
     * @return int
     */
    public function sendMail($mailOptions = array())
    {
        $config = $this->serviceManager->get('config');
        $smtpName = $config['settings']['EMAIL']['SMTP_NAME'];
        $smtpHost = $config['settings']['EMAIL']['SMTP_HOST'];
        $smtpPort = $config['settings']['EMAIL']['SMTP_PORT'];
        $smtpConnectionClass = $config['settings']['EMAIL']['SMTP_CONNECTION_CLASS'];
        $smtpUsername = $config['settings']['EMAIL']['SMTP_USERNAME'];
        $smtpPassword = $config['settings']['EMAIL']['SMTP_PASSWORD'];
        $smtpSsl = $config['settings']['EMAIL']['SMTP_SSL'];
        $mailBody = $config['settings']['EMAIL']['BODY'];
        $mailFrom = $config['settings']['EMAIL']['FROM'];
        $mailSubject = $config['settings']['EMAIL']['SUBJECT'];
        $mailFromNickName = $config['settings']['EMAIL']['FROM_NICK_NAME'];
        $mailTo = $config['settings']['EMAIL']['TO'];
        $mailSenderType = $config['settings']['EMAIL']['SMTP_SENDER_TYPE'];
        if (array_key_exists('mailTo', $mailOptions)) {
            $mailTo = $mailOptions['mailTo'];
        }
        if (array_key_exists('mailCc', $mailOptions)) {
            $mailCc = $mailOptions['mailCc'];
        }
        
        if (array_key_exists('mailFrom', $mailOptions)) {
            $mailFrom = $mailOptions['mailFrom'];
        }
        if (array_key_exists('mailFromNickName', $mailOptions)) {
            $mailFromNickName = $mailOptions['mailFromNickName'];
        }
        if (array_key_exists('mailSubject', $mailOptions)) {
            $mailSubject = $mailOptions['mailSubject'];
        }
        if (array_key_exists('mailBody', $mailOptions)) {
            $mailBody = $mailOptions['mailBody'];
        }
        if (array_key_exists('sender_type', $mailOptions)) {
            $mailSenderType = $mailOptions['sender_type'];
        }
        
        $text = new Part($mailBody);
        $text->type = \Zend\Mime\Mime::TYPE_HTML;
        $mailBodyParts = new Message();
        $mailBodyParts->addPart($text);
        if (! empty($mailOptions['realFileName']) && ! empty($mailOptions['tempFilePath'])) {
            $file = new Part(file_get_contents($mailOptions['tempFilePath']));
            $file->encoding = \Zend\Mime\Mime::ENCODING_BASE64;
            $file->type = finfo_file(finfo_open(), $mailOptions['tempFilePath'], FILEINFO_MIME_TYPE);
            $file->disposition = \Zend\Mime\Mime::DISPOSITION_ATTACHMENT;
            // $file->filename =basename($mailOptions['tempFilePath']);
            $file->filename = $mailOptions['realFileName'];
            $mailBodyParts->addPart($file);
        }
        
        $options = new SmtpOptions(array(
            "name" => $smtpName,
            "host" => $smtpHost,
            "port" => $smtpPort
        ));
        
        $mail = new Mail\Message();
        $mail->setBody($mailBodyParts);
        $mail->setFrom($mailFrom, $mailFromNickName);
        $mail->addTo($mailTo);
        if (! empty($mailCc)) {
            $mail->addCc($mailCc);
        }
        $mail->setSubject($mailSubject);
        $transport = new SmtpTransport();
        $transport->setOptions($options);
        $emailLogInfo = array(
            'email_to' => $mailTo,
            'email_from' => $mailFrom,
            'email_body' => $mailBody,
            'email_subject' => $mailSubject,
            'sender_type' => $mailSenderType
        );
        try {
            /*
             * Following line is commented temporary Uncomment while going
             */
            $transport->send($mail);
            $emailSend = 1;
        } catch (\Exception $e) {
            $emailSend = 0;
            $emailLogInfo['email_error'] = $e->getMessage();
            // print_r($emailLogInfo);
            throw $e;
        }
        return $emailSend;
        /*
         * $emailLogInfo['email_send'] = ($emailSend == 1) ? 'y' : 'n'; if (is_array($mailTo)) { foreach ($mailTo as $value) { $emailLogInfo['email_to'] = $value; $emailSave = $this->saveEmailLog($emailLogInfo, $this->getServiceLocator()); } } else { $emailSave = $this->saveEmailLog($emailLogInfo, $this->getServiceLocator()); } $flag = ($emailSave == 1 && $emailSend == 1) ? 1 : 0; return $flag;
         */
    }
}