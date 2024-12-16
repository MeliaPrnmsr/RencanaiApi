<?php

namespace App\Http\Controllers;

use App\Models\Workspace;
use App\Models\WSTask;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Validator;


class WorkspacesController extends Controller
{
    public function index()
    {
        $workspaces = Workspace::latest()->paginate(5);

        return response()->json([
            'success' => true,
            'message' => 'List of Workspaces',
            'data' => $workspaces
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_projek' => ['required', 'string'],
            'deskripsi' => ['required', 'string'],
            'status' => ['required', 'string'],
            'creator' => ['required', 'integer'],

        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $workspaces = Workspace::create([
            'nama_projek' =>$request->nama_projek,
            'deskripsi' =>$request->deskripsi,
            'status' =>$request->status,
            'creator' => $request->creator,

        ]);
        return response()->json([
            'success' => true,
            'message' => 'Workspace berahasil ditambahkan',
            'data' => $workspaces
        ]);
    }

    public function show($id)
    {
        $workspaces = Workspace::find($id);
        return response()->json([
            'success' => true,
            'message' => 'Detail Data Workspace',
            'data' => $workspaces
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_projek' => ['sometimes', 'string'],
            'deskripsi' => ['sometimes', 'string'],
            'status' => ['sometimes', 'string'],
            'creator' => ['sometimes', 'integer'],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $workspaces = Workspace::find($id);

        if (!$workspaces) {
            return response()->json([
                'success' => false,
                'message' => 'Workspace tidak ditemukan',
            ], 404);
        }

        $dataToUpdate = array_filter($request->all(), function ($value) {
            return $value !== null;
        });

        $workspaces->update($dataToUpdate);

        return response()->json([
            'success' => true,
            'message' => 'Workspace berhasil diubah',
            'data' => $workspaces->refresh() 
        ]);
    }

    public function destroy($id)
    {
        $workspaces = Workspace::find($id);

        $workspaces->delete();

        return response()->json([
            'success' => true,
            'message' => 'Workspace berhasil dihapus',
            'data' => $workspaces->refresh() 
        ]);
    }

    #taskWorkSpace
    public function indexTaskWs()
    {
        $taskws = WSTask::latest()->paginate(5);

        return response()->json([
            'success' => true,
            'message' => 'List of Task Workspaces',
            'data' => $taskws
        ]);
    }

    public function storeTaskWs(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_task' => ['required', 'string'],
            'label' => ['required', 'string'],
            'deskripsi' => ['required', 'string'],
            'due_date' => ['required', 'date_format:Y-m-d'],
            'status' => ['required', 'string'],
            'level_prioritas' => ['required', 'string'],
            'ws_id' => ['required', 'integer'],
            'member_id' => ['required', 'integer'],
        ]);

        if($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $taskws = WSTask::create([
            'nama_task' => $request->nama_task,
            'label' => $request->label,
            'deskripsi' => $request->deskripsi,
            'due_date' => $request->due_date,
            'status' => $request->status,
            'level_prioritas' => $request->level_prioritas,
            'ws_id' => $request->ws_id,
            'member_id' => $request->member_id

        ]);
        return response()->json([
            'success' => true,
            'message' => 'Task Workspace berahasil ditambahkan',
            'data' => $taskws
        ]);
    }

    public function showTaskWs($id)
    {
        $taskws = WSTask::find($id);
        return response()->json([
            'success' => true,
            'message' => 'Detail Data Workspace',
            'data' => $taskws
        ]);
    }
    
    public function updateTaskWs(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_task' => ['sometimes', 'string'],
            'label' => ['sometimes', 'string'],
            'deskripsi' => ['sometimes', 'string'],
            'due_date' => ['sometimes', 'date_format:Y-m-d'],
            'status' => ['sometimes', 'string'],
            'level_prioritas' => ['sometimes', 'string'],
            'ws_id' => ['sometimes', 'integer'],
            'member_id' => ['sometimes', 'integer'],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $taskws = WSTask::find($id);

        if (!$taskws) {
            return response()->json([~
                'success' => false,
                'message' => 'Task Workspace tidak ditemukan',
            ], 404);
        }

        $dataToUpdate = array_filter($request->all(), function ($value) {
            return $value !== null;
        });

        $taskws->update($dataToUpdate);

        return response()->json([
            'success' => true,
            'message' => 'Task Workspace berhasil diubah',
            'data' => $taskws->refresh() 
        ]);
    }

    public function destroyTaskWs($id)
    {
        $taskws = WSTask::find($id);

        $taskws->delete();

        return response()->json([
            'success' => true,
            'message' => 'Task Workspace berhasil dihapus',
            'data' => $taskws->refresh() 
        ]);
    }
    
}
