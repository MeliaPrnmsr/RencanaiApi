<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $primaryKey = 'id_user';
    protected $keyType = 'int';
    public $incrementing = true;
     protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function invites()
    {
        return $this->hasMany(Invite::class, 'user_id', 'id_user');
    }

    public function announcement()
    {
        return $this->hasMany(Announcement::class, 'created_by', 'id_user');
    }
    
    public function projek()
    {
        return $this->hasMany(Workspace::class, 'creator', 'id_user');
    }

    public function task()
    {
        return $this->hasMany(WSTask::class, 'member_id', 'id_user');
    }

    public function member()
    {
        return $this->belongsToMany(Workspace::class, 'workspace_members', 'member_id', 'ws_id');
    }

    public function personal_task()
    {
        return $this->hasMany(PersonalTask::class, 'user_id', 'id_user');
    }
}
