<?php

namespace App\Helpers;

use Carbon;
use DB;
use Log;
use Throwable;
use App\Models\Response;
use App\Models\Subdomain;
use App\Traits\ThumbnailableTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;

class AppHelper
{

	public static function instance()
	{
		return new AppHelper();
	}

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
}