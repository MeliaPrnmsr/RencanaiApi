<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

//memanggil model
use App\Models\PersonalTask;

class PersonalTaskController extends Controller
{
    public function index()
    {
        $tasks = PersonalTask::where('user_id', Auth::user()->id_user)->get();
        return response()->json([
            'status' => true,
            'message' => 'Daftar Task Saya',
            'data' => $tasks
        ], 200);
    }

    public function tambahTask(Request $request)
    {
        $data = $request->validate([
            'nama_task' => ['required', 'string', 'max:255'],
            'label' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'text'],
            'due_date' => ['required', 'date'],
            'status' => ['required', 'in:Not Started,In Progress,Done'],
            'level_prioritas' => ['required', 'in:Low,Medium,High'],
        ]);

        $task = PersonalTask::create([
            'nama_task' => $data['nama_task'],
            'label' => $data['label'],
            'deskripsi' => $data['deskripsi'],
            'due_date' => $data['due_date'],
            'status' => $data['status'],
            'level_prioritas' => $data['level_prioritas'],
            'user_id' => Auth::user()->id_user,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Task berhasil ditambahkan',
            'data' => $task
        ], 201);
    }

    public function show($id)
    {
        $task = PersonalTask::where('id_personal_task', $id)->where('user_id', Auth::user()->id_user)->first();
        if (!$task) {
            return response()->json([
                'status' => false,
                'message' => 'Task tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Detail Task',
            'data' => $task
        ], 200);
    }

    public function update(Request $request, $id)
    {
        // validasi input
        $data = $request->validate([
            'nama_task' => ['sometimes', 'string', 'max:255'],
            'label' => ['sometimes', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'text'],
            'due_date' => ['sometimes', 'date'],
            'status' => ['sometimes', 'in:Not Started,In Progress,Done'],
            'level_prioritas' => ['sometimes', 'in:Low,Medium,High'],
        ]);

        $task = PersonalTask::where('id_personal_task', $id)->where('user_id', Auth::user()->id_user)->first();

        if (!$task) {
            return response()->json([
                'status' => false,
                'message' => 'Task tidak ditemukan'
            ], 404);
        }

        // ppdate task dengan data baru
        $task->update($data);

        return response()->json([
            'status' => true,
            'message' => 'Task berhasil diperbarui',
            'data' => $task
        ], 200);
    }

    public function destroy($id)
    {
        $task = PersonalTask::where('id_personal_task', $id)->where('user_id', Auth::user()->id_user)->first();

        if (!$task) {
            return response()->json([
                'status' => false,
                'message' => 'Task tidak ditemukan'
            ], 404);
        }

        // Hapus task
        $task->delete();

        return response()->json([
            'status' => true,
            'message' => 'Task berhasil dihapus'
        ], 200);
    }
}
