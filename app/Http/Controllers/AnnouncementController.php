<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Announcement;
use App\Models\Workspace;

use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Validator;

class AnnouncementController extends Controller
{
    public function index($ws_id)
{
    $anno = Announcement::where('ws_id', $ws_id)->latest()->paginate(5);

    return response()->json([
        'success' => true,
        'message' => 'List of Announcements for this workspace',
        'data' => $anno
    ]);
}

public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'announcement' => ['required', 'string'],
        'ws_id' => ['required', 'integer'],
        'created_by' => ['required', 'integer'],
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
        'ws_id' => $request->ws_id,
        'created_by' => $request->created_by
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Announcement berhasil ditambahkan',
        'data' => $anno
    ]);
}

public function show($ws_id, $id)
{
    $anno = Announcement::where('ws_id', $ws_id)->find($id);

    if (!$anno) {
        return response()->json([
            'success' => false,
            'message' => 'Announcement tidak ditemukan',
        ], 404);
    }

    return response()->json([
        'success' => true,
        'message' => 'Detail Data Announcement',
        'data' => $anno
    ]);
}

public function update(Request $request, $ws_id, $id)
{
    $validator = Validator::make($request->all(), [
        'announcement' => ['sometimes', 'string'],
        'ws_id' => ['sometimes', 'integer'],
        'created_by' => ['sometimes', 'integer'],
    ]);

    if ($validator->fails()) {
        return response()->json($validator->errors(), 422);
    }

    $anno = Announcement::where('ws_id', $ws_id)->find($id);

    if (!$anno) {
        return response()->json([
            'success' => false,
            'message' => 'Announcement tidak ditemukan',
        ], 404);
    }

    $dataToUpdate = array_filter($request->all(), function ($value) {
        return $value !== null;
    });

    $anno->update($dataToUpdate);

    return response()->json([
        'success' => true,
        'message' => 'Announcement berhasil diubah',
        'data' => $anno->refresh()
    ]);
}

public function destroy($ws_id, $id)
{
    $anno = Announcement::where('ws_id', $ws_id)->find($id);

    if (!$anno) {
        return response()->json([
            'success' => false,
            'message' => 'Announcement tidak ditemukan',
        ], 404);
    }

    $anno->delete();

    return response()->json([
        'success' => true,
        'message' => 'Announcement berhasil dihapus',
        'data' => $anno
    ]);
}

}
