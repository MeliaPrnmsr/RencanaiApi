<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Announcement;
use App\Models\Workspace;

use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AnnouncementController extends Controller
{
    public function index($ws_id)
    {
        $anno = Announcement::where('ws_id', $ws_id)
        ->orderBy('created_at', 'desc')
        ->get();

        return response()->json([
            'success' => true,
            'message' => 'Daftar Announcement',
            'data' => $anno
        ]);
    }

    public function store(Request $request, $ws_id)
    {
        $userId = Auth::user()->id_user;

        $validator = Validator::make($request->all(), [
            'announcement' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $workspace = Workspace::find($request->ws_id);
        if (!$workspace) {
            return response()->json([
                'success' => false,
                'message' => 'Workspace tidak ditemukan',
            ], 404);
        }

        $anno = Announcement::create([
            'announcement' => $request->announcement,
            'ws_id' => $ws_id,
            'created_by' => $userId,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Announcement berhasil ditambahkan',
            'data' => $anno
        ]);
    }

}
