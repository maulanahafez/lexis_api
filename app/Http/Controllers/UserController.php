<?php

namespace App\Http\Controllers;

use App\Models\Story;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $req)
    {
        try {
            $user = User::updateOrCreate([
                'uid' => $req->uid,
                'email' => $req->email,
                'name' => $req->name,
            ], $req->all());
            return response()->json([
                'success' => true,
                'data' => $user,
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'success' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function is_username_unique(Request $req)
    {
        $data = User::where('username', $req->username)->first();
        return response()->json($data ? false : true);
    }

    /**
     * User Stories
     */
    public function getUserStories($id)
    {
        $data = Story::where('user_id', $id)->latest()->get();
        return response()->json($data);
    }
}
