<?php
 
namespace App\Http\Controllers;
 
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
 
class VideoController extends Controller
{
    public function getVideoUploadForm()
    {
        return view('video-upload');
    }
    
    public function uploadVideo(Request $request)
   {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'video' => 'required|file|mimetypes:video/mp4',
        ]);

        if ($validator->fails()) {
            return $validator->errors();
        }
 
        $fileName = $request->video->getClientOriginalName();
        $filePath = 'videos/' . $fileName;
 
        $isFileUploaded = Storage::disk('public')->put($filePath, file_get_contents($request->video));
 
        // File URL to access the video in frontend
        $url = Storage::disk('public')->url($filePath);
 
        if ($isFileUploaded) {
            $video = new Video();
            $video->title = $request->title;
            $video->path = $filePath;
            $video->user_id = $request->user_id;
            $video->save();
 
            return 'Video has been successfully uploaded.';
        }
 
        return 'Unexpected error occured';
    }
}