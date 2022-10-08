<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;
use Validator;

class TodoController extends Controller
{
    public function index()
    {
        $todos = Todo::latest()->paginate(5);

        return response()->json([
            'message' => 'Daftar todo!',
            'data' => $todos
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $todo = Todo::create(array_merge(
            ['user_id' => auth()->user()->id],
            $validator->validated()
        ));

        return response()->json([
            'message' => 'Berhasil ditambahkan!',
            'data' => $todo
        ], 200);
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $todo = Todo::findOrFail($request->id);

        $todo = Todo::create(array_merge(
            ['user_id' => auth()->user()->id],
            $validator->validated()
        ));

        return response()->json([
            'message' => 'Berhasil diperbarui!',
            'data' => $todo
        ], 200);
    }

    public function delete(Request $request)
    {
        Todo::findOrFail($request->id)->delete();

        return response()->json([
            'message' => 'Berhasil dihapus!',
            'data' => null
        ], 200);
    }
}
