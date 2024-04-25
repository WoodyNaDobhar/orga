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
	
	public function fixEloquentName($related){
		switch($related){
			case 'parent':
				return 'Account';
			case 'nearbyGuests':
				return 'Guest';
			case 'honorific':
			case 'awardIssuances':
			case 'issuanceGivens':
			case 'issuanceReceiveds':
			case 'issuanceRevokeds':
			case 'issuanceSigneds':
			case 'titleIssuances':
				return 'Issuance';
			case 'passwordHistories':
				return 'PasswordHistory';
			case 'ageVerifiedBy':
			case 'revoker':
			case 'signator':
			case 'suspendedBy':
				return 'Persona';
			case 'suspensionIssueds':
				return 'Suspension';
			case 'portalteams':
				return 'Team';
			case 'createdBy' :
			case 'updatedBy' :
			case 'deletedBy' :
				return 'User';
			case 'waiverVerifieds':
				return 'Waiver';
			case 'memberships' :
				return 'Member';
			case 'recommendable':
				return 'Recommendation';
			default:
				return ucfirst(Str::singular($related));
		}
	}
	
	public function fixWithName($withItem){
		if(str_starts_with($withItem, 'parent')){
			return 'accounts.';
		} else if(str_starts_with($withItem, 'nearbyGuests')){
			return 'guests.';
		} else if(
			str_starts_with($withItem, 'honorific') ||
			str_starts_with($withItem, 'awardIssuances') ||
			str_starts_with($withItem, 'issuanceGivens') ||
			str_starts_with($withItem, 'issuanceReceiveds') ||
			str_starts_with($withItem, 'issuanceRevokeds') ||
			str_starts_with($withItem, 'issuanceSigneds') ||
			str_starts_with($withItem, 'titleIssuances'))
		{
			return 'issuances.';
		} else if(str_starts_with($withItem, 'passwordHistories')){
			return 'password_histories.';
		} else if(
			str_starts_with($withItem, 'ageVerifiedBy') ||
			str_starts_with($withItem, 'revoker') ||
			str_starts_with($withItem, 'signator') ||
			str_starts_with($withItem, 'suspendedBy'))
		{
			return 'personas.';
		} else if(str_starts_with($withItem, 'suspensionIssueds')){
			return 'suspensions.';
		} else if(
			str_starts_with($withItem, 'createdBy') ||
			str_starts_with($withItem, 'updatedBy') ||
			str_starts_with($withItem, 'deletedBy'))
		{
			return 'users.';
		} else if(str_starts_with($withItem, 'waiverVerifieds')){
			return 'waivers.';
		} else if(str_starts_with($withItem, 'memberships')){
			return 'members.';
		} else if(str_starts_with($withItem, 'recommendable')){
			return 'recommendations.';
		} else {
			return $withItem;
		}
	}
	
	public function fixTableName($tableName){
		switch($tableName){
			case 'accounts':
				return 'accounts|parents';
			case 'guests':
				return 'nearbyGuests|guests';
			case 'issuances':
				return 'issuances|honorific|awardIssuances|issuanceGivens|issuanceReceiveds|issuanceRevokeds|issuanceSigneds|titleIssuances';
			case 'password_histories':
				return 'password_histories|passwordHistories';
			case 'personas':
				return 'personas|ageVerifiedBy|revoker|signator|suspendedBy';
			case 'suspensions':
				return 'suspensions|suspensionIssueds';
			case 'users':
				return 'users|createdBy|updatedBy|deletedBy';
			case 'waivers':
				return 'waivers|waiverVerifieds';
			case 'members':
				return 'memberships|members';
			case 'recommendations':
				return 'recommendations';
			default:
				return $tableName;
		}
	}
	
	public static function instance()
	{
		return new AppHelper();
	}
}