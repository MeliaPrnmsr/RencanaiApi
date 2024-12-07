<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonalTask extends Model
{
    protected $table = 'personal_tasks';
    protected $primaryKey = 'id_personal_task';
    protected $guarded = ['id_personal_task'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id_user');
    }
}
