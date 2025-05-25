<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class MeetingRoom extends Model
{
    use HasFactory;

    protected $table = 'meeting_rooms';

    protected $fillable = [
        'name',
        'created_by',
    ];

    /**
     * Người tạo phòng họp
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
