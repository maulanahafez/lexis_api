<?php

namespace App\Http\Controllers;

use App\Models\Story;
use App\Http\Requests\StoreStoryRequest;
use App\Http\Requests\UpdateStoryRequest;

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
            $data = Story::create($request->all());
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

    public function show($id)
    {
        $data = Story::where('id', $id)->first();
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

    public function update(UpdateStoryRequest $request, $id)
    {
        $data = Story::where('id', $id)->first();
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
