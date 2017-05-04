<?php
session_start(); //Sessions data is saved for accounts.
ob_start(); //Static content loads first.
//This is required for account data to be saved.

$con = mysqli_connect("host","user","password","database");
//Enter your MYSQL details here.

$info = array(
	'title'=>'AdvancedBan Web Addon', //This will be displayed in the title, main jumbotron, and navigation bar.
	'description'=>'A simple, but sleek, web addon for AdvancedBan.', //This will be displayed under the title on all pages.
	'theme'=>'yeti', //This is the name of the theme you wish to load. You can find a list of compatible themes at http://bootswatch.com/.
	'table'=>'PunishmentHistory', //The table of your MYSQL database for which punishments are saved.
	
	//THE FOLLOWING SECTION REQUIRES WEBSENDER TO RUN (https://www.spigotmc.org/resources/websender-send-command-with-php-bungee-and-bukkit-support.33909/)
	
	'admin'=>array(
		'host'=>'host', //The host of your server.
		'port'=>'port', //The port of your server. This is the port you set in the WebSender configuration file.
		'password'=>'password', //The password of your server. This is the password you set in the WebSender configuration file.
		'accounts'=>array('test') //The list of users that can log in to the dashboard. These must be active accounts from https://theartex.net.
		)
	);

if (mysqli_connect_errno()) {
	die('Failed to connect to database.'); //Restrict access to any page if no connection is established.
}

//-----------------------------------------------------------------------------------
// (!) The following portion of the database.php file does not require changes. (!)
//-----------------------------------------------------------------------------------


//Use the developer API from theartex.net for user authentication checks.
if(!empty($_SESSION['id'])) {
	$params = array(
		'sec'=>'login',
		'username'=>$_SESSION['username'],
		'password'=>$_SESSION['val']);
	$json = httpPost("https://www.theartex.net/cloud/api/index.php",$params);
	$json = json_decode($json, true);
	if($json['data']['banned'] == "no" && $json['data']['active'] == "yes") {
		$_SESSION['id'] = $json['data']['id'];
		$_SESSION['username'] = $json['data']['username'];
		$_SESSION['val'] = $json['data']['val'];
		$_SESSION['role'] = $json['data']['role'];
		$_SESSION['key'] = $json['data']['key'];
	} else {
		session_destroy();
	}
	$params = array(
		'sec'=>'session',
		'page'=>$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'],
		'ip'=>$_SERVER['REMOTE_ADDR'],
		'key'=>$_SESSION['key']);
	$json = httpPost("https://www.theartex.net/cloud/api/index.php",$params);
	$json = json_decode($json, true);
	if($json['status'] != 'success') {
		die('An error occurred while contacting the application API: '.$json['message']);
	}
}

//API post function to allow easy use of the developer API.
function httpPost($url,$params) {
 
    $ch = curl_init();  
 
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true); 
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));    
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
 
    $output = curl_exec($ch);
	
	if(curl_error($ch)) {
		die('An error occurred while contacting the application API:' . curl_error($ch));
	}
 
    curl_close($ch);
	
	return $output;
}

//WebSender API.
class WebsenderAPI{
	
	public $timeout = 30;

	var $host;
	var $password;
	var $port;
	var $socket;
	
	public function __construct($host, $password, $port){
		$this->host = $host;
		$this->password = $password;
		$this->port = $port;
	}

	public function __destruct(){
        if($this->socket)
            $this->disconnect();
    }

	public function connect(){
		$this->socket = fsockopen($this->host, $this->port, $errno, $errstr, $this->timeout);
		if(!$this->socket) return false;
		$this->writeRawByte(1);
		$random_code = $this->readRawInt();
		$hash_password = hash("SHA512", $random_code.$this->password);
		$this->writeString($hash_password);
		$get_result = $this->readRawInt();
		return $get_result == 1 ? true: false;
	}
	
	public function sendCommand($command){
		$this->writeRawByte(2);
		$this->writeString($command);
		return $this->readRawInt() == 1 ? true: false;
	}
	
	public function disconnect(){
		if(!$this->socket) return false;
		$this->writeRawByte(3);
		return true;
	}
	
	private function writeRawInt($i){
		fwrite($this->socket, pack("N", $i), 4);
	}

	private function writeRawByte($b){
		fwrite($this->socket, strrev(pack("C", $b)));
	}

	private function writeString($string){
		$array = str_split($string);
		$this->writeRawInt(count($array));
		foreach($array as &$cur){
			$v = ord($cur);
			$this->writeRawByte((0xff & ($v >> 8)));
			$this->writeRawByte((0xff & $v));
		}
	}

	private function readRawInt(){
		$a = $this->readRawByte();
		$b = $this->readRawByte();
		$c = $this->readRawByte();
		$d = $this->readRawByte();
		$i = ((($a & 0xff) << 24) | (($b & 0xff) << 16) | (($c & 0xff) << 8) | ($d & 0xff));
		if($i > 2147483648)
	 		$i -= 4294967296;
		return $i;
	}
		
	private function readRawByte(){
		$up = unpack("Ci", fread( $this->socket, 1));
		$b = $up["i"];
		if($b > 127)
			$b -= 256;
		return $b;
	}		
	
}
?>