<?php

namespace App\Http\Controllers;

use App\Models\Story;
use App\Http\Requests\StoreStoryRequest;
use App\Http\Requests\UpdateStoryRequest;
use Illuminate\Http\Request;
use Storage;

class StoryController extends Controller
{
    public function index()
    {
        $data = Story::where('is_published', true)->latest('updated_at')->get();
        return response()->json($data);
    }

    public function store(StoreStoryRequest $request)
    {
        try {
            if ($request->hasFile('cover')) {
                $cover = $request->file('cover');
                $originalFileName = $cover->getClientOriginalName();
                $file_name = time() . '_' . str_replace(' ', '_', $originalFileName);
                $cover_path = Storage::putFileAs('public/img/story', $cover, $file_name);
            } else {
                $cover_path = null;
            }
            $data = $request->except(['cover']);
            $data['cover_path'] = $cover_path;
            $data = Story::create($data);
            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        } catch (\Throwable $th) {
            Storage::delete($cover_path);
            return response()->json([
                'success' => false,
                'message' => $th->getMessage(),
            ], 500);
        }
    }

    public function show($id)
    {
        $data = Story::with(['chapters:id,story_id,title,order_num,is_published', 'chapters.likes', 'user:id,username'])->where('id', $id)->first();
        $likes = 0;
        foreach ($data->chapters as $chapter) {
            $likes += $chapter->likes->count();
            unset($chapter->likes);
        }
        $data['likes'] = $likes;
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

    // public function update($id, UpdateStoryRequest $request)
    public function update($id, Request $request)
    {
        $data = Story::where('id', $id)->first();
        // $req = json_encode($request->all());
        $datas = [
            'req' => $request->all(),
            'data' => $data
        ];
        // return response()->json($request->all());
        return response()->json($datas);
        if ($data) {
            try {
                $data->update($request->except(['cover']));
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
        $data = Story::where('id', $id)->first();
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
}
