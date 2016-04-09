<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Mail_model extends CI_Model
{
	private $mail_config;
	
	function __construct(){
		parent::__construct();
		
		$this->load->database();
		$this->load->library('smtp');
		$this->load->library('phpmailer');

		$query = $this->db->get('bbs_mail_config');
        $settings = $query->result_array();
        foreach ($settings as $setting) {
            $this->mail_config[$setting['item']]=$setting['value'];
        }
	}

	/**
     * 发送Email
	 * @param   $data 关联数组
     * @return  boolean
     */
	
	public function send($data)
	{
		
		$mail = new PHPMailer;

		//$mail->SMTPDebug = 3;                               // Enable verbose debug output
		
		$mail->isSMTP();                                      // Set mailer to use SMTP
		$mail->Host = $this->mail_config['mail_host'];     // Specify main and backup SMTP servers
		$mail->SMTPAuth = true;                               // Enable SMTP authentication
		$mail->Username = $this->mail_config['mail_user']; // SMTP username
		$mail->Password = $this->mail_config['mail_pass']; // SMTP password
		$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
		$mail->Port = 25;                                     // TCP port to connect to
		
		$mail->setFrom($this->mail_config['mail_from'], 'Mailer');
		$mail->addAddress($data['to'], 'User');                       // Add a recipient
		
		//$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
		//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
		$mail->isHTML(true);                                  // Set email format to HTML
		
		$mail->Subject = $data['title'];
		$mail->Body    = $data['body'];
		//$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
		
		if(!$mail->send()) 
		{
			echo 'Message could not be sent.';
			echo 'Mailer Error: ' . $mail->ErrorInfo;
			return false;
		} 
		else 
		{
			echo 'Message has been sent';
			return true;
		}
	}
}
