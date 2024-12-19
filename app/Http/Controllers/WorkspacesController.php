<?php

namespace App\Http\Controllers;

use App\Models\Workspace;
use App\Models\WSTask;
use App\Models\Invite;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Storage;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;


class WorkspacesController extends Controller
{
    public function index()
    {
        // Ambil user yang sedang login
        $userId = Auth::user()->id_user;
    
        // Ambil daftar workspaces yang di-create oleh user atau yang user menjadi member-nya
        $workspaces = Workspace::where('creator', $userId)
                               ->orWhereHas('members', function ($query) use ($userId) {
                                   $query->where('member_id', $userId);
                               })
                               ->get();
    
        return response()->json([
            'success' => true,
            'message' => 'List of Workspaces',
            'data' => $workspaces
        ]);
    }
    

    public function store(Request $request)
    {
        $userId = Auth::user()->id_user;

        
         $validator = Validator::make($request->all(), [
            'nama_projek' => ['required', 'string'],
            'deskripsi' => ['required', 'string'],
            'status' => ['required', 'string'],
            'details' => ['required', 'array'], // Validasi bahwa 'details' adalah array
            'details.*.email' => ['required', 'string'], // Validasi setiap elemen 'user_id'
        ]);


        if($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $workspaces = Workspace::create([
            'nama_projek' =>$request->nama_projek,
            'deskripsi' =>$request->deskripsi,
            'status' =>$request->status,
            'creator' => $userId,

        ]);
        $workspaceId = $workspaces->id_projek;

        foreach ($request->details as $detail) {
            // Cari user_id berdasarkan email
            $user = User::where('email', $detail['email'])->first();
    
            // Jika email tidak ditemukan, return error
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => "Email {$detail['email']} tidak ditemukan di sistem.",
                ], 404);
            }
    
            // Masukkan data ke tabel Invite
            Invite::create([
                'status' => 'Pending', 
                'ws_id' => $workspaceId,         
                'user_id' => $user->id_user, 
        ]);
        }

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


    #taskWorkSpace
    public function indexTaskWs($ws_id)
    {
        // Menampilkan tasks hanya untuk workspace tertentu
        $taskws = WSTask::where('ws_id', $ws_id)
        ->orderByRaw("
            CASE 
                WHEN level_prioritas = 'High' THEN 1
                WHEN level_prioritas = 'Medium' THEN 2
                WHEN level_prioritas = 'Low' THEN 3
                ELSE 4 
            END")
        ->orderBy('due_date', 'asc')
        ->get();

        return response()->json([
            'success' => true,
            'message' => 'List of Task Workspaces for this workspace',
            'data' => $taskws
        ]);
    }

    public function storeTaskWs(Request $request, $ws_id)
    {
        $userId = Auth::user()->id_user;

        $validator = Validator::make($request->all(), [
            'nama_task' => ['required', 'string'],
            'deskripsi' => ['required', 'string'],
            'due_date' => ['required', 'date_format:Y-m-d'],
            'status' => ['required', 'string'],
            'level_prioritas' => ['required', 'string'],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Pastikan workspace ID valid
        $workspace = Workspace::find($request->ws_id);
        if (!$workspace) {
            return response()->json([
                'success' => false,
                'message' => 'Workspace tidak ditemukan',
            ], 404);
        }

        $taskws = WSTask::create([
            'nama_task' => $request->nama_task,
            'deskripsi' => $request->deskripsi,
            'due_date' => $request->due_date,
            'status' => $request->status,
            'level_prioritas' => $request->level_prioritas,
            'ws_id' => $ws_id,
            'member_id' => $userId
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Task Workspace berhasil ditambahkan',
            'data' => $taskws
        ]);
    }

    public function showTaskWs($ws_id, $id)
    {
        $taskws = WSTask::where('ws_id', $ws_id)->find($id);

        if (!$taskws) {
            return response()->json([
                'success' => false,
                'message' => 'Task Workspace tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail Data Task Workspace',
            'data' => $taskws
        ]);
    }

    public function updateTaskWs(Request $request, $ws_id, $id)
    {
        $validator = Validator::make($request->all(), [
            'nama_task' => ['sometimes', 'string'],
            'deskripsi' => ['sometimes', 'string'],
            'due_date' => ['sometimes', 'date_format:Y-m-d'],
            'status' => ['sometimes', 'string'],
            'level_prioritas' => ['sometimes', 'string'],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $taskws = WSTask::where('ws_id', $ws_id)->find($id);

        if (!$taskws) {
            return response()->json([
                'success' => false,
                'message' => 'Task Workspace tidak ditemukan',
            ], 404);
        }

        $dataToUpdate = $request->only([
            'nama_task',
            'deskripsi',
            'due_date',
            'status',
            'level_prioritas'
        ]);

        // Debug untuk memastikan data yang dikirim
        if (empty($dataToUpdate)) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada data yang diubah'
            ], 422);
        }

        $taskws->update($dataToUpdate);

        return response()->json([
            'success' => true,
            'message' => 'Task Workspace berhasil diubah',
            'data' => $taskws->refresh()
        ]);
    }

    public function destroyTaskWs($ws_id, $id)
    {
        $taskws = WSTask::where('ws_id', $ws_id)->find($id);

        if (!$taskws) {
            return response()->json([
                'success' => false,
                'message' => 'Task Workspace tidak ditemukan',
            ], 404);
        }

        $taskws->delete();

        return response()->json([
            'success' => true,
            'message' => 'Task Workspace berhasil dihapus',
            'data' => $taskws
        ]);
    }

    
}
