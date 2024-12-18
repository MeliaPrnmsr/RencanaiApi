<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;


//memanggil model
use App\Models\User;

class AuthController extends Controller
{
    public function register( Request $request){
        $data = $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'string', 'unique:users'],
            'password' => ['required', 'min:8']
        ]);

        $user = User::create($data);
        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'user' => $user,
            'token' => $token,
        ];
    }

    public function login(Request $request) {
        $data = $request->validate([
            'email' => ['required', 'string', 'exists:users,email'],
            'password' => ['required', 'min:8']
        ]);
    
        $user = User::where('email', $data['email'])->first();
        if (!$user || !Hash::check($data['password'], $user->password)) {
            return response([
                'message' => 'Login Gagal!',
            ], 401);
        }
    
        $token = $user->createToken('auth_token')->plainTextToken;
    
        return [
            'data' => array_merge(
                $user->toArray(), // Semua data user
                ['token' => $token] // Tambahkan token secara manual
            ),
        ];
        
        
    }

    //profile user
    public function userprofile(){
        $userData = auth()->user();
        return response()->json([
            'status' => true,
            'message' => 'Profil User',
            'data' => $userData,
            'id_user' => auth()->user()->id_user
        ], 200);
    }

    //update profile user   
    public function updateprofile(Request $request) {
        // Validasi data input
        $data = $request->validate([
            'name' => ['sometimes', 'string'],
            'email' => ['sometimes', 'string', 'email', 'unique:users,email,' . auth()->user()->id_user],
            'password' => ['sometimes', 'min:8']
        ]);
    
        $user = auth()->user();
    
        // Mengubah password jika ada dalam permintaan
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
    
        // Perbarui data user
        $user->update($data);
    
        return response()->json([
            'status' => true,
            'message' => 'Profil berhasil diperbarui',
            'data' => $user
        ], 200);
    }
    
    
    public function logout(){
        auth()->user()->tokens()->delete();

        DB::table('sessions')->where('user_id', auth()->user()->id_user)->delete();

        return response()->json([
            'status' => true,
            'message' => 'Logout Token',
            'data' => []
        ], 200);
    }
    
}
