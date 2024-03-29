<?php
declare (strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Models\Products;
use App\Models\Logapi;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Dotenv\Dotenv;
require dirname(__DIR__) . '/../../vendor/autoload.php';

use AlibabaCloud\Client\AlibabaCloud;
use AlibabaCloud\Client\Exception\ClientException;
use AlibabaCloud\Client\Exception\ServerException;

use AlibabaCloud\SDK\ImageSearch\V20201214\ImageSearch;
use AlibabaCloud\SDK\ImageSearch\V20201214\Models\AddImageAdvanceRequest;
use AlibabaCloud\SDK\ImageSearch\V20201214\Models\SearchImageByPicAdvanceRequest;
use AlibabaCloud\SDK\ImageSearch\V20201214\Models\SearchImageByNameRequest;
use AlibabaCloud\SDK\ImageSearch\V20201214\Models\DeleteImageRequest;
use AlibabaCloud\Tea\Exception\TeaUnableRetryError;
use Darabonba\OpenApi\Models\Config;
use AlibabaCloud\Tea\Utils\Utils\RuntimeOptions;
use GuzzleHttp\Psr7\Stream;

class ProductCtrl extends Controller
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


	public function tesfungsi(){
		$currentImage = storage_path('uploads/');
		//return realpath($currentImage);
		return $this->productByPicture($currentImage.'gambar3.jpg');
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
		$config = new Config();
		$config->accessKeyId = $this->AccessKeyID;
		$config->accessKeySecret = $this->AccessKeysecret;
		$config->regionId = $this->imgSearchRegion;
		$config->endpoint = "imagesearch.".$this->imgSearchRegion.".aliyuncs.com";
		$client = new ImageSearch($config);
		$request = new SearchImageByPicAdvanceRequest();
		// $request = new SearchImageByNameRequest();
		// Required. The name of the Image Search instance. 
		$request->instanceName = $this->imageSearchInstanceName;    
		// The image. The image cannot exceed 4 MB in size. The transmission timeout period is 5 seconds. Only the following image formats are supported: PNG, JPG, JPEG, BMP, GIF, WebP, TIFF, and PPM.
		// For product, brand, and generic images, the length and the width of the image must range from 100 pixels to 4,096 pixels.
		// For cloth images, the length and the width of the image must range from 448 pixels to 4,096 pixels.
		// The image cannot contain rotation information.
		//$imageStream = new Stream(fopen(__DIR__ . "/imgcontoh1.jpg", 'r+'));
		$imageStream = new Stream(fopen($imgPath, 'r+'));
		//$imageStream = file_get_contents(__DIR__ . "/imgcontoh1.jpg");
		// $request->productId = "0f5698d5050a9ec4558545348e17c450";
		// $request->picName = "Digital-Smart-sport-watch";
		// Optional. The ID of the product category. 
		// 1. For product image searches: If you set a category ID for an image, the specified category prevails. If you do not set a category ID for an image, the system predicts the category, and returns the ID of the predicted category in the response. 
		// 2. For cloth, brand, and generic image searches: The category ID is set to 88888888 regardless of whether a category ID is set. 
		//$request->categoryId = 5;
		// 1.If you set this parameter to true, the system recognizes the main subject in the image, and searches for images based on the recognized subject. The response includes the recognition result. 
		// 2. If you set this parameter to false, the system does not recognize the main subject in the image, and searches for images based on the entire image. 
		// 3.For cloth image searches, this parameter does not take effect. The system searches for images based on the entire image. 
		//$request->crop = true;
		// Optional. The main area of the image. The value is in the format of x1,x2,y1,y2. x1 and y1 indicate the position of the upper-left point of the area, in pixels. x2 and y2 indicate the position of the lower-right point of the area, in pixels. The specified area cannot cross the boundary of the image. 
		// If you set the main area, the system searches for images based on the main area regardless of the value of the crop parameter. 
		// For cloth image searches, this parameter does not take effect. The system searches for images based on the entire image. 
		//$request->region = "61,254,36,257";
		// Optional. The filter condition. The int_attr field supports the following operators: >, >=, <, <=, and =. The str_attr field supports the following operators: = and !=.You can join multiple filter conditions by using the AND or OR logical operator. 
		// Examples:
		// 1. Filter images based on the int_attr field: int_attr>=100
		// 2. Filter images based on the str_attr field: str_attr!="value1" 
		// 3. Filter images based on int_attr and str_attr fields: int_attr=1000 AND str_attr="value1"
		//$request->filter = "kategori=accessories";
		$request->picContentObject = $imageStream;
		$runtime = new RuntimeOptions();
		$runtime->maxIdleConns = 3;
		$runtime->connectTimeout = 3000;
		$runtime->readTimeout = 3000;
		try {
			// $response = $client->SearchImageByName($request);
			$response = $client->searchImageByPicAdvance($request, $runtime);
			$found_products = $response->body->auctions;
			if(file_exists($imgPath)){
				unlink($imgPath);
			}
			//echo $found_products;
			if($found_products !== null){
				$this->searchProductByImgInDb($found_products);
			} else {
				echo json_encode([]);
			}
		} catch (TeaUnableRetryError $e) {
			return response()->json($e->getLastException());
		} catch (Exception $e) {
			echo 'Message: ' .$e->getMessage();
		}
		
	}
	
	//Search Product in DB by Image
	public function searchProductByImgInDb($arrImage){
		$cariId = array_column($arrImage, 'productId');
		$searchedProducts = Products::whereIn('product_identifier', $cariId)->get();
		echo $searchedProducts;
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
			$this->productByPicture($currentImage . $namaFile . '.jpg');
		} else {
			return response()->json(['error' => false, 'message' => 'Tidak ada produk untuk pencarian yang identik.']);
		}
		//return response()->json(['error' => true, 'message' => 'Terjadi error. Silakan dicoba lagi !']);
	}
	

}