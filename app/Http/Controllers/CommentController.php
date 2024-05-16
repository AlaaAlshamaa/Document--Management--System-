<?php

namespace App\Http\Controllers;

use App\Http\Requests\Comment\CommentRequest;
use App\Models\Comment;
use App\Http\Resources\CommentResource;
use App\Http\Traits\ApiResponseTrait;
use App\Models\Category;
use App\Models\Document;

class CommentController extends Controller
{
    use ApiResponseTrait;

    public function index()
    {
        $comments = Comment::all();
        $data = CommentResource::collection($comments);
        return $this->customeResponse($data, 'Done!', 200);
    }

    /**
     * Store a new comment for a category.
     */
    public function categoryStore(CommentRequest $request, Category $category)
    {
        $comment = $category->comments()->create([
            'description' => $request->description
        ]);

        $data = new CommentResource($comment);
        return $this->customeResponse($data, 'Created Successfully', 201);
    }


    /**
     * Store a new comment for a document.
      */
    public function documentStore(CommentRequest $request, Document $document)
    {
        $comment = $document->comments()->create([
            'description' => $request->description
        ]);

        $data = new CommentResource($comment);
        return $this->customeResponse($data, 'Created Successfully', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        $data = new CommentResource($comment);
        return $this->customeResponse($data, 'Done!', 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CommentRequest $request, Comment $comment)
    {
        $comment->description = $request->description;
        $comment->save();

        $data = new CommentResource($comment);
        return $this->customeResponse($data, 'Successfully Updated', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();
        return response()->json(['message' => 'Deleted'], 200);
    }
}
