<?php

namespace App\Helpers;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AppHelper
{

	public function search_multi_array($search, $column, $array){
		if (is_array($array)) {
			foreach ($array as $key => $a) {
				if ($columnFound = array_search($search, $a)) {
					if ($columnFound == $column) {
						return $key;
					}
				}
			}
		}else{
			return false;
		}
		return false;
	}
	
	public function getImages(){
		$imageArray = Storage::disk('images')->allfiles();
		$images = [];
		foreach($imageArray as $image){
			$extension = pathinfo($image, PATHINFO_EXTENSION);
			if(in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'tiff', 'psd']) && !strpos($image, '_T') && !strpos($image, '_S') && !strpos($image, '_FB')){
				//check for thumbnail versions in array
				if(!in_array(str_replace('.', '_T.', $image), $imageArray) || !in_array(str_replace('.', '_S.', $image), $imageArray) || !in_array(str_replace('.', '_FB.', $image), $imageArray)){
					//add it
					$this->thumbnailable['fields'][$image] = [
						'thumb_method' => 'resize',
						'sizes' => [
							'T' => '64x64',
							'S' => '100x100',
							'FB' => '600x315',
						]
					];
					$this->rethumb($image);
				}
				$images['/images/' . $image] = $image;
			}
		}
		return $images;
	}
	
	public static function instance()
	{
		return new AppHelper();
	}
}