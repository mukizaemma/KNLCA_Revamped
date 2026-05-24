<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UploadEditorImageController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        $request->validate([
            'file' => ['required', 'image', 'max:5120'], // 5MB
        ]);

        $file = $request->file('file');
        $name = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('editor-images', $name, 'public');

        return response()->json([
            'url' => asset('storage/' . $path),
        ]);
    }
}
