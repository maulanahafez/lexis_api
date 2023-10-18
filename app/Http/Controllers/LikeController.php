<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Http\Requests\StoreLikeRequest;
use App\Http\Requests\UpdateLikeRequest;

class LikeController extends Controller
{
    public function store(StoreLikeRequest $request)
    {
        $like = Like::where(['user_id' => $request->user_id, 'chapter_id' => $request->chapter_id])->first();
        if ($like) {
            return response()->json([
                'success' => false,
                'message' => 'User has already liked this chapter'
            ], 409);
        }
        try {
            $data = Like::create($request->all());
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

    public function destroy($id)
    {
        $data = Like::where('id', $id)->first();
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

    public function index()
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function update(UpdateLikeRequest $request, $id)
    {
        //
    }
}
