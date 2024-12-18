<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

//model
use Illuminate\Database\Seeder;
use App\Models\PersonalTask;
use App\Models\User;
use App\Models\Workspace;
use App\Models\WorkspaceMember;
use App\Models\WSTask;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        /* PENAMBAHAN USER PENAMBAHAN USER PENAMBAHAN USER PENAMBAHAN USER */
        User::create([
            'name' => "Yosep", 
            'email' => "yosep@gmail.com",
            'password' => bcrypt('rahasia123')
        ]);

        User::create([
            'name' => "Melia Purnamasari Sihombing", 
            'email' => "melia@gmail.com",
            'password' => bcrypt('12345678')
        ]);

        User::create([
            'name' => "Yohana Septamia", 
            'email' => "yohana@gmail.com",
            'password' => bcrypt('12345678')
        ]);

        User::create([
            'name' => "Yeni Aulia Sinaga", 
            'email' => "yeni@gmail.com",
            'password' => bcrypt('12345678')
        ]);

        User::create([
            'name' => "Clinton Christovel", 
            'email' => "clinton@gmail.com",
            'password' => bcrypt('12345678')
        ]);

        User::create([
            'name' => "Frengky Saputra", 
            'email' => "frengky@gmail.com",
            'password' => bcrypt('12345678')
        ]);

        User::create([
            'name' => "Muhammad Ahsanul", 
            'email' => "ahsanul@gmail.com",
            'password' => bcrypt('12345678')
        ]);


        /* PENAMBAHAN PROJEK PENAMBAHAN PROJEK PENAMBAHAN PROJEK PENAMBAHAN PROJEK */
        Workspace::create([
            'nama_projek' => "Mobile (legend)", 
            'deskripsi' => "membuat sebuah aplikasi android",
            'status' => "In Progress",
            'creator' => "1"
        ]);

        Workspace::create([
            'nama_projek' => "Desain Interaksi", 
            'deskripsi' => "buat prototype sebuah aplikasi gamification",
            'status' => "Not Started",
            'creator' => "3"
        ]);


        /* PENAMBAHAN MEMBER_PROJEK PENAMBAHAN MEMBER_PROJEK PENAMBAHAN MEMBER_PROJEK PENAMBAHAN MEMBER_PROJEK */
        WorkspaceMember::create([
            'ws_id' => 1,
            'member_id' => 4
        ]);

        WorkspaceMember::create([
            'ws_id' => 1,
            'member_id' => 5
        ]);

        WorkspaceMember::create([
            'ws_id' => 2,
            'member_id' => 5
        ]);

        WorkspaceMember::create([
            'ws_id' => 2,
            'member_id' => 1
        ]);

        /* PENAMBAHAN TASK_PROJEK PENAMBAHAN TASK_PROJEK PENAMBAHAN TASK_PROJEK PENAMBAHAN TASK_PROJEK */
        WSTask::create([
            'nama_task' => "Desain figma",
            'deskripsi' => "membuat sebuah aplikasi android",
            'due_date' => "2024-11-28",
            'status' => "In Progress",
            'level_prioritas' => "High",
            'ws_id' => 1,
            'member_id' => 4
        ]);

        /* PENAMBAHAN TASK_PROJEK PENAMBAHAN TASK_PROJEK PENAMBAHAN TASK_PROJEK PENAMBAHAN TASK_PROJEK */
        PersonalTask::create([
            'nama_task' => "Laporan Folklor",
            'deskripsi' => "Membuat Laporan Penelitian",
            'due_date' => "2024-12-3",
            'status' => "In Progress",
            'level_prioritas' => "Medium",
            'user_id' => 1
        ]);
    }
}
