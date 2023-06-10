<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class CommentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function addCommentToVideo(Request $request)
    {
        try {
            $video_id = $request->route('videoId');
            $user_id = $request->user_id;
            $title = $request->title;

            $comment = new Comment();
            $comment->title=$title;
            $comment-> user_id = $user_id;
            $comment-> video_id = $video_id;

            $comment->save();

            return Response::json([
                'data' => $comment
            ], 201); 

        } catch (\Throwable $th) {
            report($th);
            return Response::json([
                'data' => 'error'
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Comment $comment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        //
    }
}
