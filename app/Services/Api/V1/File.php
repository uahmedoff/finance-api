<?php
namespace App\Services\Api\V1;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class File extends Service{

    public static function createFromBase64($fileString,$folder=null) {
		$exploded = explode(',', $fileString);
		if (count($exploded) < 2) 
			return $fileString;
		$decoded = base64_decode($exploded[1]);
		if(str_contains($exploded[0],'jpeg')){
			$extension = 'jpg';
		}
		elseif(str_contains($exploded[0],'png')){
			$extension = 'png';
		}
        elseif(str_contains($exploded[0],'gif')){
			$extension = 'gif';
		}
		
        if($extension != 'jpg' && $extension != 'png' && $extension != 'gif'){
            abort(403,__('validation.file_must_be_image'));
        }

		$fileName = Str::random().'.'.$extension;
        $filePath = ($folder) ? $folder."/".$fileName : $fileName;
		Storage::put('/public/'.$filePath,$decoded);
		return config('app.url').'/storage/'.$filePath;
	}

}