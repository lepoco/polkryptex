<?php

/**
 * @package   Polkryptex
 *
 * @copyright Copyright (c) 2021 - Kacper J., Pawel L., Filip S., Szymon K., Leszek P.
 * @license   https://www.gnu.org/licenses/gpl-3.0.txt
 */

namespace App\Core;

use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/**
 * TODO This class is a huge mess
 * 
 * @author Leszek P.
 */
final class Mailer
{
    private PHPMailer $mail;

    private array $sections = [];

    private string $template;

    private string $url;

    private string $title;

    private string $footer;

    private string $subfooter;

    private string $logo;

    public function __construct()
    {
        $this->mail = new PHPMailer(true);
        $this->mail->SMTPDebug = Debug::isMailDebug();

        $this->setupSMTP();
        $this->setupMailer();
    }

    /**
     * @param Array|String $recipient
     * */
    public function send($recipients, ?string $subject = null, ?string $header = null, ?string $message = null, ?string $altMessage = null): bool
    {
        try {

            if (is_array($recipients)) {
                foreach ($recipients as $recipient) {
                    $this->mail->addAddress($recipient);
                }
            }

            if (!is_array($recipients)) {
                $this->mail->addAddress($recipients);
                //$this->mail->addAddress('joe@example.net', 'Joe User');
            }


            $this->mail->isHTML(true);
            $this->mail->Subject = $subject ?? Registry::get('Options')->get('site_name', 'Polkryptex');


            $this->mail->Body = $this->fromTemplate($message, $header ?? $subject);
            $this->mail->AltBody = null === $altMessage ? $this->plainBody($message) : $altMessage;

            if (!Debug::isDebug()) {
                $this->mail->XMailer = 'Microsoft Mailer';
            }

            $this->mail->send();

            return true;
        } catch (Exception $e) {
            //echo "Message could not be sent. Mailer Error: {$this->mail->ErrorInfo}";
            return false;
        }
    }

    public function addSection(array $args): void
    {
        $this->sections[] = $args;
    }

    public function addAttachment(string $filePath, string $fileName = ''): void
    {
        $this->mail->addAttachment($filePath, $fileName);
    }

    public function addCC(string $mail): void
    {
        $this->mail->addCC($mail);
    }

    public function addBCC(string $mail): void
    {
        $this->mail->addBCC($mail);
    }

    public function setFooter(string $footer): void
    {
        $this->footer = $footer;
    }

    public function setSubFooter(string $subfooter): void
    {
        $this->subfooter = $subfooter;
    }

    private function setupMailer(): void
    {
        $this->mail->setFrom(
            Registry::get('Options')->get('mail_sendfrom', 'mail@example.com'), //sender address
            Registry::get('Options')->get('mail_sendname', 'Polkryptex') //sender name
        );

        $this->mail->addReplyTo(
            Registry::get('Options')->get('mail_replyto', 'mail@example.com'), //sender name
            Registry::get('Options')->get('mail_sendname', 'Polkryptex') //sender addres   
        );

        $this->mail->CharSet = 'UTF-8';
        //Content-Type: text/plain; charset="UTF-8"; format=flowed; delsp=yes

        $baseurl = Registry::get('Options')->get('baseurl', 'https://example.com/');

        $this->template = 'main';
        $this->logo = Registry::get('Options')->get('mail_logo', $baseurl . 'media/icons/192.png');
        $this->url = Registry::get('Options')->get('baseurl', $baseurl);
        $this->title = Registry::get('Options')->get('mail_title', 'Polkryptex INC');
        $this->footer = Registry::get('Options')->get('mail_footer', 'Polkryptex INC, NY Box 1002/1');
        $this->subfooter = 'You received this email to let you know about important changes to your Polkryptex Account and services.';
        //<a class="original-only" style="color: #666666; text-decoration: none;">Unsubscribe</a><span class="original-only" style="font-family: Arial, sans-serif; font-size: 12px; color: #444444;">&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;</span><a style="color: #666666; text-decoration: none;">View this email in your browser</a>
    }

    private function setupSMTP(): void
    {
        if (!Registry::get('Options')->get('mail_smtp', false)) {
            return;
        }

        $this->mail->isSMTP();                                            //Send using SMTP
        $this->mail->Host       = 'smtp.example.com';                     //Set the SMTP server to send through
        $this->mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $this->mail->Username   = 'user@example.com';                     //SMTP username
        $this->mail->Password   = 'secret';                               //SMTP password
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $this->mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    }

