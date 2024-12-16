<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Announcement;

use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Validator;

class AnnouncementController extends Controller
{
    public function index()
    {
        $anno = Announcement::latest()->paginate(5);

        return response()->json([
            'success' => true,
            'message' => 'List of Workspaces',
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

        if($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $anno = Announcement::create([
            'announcement' => $request->announcement,
            'ws_id' => $request->ws_id,
            'created_by' => $request->created_by

        ]);
        return response()->json([
            'success' => true,
            'message' => 'Announcent berhasil ditambahkan',
            'data' => $anno
        ]);
    }

    public function show($id)
    {
        $anno = Announcement::find($id);
        return response()->json([
            'success' => true,
            'message' => 'Detail Data Announcement',
            'data' => $anno
        ]);
    }

    
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'announcement' => ['sometimes', 'string'],
            'ws_id' => ['sometimes', 'integer'],
            'created_by' => ['sometimes', 'integer'],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $anno = Announcement::find($id);

        if (!$anno) {
            return response()->json([~
                'success' => false,
                'message' => 'announcement tidak ditemukan',
            ], 404);
        }

        $dataToUpdate = array_filter($request->all(), function ($value) {
            return $value !== null;
        });

        $anno->update($dataToUpdate);

        return response()->json([
            'success' => true,
            'message' => 'announcement berhasil diubah',
            'data' => $anno->refresh() 
        ]);
    }

    public function destroy($id)
    {
        $anno = Announcement::find($id);

        $anno->delete();

        return response()->json([
            'success' => true,
            'message' => 'Announcement berhasil dihapus',
            'data' => $anno->refresh() 
        ]);
    }

}
