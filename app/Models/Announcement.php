<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $table = 'announcements';
    protected $primaryKey = 'id_announcement';
    protected $guarded = ['id_announcement'];


    public function projek()
    {
        return $this->belongsTo(Workspace::class, 'ws_id', 'id_projek');
    }

    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by', 'id_user');
    }
}
