<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Http\Requests\StoreChapterRequest;
use App\Http\Requests\UpdateChapterRequest;
use App\Models\Comment;
use App\Models\Like;

class ChapterController extends Controller
{
    /*
     * Readers
     */
    public function index($id)
    {
        $data = Chapter::where(['story_id' => $id, 'is_published' => true])->orderBy('order_num', 'asc')->get();
        return response()->json($data);
    }

    public function show($id)
    {
        $data = Chapter::where(['id' => $id, 'is_published' => true])->first();
        if ($data) {
            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        }
        return response()->json([
            'success' => false,
            'message' => 'Not Found'
        ], 404);
    }

    /*
     * Authors
     */
    public function store(StoreChapterRequest $request)
    {
        try {
            $data = Chapter::create($request->all());
            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function update(UpdateChapterRequest $request, $id)
    {
        $data = Chapter::where('id', $id)->first();
        if ($data) {
            try {
                $data->update($request->all());
                return response()->json([
                    'success' => true,
                    'data' => $data
                ]);
            } catch (\Throwable $th) {
                return response()->json([
                    'success' => false,
                    'message' => $th->getMessage(),
                ], 500);
            }
        }
        return response()->json([
            'success' => false,
            'message' => 'Not Found'
        ], 404);
    }

    public function destroy($id)
    {
        $data = Chapter::where('id', $id)->first();
        if ($data) {
            try {
                $data->delete();
                return response()->json([
                    'success' => true,
                ]);
            } catch (\Throwable $th) {
                return response()->json([
                    'success' => false,
                    'message' => $th->getMessage(),
                ], 500);
            }
        }
        return response()->json([
            'success' => false,
            'message' => 'Not Found'
        ], 404);
    }

    /**
     * Comments
     */
    public function getComments($id)
    {
        $data = Comment::with('user:id,name')->where('chapter_id', $id)->orderBy('created_at', 'desc')->get();
        return response()->json($data);
    }

    /**
     * Likes
     */
    public function getLikes($id)
    {
        $data = Like::where('chapter_id', $id)->count();
        return response()->json($data);
    }
}
