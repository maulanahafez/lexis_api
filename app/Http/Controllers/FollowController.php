<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use App\Http\Requests\StoreFollowRequest;
use App\Http\Requests\UpdateFollowRequest;

class FollowController extends Controller
{
    public function follow($id, StoreFollowRequest $request)
    {
        $follower_id = $request->follower_id;
        $data = Follow::select('id')->where([
            ['follower_id', '=', $follower_id],
            ['user_id', '=', $id]
        ])->first();
        if ($data) {
            $data->delete();
            return response()->json(['follow' => false]);
        } else {
            $data = Follow::create([
                'user_id' => $id,
                'follower_id' => $follower_id,
            ]);
            return response()->json(['follow' => true]);
        }
    }
}
