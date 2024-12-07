<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkspaceMember extends Model
{
    protected $table = 'workspace_members';
    protected $primaryKey = 'id_member';
    protected $guarded = ['id_member'];
    public $timestamps = false;

    
    public function workspace()
    {
        return $this->belongsTo(Workspace::class, 'ws_id', 'id_projek');
    }

    public function member_id()
    {
        return $this->belongsTo(User::class, 'member_id', 'id_user');
    }
}
