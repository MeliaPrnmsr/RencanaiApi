<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class InviteController extends Controller
{
    public function index()
    {
        // Ambil user yang sedang login
        $userId = Auth::user()->id_user;

        // Ambil daftar invites di mana 'user_id' sesuai dengan user yang sedang login
        $invites = Invite::where('user_id', $userId)->get();

        return response()->json([
            'success' => true,
            'message' => 'List of Invites',
            'data' => $invites
        ]);
    }

    public function show($id)
    {
        $invites = Invite::find($id);
        return response()->json([
            'success' => true,
            'message' => 'Detail Data Workspace',
            'data' => $invites
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'status' => ['sometimes', 'string'],
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $invites = Invite::find($id);

        if (!$invites) {
            return response()->json([
                'success' => false,
                'message' => 'Invite tidak ditemukan',
            ], 404);
        }

        $dataToUpdate = array_filter($request->all(), function ($value) {
            return $value !== null;
        });

        $invites->update($dataToUpdate);

        return response()->json([
            'success' => true,
            'message' => 'Status Invite berhasil diubah',
            'data' => $invites->refresh() 
        ]);
    }

}
