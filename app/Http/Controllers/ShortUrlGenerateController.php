<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShortUrlGenerator;
use App\Http\Requests\ShortUrlRequest;
use Illuminate\Support\Facades\Hash;

class ShortUrlGenerateController extends Controller
{
    
    

    public function __construct()
    {
        $this->validation = config('validation');
    }
    /**
     * view Shortest Url.
     *
     */


    public  function viewpage(Request $request)
    {
        $shortUrlRequest = ShortUrlGenerator::all();

    	return view('index',compact('shortUrlRequest'));
    }

    /**
     * Generate Shortest Url.
     *
     */
    public function generateShortUrl(ShortUrlRequest $request)
    {   
        $input          = $request->all();
        $url            = $input['url'];
        $string         = !empty($input['stringumber']) ? $input['stringumber'] : $this->validation['randomString'] ; 
        $hashUrl        = hash::make($input['url']);
        
        $urlExistOrNot  = ShortUrlGenerator::where('url',$url)->first();
        if($urlExistOrNot){
            return response()->json([
                'success' => false,
                'message' => 'Url already converted',
                'status'  => 'Bad Request.'
            ],400);
        }else{
            $returnData     = $this->getString($string,$hashUrl);
            $data           = new ShortUrlGenerator;
            $data->url      = $url;
            $data->generated_shortest_url   = $returnData;
            $data->save();
            return response()->json([
                'success' => true,
                'data'    => $data,
                'status'  => 'Success.',
                'message' => 'Successfully generated shortest Url.',
            ],200);

        }
    }

    /**
     * Redirection
     *
     */

    public function shortUrlGeneratedRedirect($code){
    	
	$find = ShortUrlGenerator::where('generated_shortest_url',$code)->first();
	return $find;

    }
    
    /**
     * Dynamic Generate llenth for Shortest Url.
     *
     */
    public static function getString($n,$url) {
        
        $characters = $url;
        $randomString = '';
     
        for ($i = 0; $i < $n; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }
     
        return $randomString;
    }

}
