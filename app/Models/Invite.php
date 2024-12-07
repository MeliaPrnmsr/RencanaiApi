<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invite extends Model
{
    protected $table = 'invites';
    protected $primaryKey = 'id_invitation';
    protected $guarded = ['id_invitation'];
    public $timestamps = false;

    public function projek()
    {
        return $this->belongsTo(Workspace::class, 'ws_id', 'id_projek');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id_user');
    }
}
