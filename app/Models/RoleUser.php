<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleUser extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $table = 'role_user'; // Laravel sẽ mặc định là role_users, nên phải chỉ rõ

    protected $fillable = ['user_id', 'role_id'];
    
    // Nếu muốn, thêm quan hệ:
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    

}
