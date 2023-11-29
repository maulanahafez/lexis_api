<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\Follow;
use App\Models\Like;
use App\Models\Story;
use App\Models\User;
use Arr;
use Illuminate\Http\Request;

use function PHPSTORM_META\map;

class UserController extends Controller
{
    /**
     * Profile
     */
    public function index(Request $req)
    {
        try {
            $user = User::updateOrCreate([
                'uid' => $req->uid,
                'email' => $req->email,
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
     * Target User
     */
    public function user($id, Request $req)
    {
        $user = User::select([
            'id', 'uid', 'username', 'email', 'name', 'bio', 'photoUrl',
        ])->find($id);

        // Stories
        $stories = Story::select([
            'id', 'user_id', 'title', 'is_published', 'cover_path', 'created_at'
        ])->orderBy('created_at', 'desc')->where('user_id', '=', $id)->get();

        // Stats
        $follow = User::select([
            'id', 'uid', 'username', 'email', 'name', 'bio', 'photoUrl',
        ])->with(['followers:id', 'following:id'])->find($id);
        $stories_id = Story::select(['id', 'user_id'])->where('user_id', '=', $id)->get()->toArray();
        $stories_id = Arr::pluck($stories, 'id');
        $chapters = Chapter::select(['id', 'story_id'])->with('likes')->whereIn('id', $stories_id)->get()->toArray();
        $likes = Arr::collapse(
            Arr::map($chapters, function ($chapter) {
                return Arr::pluck($chapter['likes'], 'id');
            })
        );

        // Follows Target
        $isFollowsTarget = Follow::select('id')->where([
            ['follower_id', '=', $req->from],
            ['user_id', '=', $id]
        ])->first();

        return response()->json([
            'targetUser' => $user,
            'targetStories' => $stories,
            'targetStats' => [
                'followers' => $follow->followers->count(),
                'following' => $follow->following->count(),
                'likes' => count($likes),
            ],
            'isFollowsTarget' => $isFollowsTarget->id ?? false ? true : false,
        ]);
    }

    /**
     * Stats
     */
    public function stats($id, Request $req)
    {
        $user = User::select(['id'])->with(['followers:id', 'following:id'])->find($id);
        $stories = Story::select(['id', 'user_id'])->where('user_id', '=', $id)->get()->toArray();
        $stories_id = Arr::pluck($stories, 'id');
        $chapters = Chapter::select(['id', 'story_id'])->with('likes')->whereIn('id', $stories_id)->get()->toArray();
        $likes = Arr::collapse(
            Arr::map($chapters, function ($chapter) {
                return Arr::pluck($chapter['likes'], 'id');
            })
        );
        return response()->json([
            'followers' => $user->followers->count(),
            'following' => $user->following->count(),
            'likes' => count($likes),
        ]);
    }

    public function followers($id)
    {
        $user = User::select(['id'])->with(['followers:id,username,name'])->find($id);
        return response()->json(
            $user->followers
        );
    }

    public function following($id)
    {
        $user = User::select(['id'])->with(['following:id,username,name'])->find($id);
        return response()->json(
            $user->following
        );
    }

    /**
     * User Stories
     */
    public function getUserStories($id)
    {
        $data = Story::with(['chapters:id,story_id', 'chapters.likes'])->orderBy('created_at', 'desc')->where('user_id', $id)->latest()->get();
        foreach ($data as $story) {
            $count = $story->chapters->count();
            $story['chapters_count'] = $count;
            $likes = 0;
            foreach ($story->chapters as $chapter) {
                $likes += $chapter->likes->count();
            }
            $story['likes'] = $likes;
            unset($story['chapters']);
        }
        return response()->json($data);
    }

    /**
     * User Likes
     */
    public function getChapterLikes($id)
    {
        $data = Like::with(['chapter:id,title,story_id', 'chapter.story:id,title,cover_path'])->orderBy('created_at', 'desc')->where('user_id', '=', $id)->get();
        return response()->json($data);
    }
}
