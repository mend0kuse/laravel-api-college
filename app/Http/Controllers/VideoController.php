<?php
 
namespace App\Http\Controllers;
 
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;

class VideoController extends Controller
{
    
    public function likeVideo(Request $request, string $id)
   {
        try {
            $video_id = $request->route('videoId');
            $video = Video::find($video_id);
            $video->likes += 1;
            $video->save();
            return Response::json([
                'data' => "succes"
            ], 201); 
        } catch (\Throwable $th) {
            return Response::json([
                'data' => "error"
            ], 400);
        }
    }

    public function dislikeVideo(Request $request, string $id)
    {
         try {
             $video_id = $request->route('videoId');
             $video = Video::find($video_id);
             $video->dislikes += 1;
             $video->save();
             return Response::json([
                 'data' => "succes"
             ], 201); 
         } catch (\Throwable $th) {
             return Response::json([
                 'data' => "error"
             ], 400);
         }
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