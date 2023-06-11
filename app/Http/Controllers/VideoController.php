<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;

class VideoController extends Controller
{
    public function getVideosByUserId(Request $request)
    {
        try {
            $user_id = $request->route('userId');

            $videos = Video::with('comments', 'user')->where('user_id', $user_id)->get();

            return Response::json([
                'data' => $videos
            ], 201);

        } catch (\Throwable $th) {
            report($th);
            return Response::json([
                'data' => "error"
            ], 400);

        }
    }

    public function getVideos(Request $request)
    {
        try {
            $videos = Video::with('comments', 'user')->get();

            return Response::json([
                'data' => $videos
            ], 201);

        } catch (\Throwable $th) {
            report($th);
            return Response::json([
                'data' => "error"
            ], 400);

        }
    }

    public function likeVideo(Request $request)
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

    public function dislikeVideo(Request $request)
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
            return Response::json([
                'data' => $validator->errors()
            ], 400);
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
            
            return Response::json([
                'data' => 'Video has been successfully uploaded.'
            ], 200);
        }

        return Response::json([
            'data' => 'Unexpected error occured'
        ], 400);
    }

}