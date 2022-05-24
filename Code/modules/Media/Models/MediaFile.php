<?php
namespace Modules\Media\Models;

use App\BaseModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Modules\Media\Admin\MediaController;

class MediaFile extends BaseModel
{
    use SoftDeletes;
    protected $table = 'media_files';

    public static function findMediaByName($name)
    {
        return MediaFile::where("file_name", $name)->firstOrFail();
    }

    public function cacheKey()
    {
        return sprintf("%s/%s", $this->getTable(), $this->getKey());
    }

    public static function saveUploadFile($file,$group = 'image'){

        if (empty($file)) {
            return false;
        }

        MediaController::validateFile($file,$group);


        $folder = '';
        $id = Auth::id();
        if ($id) {
            $folder .= sprintf('%04d', (int)$id / 1000) . '/' . $id . '/';
        }
        $folder = $folder . date('Y/m/d');
        $newFileName = md5($file->getClientOriginalName().uniqid());
        $fileNameOnly =  Str::slug(substr($file->getClientOriginalName(), 0, strrpos($file->getClientOriginalName(), '.')));
        $i = 0;
        do {
            $newFileName2 = $newFileName . ($i ? $i : '');
            $testPath = $folder . '/' . $newFileName2 . '.' . $file->getClientOriginalExtension();
            $i++;
        } while (Storage::disk('uploads')->exists($testPath));

        $check = $file->storeAs( $folder, $newFileName2 . '.' . $file->getClientOriginalExtension(),'uploads');

        if ($check) {
            try {
                $fileObj = new self();
                $fileObj->file_name = $fileNameOnly;
                $fileObj->file_path = $check;
                $fileObj->file_size = $file->getSize();
                $fileObj->file_type = $file->getMimeType();
                $fileObj->file_extension = $file->getClientOriginalExtension();
                $fileObj->save();
                return $fileObj->id;
            } catch (\Exception $exception) {
                Storage::disk('uploads')->delete($check);
                return false;
            }
        }
        return false;
    }

    public function getThumbIcon(){
        if(preg_match("/image/i", $this->file_type)){
            return get_file_url($this->id);
        }else{
            return asset('images/file_icon.png');
        }
    }
}
