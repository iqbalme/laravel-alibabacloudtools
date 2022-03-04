<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\Products;
use App\Models\Logapi;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Dotenv\Dotenv;
require dirname(__DIR__) . '/../../vendor/autoload.php';

// Reference the SDK package that you download.
require_once dirname(__DIR__) . '/../../storage/uploads/imagesearch-php-sdk-pkg/aliyun-php-sdk-core/Config.php';
use ImageSearch\Request\V20190325\AddImageRequest;
use ImageSearch\Request\V20190325\SearchImageRequest;
use ImageSearch\Request\V20190325\DeleteImageRequest;

class ImageCtrl extends Controller
{

	private $imgSearchRegion = '';
	private $AccessKeyID = '';
	private $AccessKeysecret = '';
	private $imageSearchInstanceName = '';
	// private $image_search_endpoint = env('image_search_endpoint');
	
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->imgSearchRegion = getenv('imgSearchRegion');
		$this->AccessKeyID = getenv('AccessKeyID');
		$this->AccessKeysecret = getenv('AccessKeysecret');
		$this->imageSearchInstanceName = getenv('imageSearchInstanceName');
    }


	public function teslagi(){
		return 'testing';
	}

	public function tesfungsi(){
		$currentImage = storage_path('uploads/');
		//return realpath($currentImage);
		return 'tess';
		//return $this->productByPicture($currentImage.'imgcontoh1.jpg');
		//return realpath($currentImage.'imgcontoh1.jpg');
		// try {
		  // $imageStream = new Stream(fopen($currentImage.'imgcontoh1.jpg', 'r+'));
		  // echo 'berhasil';
		// }

		//catch exception
		// catch(Exception $e) {
		  // echo 'Message: ' .$e->getMessage();
		// }
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
					->regionId("cn-shanghai")
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
	
	public function productByName(Request $request){
		$result = app('db')->select("SELECT * FROM products WHERE product_name LIKE '%" . $request->search . "%'");
		return response()->json($result);
	}
	
	//set random number with specific digits
	public function setRandomNumber($digit){
		$min_num = '1';
		$max_num = '';
		for($i=0;$i<($digit-1);$i++){
			$min_num .= '0';
		}
		for($i2=0;$i2<($digit);$i2++){
			$max_num .= '9';
		}
		$number = mt_rand(intval($min_num), intval($max_num)); //mt_rand(min, max)
		return $number;
	}
	
	public function deleteImageSearch(){
		// Delete the image.
		$deleteRequest = new DeleteImageRequest();
		$deleteRequest->setInstanceName("demo");
		$deleteRequest->setProductId("test");
		try {
			$deleteResponse = $client->getAcsResponse($deleteRequest);
			print_r($deleteResponse);
		} catch(ServerException $e) {
			print "Error: " . $e->getErrorCode() . " Message: " . $e->getMessage() . "\n";
		} catch(ClientException $e) {
			print "Error: " . $e->getErrorCode() . " Message: " . $e->getMessage() . "\n";
		}
	}
	
	public function addImageSearch(){
		// Add the image.
		$addRequest = new AddImageRequest();
		$addRequest->setInstanceName("imgsearch1");
		$addRequest->setProductId("test");
		$addRequest->setPicName("test");
		$content = file_get_contents("/home/admin/demo.jpg");
		$encodePicContent = base64_encode($content);
		$addRequest->setPicContent($encodePicContent);
		// Optional. Specifies whether to recognize the subject in the image and search for images based on the recognized subject. The default value is true.
		// 1. true: The system recognizes the subject in the image, and searches for images based on the recognized subject. You can obtain the recognition result in the response.
		// 2. false: The system does not recognize the subject of the image, and searches for images based on the entire image.
		//$addRequest->setCrop("false");
		//$addRequest->setCrop("true");
		// Optional. The subject area in the image. The subject area is in the format of x1,x2,y1,y2. x1 and y1 represent the upper-left corner pixel. x2 and y2 represent the lower-right pixel.
		// If you specify the Region parameter, the system searches for images based on this parameter setting regardless of the value of the Crop parameter.
		// $addRequest->setRegion("100,300,100,300"); 
		try {
			$addResponse = $client->getAcsResponse($addRequest);
			print_r($addResponse);
		} catch(ServerException $e) {
			print "Error: " . $e->getErrorCode() . " Message: " . $e->getMessage() . "\n";
		} catch(ClientException $e) {
			print "Error: " . $e->getErrorCode() . " Message: " . $e->getMessage() . "\n";
		}
	}
	
	public function productByPicture($imgPath){
		return 'tes versi 2';
		die;
		DefaultProfile::addEndPoint($this->imgSearchRegion, $this->imgSearchRegion, "ImageSearch", "imagesearch.".$this->imgSearchRegion.".aliyuncs.com");
		$profile = DefaultProfile::getProfile($this->imgSearchRegion, $this->AccessKeyID, $this->AccessKeysecret);
		$client = new DefaultAcsClient($profile);
		// Search for images.
		$searchRequest = new SearchImageRequest();
		$searchRequest->setInstanceName($this->imageSearchInstanceName);
		$searchRequest->setType("SearchByName");
		//$searchRequest->setProductId("test");
		$searchRequest->setPicName("imgcontoh1");
		try {
			$searchResponse = $client->getAcsResponse($searchRequest);
			print_r($searchResponse);
		} catch(ServerException $e) {
			print "Error: " . $e->getErrorCode() . " Message: " . $e->getMessage() . "\n";
		} catch(ClientException $e) {
			print "Error: " . $e->getErrorCode() . " Message: " . $e->getMessage() . "\n";
		}
	}
	
	//Search Product in DB by Image
	public function searchProductByImgInDb($arrImage){
		$searchedProducts = [];		
		foreach ($arrImage as $searchThisImage) {
			$foundProducts = Products::where('product_name', 'LIKE', '%' . str_replace('-', ' ', substr(json_encode($arrImage[0]->picName), 1, -5)) . '%')->get();
			//$foundProducts = DB::table('products')->where('product_name', 'LIKE', '%Digital Smart sport%')->get();
			foreach ($foundProducts as $product) {
				$searchedProducts[] = $product;
			}
		}
		print_r(json_encode($searchedProducts));
	}
	
	public function imgUpload(Request $request){
		//header('Access-Control-Allow-Origin: '.$_SERVER['HTTP_ORIGIN']);
		header('Access-Control-Allow-Origin: '.$request->headers->get('origin'));
		//header('Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
		header('Access-Control-Allow-Methods: POST');
		//header('Access-Control-Max-Age: 1000');
		//header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
		if($request->hasFile('gambar')){
			$namaFile = Str::random(34);
			$currentImage = storage_path('uploads/');
			$request->file('gambar')->move($currentImage, $namaFile . '.jpg');
			
			//$imageStream = new Stream(fopen($currentImage . $namaFile . '.jpg', 'r+'));
			//return 'berhasil';
			return $currentImage . $namaFile . '.jpg';
			//$this->productByPicture($currentImage . $namaFile . '.jpg');
			// $currentImage = storage_path('uploads/').'/'.$namaFile;
			// if(file_exists($currentImage)){
				// unlink($currentImage);
			// }
		} else {
			return response()->json(['error' => false, 'message' => 'Tidak ada produk untuk pencarian yang identik.']);
		}
		return response()->json(['error' => true, 'message' => 'Terjadi error. Silakan dicoba lagi !']);
	}
	

}