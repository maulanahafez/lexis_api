<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Http\Requests\StoreLikeRequest;
use App\Http\Requests\UpdateLikeRequest;

class LikeController extends Controller
{
    public function like($id, StoreLikeRequest $request)
    {
        $user_id = $request->user_id;
        $data = Like::select('id')->where([
            ['chapter_id', '=', $id],
            ['user_id', '=', $user_id]
        ])->first();
        if ($data) {
            $data->delete();
            return response()->json(['like' => false]);
        } else {
            $data = Like::create([
                'chapter_id' => $id,
                'user_id' => $user_id,
            ]);
            return response()->json(['like' => true]);
        }
    }
}
