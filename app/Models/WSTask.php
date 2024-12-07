<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WSTask extends Model
{
    protected $table = 'ws_tasks';
    protected $primaryKey = 'id_task';
    protected $guarded = ['id_task'];

    public function workspace()
    {
        return $this->belongsTo(Workspace::class, 'ws_id', 'id_projek');
    }

    public function member()
    {
        return $this->belongsTo(User::class, 'member_id', 'id_user');
    }
}
