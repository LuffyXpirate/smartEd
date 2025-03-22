<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Request;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'user_type',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    static public function getSingle($id)
    {
        return self::where('id', $id)->first();
    }
    
    static public function getAdmin()
    {
        $admins = self::select('users.*')
                      ->where('user_type', 1)
                      ->where('is_delete', 0)
                      ->orderBy('id', 'desc')
                      ->get();

        if (!empty(Request::get('email'))) {
            $admins = $admins->filter(function ($admin) {
                return strpos(strtolower($admin->email), strtolower(Request::get('email'))) !== false;
            });
        }

        if (!empty(Request::get('name'))) {
            $admins = $admins->filter(function ($admin) {
                return strpos(strtolower($admin->name), strtolower(Request::get('name'))) !== false;
            });
        }

        $perPage = 2;
        return new \Illuminate\Pagination\LengthAwarePaginator(
            $admins->forPage(Request::get('page', 1), $perPage),
            $admins->count(),
            $perPage,
            Request::get('page', 1),
            ['path' => Request::url(), 'query' => Request::query()]
        );
    }

    public function student()
    {
        return $this->hasOne(StudentModel::class);
    }

    // Relationships
    public function students()
    {
        return $this->hasMany(StudentModel::class, 'user_id');
    }

    public function subjects()
    {
        return $this->hasMany(Subject::class, 'assigned_to'); // Teacher is assigned subjects
    }
}