    private function fromTemplate(?string $message = null, ?string $header = null): string
    {
        $path = ABSPATH . 'app/common/mail/' . $this->template . '.template.php';

        if (!is_file($path)) {
            return $message;
        }

        $sections = '';

        if (!empty($message)) {
            $sections .= $this->composeSection(['header' => $header, 'message' => $message]);
        }

        foreach ($this->sections as $section) {
            $sections .= $this->composeSection($section);
        }

        $content = file_get_contents($path);
        $content = str_replace(
            [
                '{{ $language }}',
                '{{ $url }}',
                '{{ $title }}',
                '{{ $footer }}',
                '{{ $subfooter }}',
                '{{ $logo }}',
                '{{ $sections }}'
            ],
            [
                'en',
                $this->url,
                $this->title,
                $this->footer,
                $this->subfooter,
                $this->logo,
                $sections
            ],
            $content
        );

        return $content;
    }

    private function plainBody(?string $message = null): string
    {
        $plainMessage = '';

        if (!empty($message)) {
            $plainMessage .= $message . PHP_EOL . PHP_EOL;
        }

        foreach ($this->sections as $section) {
            if (isset($section['header'])) {
                $plainMessage .= str_replace('<br>', PHP_EOL, $section['header']) . PHP_EOL;
            }

            if (isset($section['message'])) {
                $plainMessage .= str_replace('<br>', PHP_EOL, $section['message']) . PHP_EOL;
            }

            $plainMessage .= PHP_EOL;

            if (isset($section['buttons']) && is_array($section['buttons'])) {
                foreach ($section['buttons'] as $button) {
                    if(isset($button['url'])) {
                        $plainMessage .= $button['url'] . PHP_EOL;
                    }
                }
            }
        }

        return $plainMessage;
    }

    private function composeSection(array $args): string
    {
        $background_color = (isset($args['background']) ? $args['background'] : '#ffffff');
        $max_width = 'max-width: ' . (isset($args['max_width']) ? $args['max_width'] : '600px');

        $html = '<table border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;"><tr><td bgcolor="' . $background_color . '" align="center" style="padding: 70px 15px 70px 15px;" class="section-padding"><table style="' . $max_width . '" width="100%" border="0" cellspacing="0" cellpadding="0">';

        if (isset($args['image'])) {
            $html .= '<tr><td><table width="100%" border="0" cellspacing="0" cellpadding="0"><tbody><tr><td class="padding-copy"><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td>';
            $html .= '<a href="#" target="_blank" style="text-align:center;"><img src="' . $args['image'] . '" width="500" height="200" border="0" alt="Can an email really be responsive?" style="object-fit: contain;display: block; padding: 0; color: #666666; text-decoration: none; font-family: Helvetica, arial, sans-serif; font-size: 16px; width: 500px; height: 200px;" class="img-max"></a>';
            $html .= '</td></tr></table></td></tr></tbody></table></td></tr>';
        }

        if (isset($args['message']) || isset($args['header'])) {
            $html .= '<tr><td><table width="100%" border="0" cellspacing="0" cellpadding="0">';

            if (isset($args['header'])) {
                $html .= '<tr><td align="center" style="font-size: 25px; font-family: Helvetica, Arial, sans-serif; color: #333333; padding-top: 30px;" class="padding-copy">' . $args['header'] . '</td></tr>';
            }

            if (isset($args['message'])) {
                $html .= '<tr><td align="center" style="padding: 20px 0 0 0; font-size: 16px; line-height: 25px; font-family: Helvetica, Arial, sans-serif; color: #666666;" class="padding-copy">' . $args['message'] . '</td></tr>';
            }

            $html .= '</table></td></tr>';
        }

        if (isset($args['buttons']) && is_array($args['buttons'])) {
            $html .= '<tr><td><table width="100%" border="0" cellspacing="0" cellpadding="0" class="mobile-button-container"><tr><td align="center" style="padding: 25px 0 0 0;" class="padding-copy"><table border="0" cellspacing="0" cellpadding="0" class="responsive-table">';

            foreach ($args['buttons'] as $button) {
                $html .= '<tr><td align="center"><a href="' . $button['url'] . '" target="_blank" style="font-size: 16px; font-family: Helvetica, Arial, sans-serif; font-weight: normal; color: #ffffff; text-decoration: none; background-color: ' . $button['color'] . '; border-top: 15px solid ' . $button['color'] . '; border-bottom: 15px solid ' . $button['color'] . '; border-left: 25px solid ' . $button['color'] . '; border-right: 25px solid ' . $button['color'] . '; border-radius: 3px; -webkit-border-radius: 3px; -moz-border-radius: 3px; display: inline-block;" class="mobile-button">' . $button['name'] . '</a></td></tr>';
            }

            $html .= '</table></td></tr></table></td></tr>';
        }

        return $html . '</table></td></tr></table>';
    }
}
