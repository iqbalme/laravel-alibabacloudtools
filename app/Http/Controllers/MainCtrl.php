<?php

namespace App\Http\Controllers;

use App\Models\Token;
use Illuminate\Http\Request;
use Carbon\Carbon;
require dirname(__DIR__) . '/../../vendor/autoload.php';
use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;

class MainCtrl extends Controller
{
	
	private $AccessKeyID = '';
	private $AccessKeysecret = '';
	private $nlsAppkey = '';
	private $token = '';
	private $audioSaveFile = 'syAudio.wav';
	private $format = 'wav';
	private $sampleRate = 16000;
	
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->nlsAppkey = getenv('nlsAppkey');
		$this->AccessKeyID = getenv('AccessKeyID');
		$this->AccessKeysecret = getenv('AccessKeysecret');
    }


	//Obtain Token
    public function obtain_token(){
		/**
		 * Step 1: Set a global client.
		 * Use the AccessKey ID and the AccessKey secret of your Alibaba Cloud RAM account to perform authentication.
		 */
		AlibabaCloud::accessKeyClient(
					$this->AccessKeyID,
					$this->AccessKeysecret)
					//->regionId("cn-shanghai")
					->regionId("ap-southeast-1")
					->asDefaultClient();
		try {
			$response = AlibabaCloud::nlsCloudMeta()
									->v20180518()
									->createToken()
									->request();
			print $response . "\n";
			$this->token = $response["Token"];
			if ($this->token != NULL) {
				print "Token obtained:\n";
				print_r($this->token);
				Token::updateOrCreate(
					['id' => 1],
					['token' => $this->token['Id'],
					'expired_time' => Carbon::parse($this->token['ExpireTime'])->format('Y-m-d H:i:s')]
				);
			}
			else {
				print "Failed to obtain the token\n";
			}
		} catch (ClientException $exception) {
			// Obtain the error message.
			print_r($exception->getErrorMessage());
		} catch (ServerException $exception) {
			// Obtain the error message.
			print_r($exception->getErrorMessage());
		}
	}
	
	//GET Request for TTS
	function processGETRequest($appkey, $token, $text, $audioSaveFile, $format, $sampleRate) {
		$url = "https://nls-gateway-ap-southeast-1.aliyuncs.com/stream/v1/tts";
		$url = $url . "?appkey=" . $appkey;
		$url = $url . "&token=" . $token;
		$url = $url . "&text=" . $text;
		$url = $url . "&format=" . $format;
		$url = $url . "&sample_rate=" . strval($sampleRate);
		// voice Optional. The speaker. Default value: xiaoyun.
		// $url = $url . "&voice=" . "xiaoyun";
		// volume Optional. The volume. Value range: 0 to 100. Default value: 50.
		// $url = $url . "&volume=" . strval(50);
		// speech_rate Optional. The speed. Value range: -500 to 500. Default value: 0.
		// $url = $url . "&speech_rate=" . strval(0);
		// pitch_rate Optional. The intonation. Value range: -500 to 500. Default value: 0.
		// $url = $url . "&pitch_rate=" . strval(0);
		print $url . "\n";
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
		/**
		 * Set the HTTPS GET URL.
		 */
		curl_setopt($curl, CURLOPT_URL, $url);
		/**
		 * Set the HTTPS header in the response.
		 */
		curl_setopt($curl, CURLOPT_HEADER, TRUE);
		/**
		 * Send the HTTPS GET request.
		 */
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
		$response = curl_exec($curl);
		if ($response == FALSE) {
			print "curl_exec failed!\n";
			curl_close($curl);
			return ;
		}
		/**
		 * Process the response returned by the server.
		 */
		$headerSize = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
		$headers = substr($response, 0, $headerSize);
		$bodyContent = substr($response, $headerSize);
		curl_close($curl);
		if (stripos($headers, "Content-Type: audio/mpeg") != FALSE || stripos($headers, "Content-Type:audio/mpeg") != FALSE) {
			file_put_contents($audioSaveFile, $bodyContent);
			print "The GET request succeed!\n";
		}
		else {
			print "The GET request failed: " . $bodyContent . "\n";
		}
	}

	//POST Request for TTS
	function processPOSTRequest($appkey, $token, $text, $audioSaveFile, $format, $sampleRate) {
		$url = "https://nls-gateway-ap-southeast-1.aliyuncs.com/stream/v1/tts";
		/**
		 * Set request parameters in JSON format in the HTTPS POST request body.
		 */
		$taskArr = array(
			"appkey" => $appkey,
			"token" => $token,
			"text" => $text,
			"format" => $format,
			"sample_rate" => $sampleRate
			// voice Optional. The speaker. Default value: xiaoyun.
			// "voice" => "xiaoyun",
			// volume Optional. The volume. Value range: 0 to 100. Default value: 50.
			// "volume" => 50,
			// speech_rate Optional. The speed. Value range: -500 to 500. Default value: 0.
			// "speech_rate" => 0,
			// pitch_rate Optional. The intonation. Value range: -500 to 500. Default value: 0.
			// "pitch_rate" => 0
		);
		$body = json_encode($taskArr);
		print "The POST request body content: " . $body . "\n";
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
		/**
		 * Set the HTTPS POST URL.
		 */
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_POST, TRUE);
		/**
		 * Set the HTTPS POST request header.
		 * */
		$httpHeaders = array(
			"Content-Type: application/json"
		);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $httpHeaders);
		/**
		 * Set the HTTPS POST request body.
		 */
		curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
		/**
		 * Set the HTTPS header in the response.
		 */
		curl_setopt($curl, CURLOPT_HEADER, TRUE);
		/**
		 * Send the HTTPS POST request.
		 */
		$response = curl_exec($curl);
		if ($response == FALSE) {
			print "curl_exec failed!\n";
			curl_close($curl);
			return ;
		}
		/**
		 * Process the response returned by the server.
		 */
		$headerSize = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
		$headers = substr($response, 0, $headerSize);
		$bodyContent = substr($response, $headerSize);
		curl_close($curl);
		if (stripos($headers, "Content-Type: audio/mpeg") != FALSE || stripos($headers, "Content-Type:audio/mpeg") != FALSE) {
			file_put_contents($audioSaveFile, $bodyContent);
			print "The POST request succeed!\n";
		}
		else {
			print "The POST request failed: " . $bodyContent . "\n";
		}
	}
	
	public function setTextUrlEncode($text){
		$textUrlEncode = urlencode($text);
		$textUrlEncode = preg_replace('/\+/', '%20', $textUrlEncode);
		$textUrlEncode = preg_replace('/\*/', '%2A', $textUrlEncode);
		$textUrlEncode = preg_replace('/%7E/', '~', $textUrlEncode);
		return $textUrlEncode;
	}
	
	public function getTTS(Request $request){
		$token = Token::first()->token;
		$text = "this is sample of my application";
		//$this->processPOSTRequest($this->nlsAppkey, $token, $request->text, $this->audioSaveFile, $this->format, $this->sampleRate);
		$this->processPOSTRequest($this->nlsAppkey, $token, $text, $this->audioSaveFile, $this->format, $this->sampleRate);
	}
	
	public function tesTTS(){
		return Token::first();
	}
	
	//processGETRequest($appkey, $token, $textUrlEncode, $audioSaveFile, $format, $sampleRate);
	//processPOSTRequest($appkey, $token, $text, $audioSaveFile, $format, $sampleRate);
}