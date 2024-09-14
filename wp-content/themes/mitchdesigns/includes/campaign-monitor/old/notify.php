<?
/*
	dlnotify
	========
	Notify someone when a file download occurs	
	
*/
// include campaign monitor API
require_once('CMBase.php');

class dlnotify {
	
	function postToList($email, $name) {
		$api_key = '';
		$client_id = '';
		$campaign_id = null;
		$list_id = '';
		$cm = new CampaignMonitor( $api_key, $client_id, $campaign_id, $list_id );
		
		//This is the actual call to the method, passing email address, name.
		$result = $cm->subscriberAdd($email, $name);

		if($result['Result']['Code'] == 0)
			return 'Success';
		else
			return 'Error : ' . $result['Result']['Message'];
		
	}
	
	function sendNotification($to, $subject, $message) {
		$headers = "From: downloadbot@domain.co.uk\r\nReply-To: noreply@domain.co.uk";
		$mail_sent = @mail($to, $subject, $message, $headers);
		return $mail_sent ? "Mail sent" : "Mail failed";
	}
	

	// which file, which email address to send it to, and who should get it.
	function download($file, $Email, $Name, $email, $name, $phone, $what, $info)
	{	
		if (($name == NULL) || ($email == NULL)) {
			echo 'Please fill in your name and email';
		} else {			
		$time = date("H:i");
		$subject = "[email-bot] $name just downloaded $file";
		
$message = "Hi, $Name

$name ($email) has downloaded $file at $time 

They were looking for information about $what
Phone number: $phone 
Additional Information:
$info

Thanks,
Bot
";
		// do the send
		dlnotify::sendNotification($Email, $subject, $message);
		// add to our list
		dlnotify::postToList($email,$name);
		// send to the actual file
		header ("Location: ".$_GET['file']);
		exit();
	}	
}
};

$ratenotify = new dlnotify();

$ratenotify->download($_GET['file'],'me@you.com', 'Name', $_GET['email'], $_GET['name'], $_GET['phone'], $_GET['what'], $_GET['info']);