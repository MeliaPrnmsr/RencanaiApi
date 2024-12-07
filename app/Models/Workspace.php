<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Workspace extends Model
{
    protected $table = 'workspaces';
    protected $primaryKey = 'id_projek';
    protected $guarded = ['id_projek'];

    protected $fillable = [
        'nama_projek',
        'deskripsi',
        'status',
        'creator'
    ];
    


    public function creator()
    {
        return $this->belongsTo(User::class, 'creator', 'id_user');
    }

    public function task()
    {
        return $this->hasMany(WSTask::class, 'ws_id', 'id_projek');
    }

    public function announcement()
    {
        return $this->hasMany(Announcement::class, 'ws_id', 'id_projek');
    }

    public function invitation()
    {
        return $this->hasMany(Invite::class, 'ws_id', 'id_projek');
    }

    public function member()
    {
        return $this->belongsToMany(User::class, 'workspace_members', 'ws_id', 'member_id');
    }  
}
