<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\MeetingRoom;
use App\Models\User;

class MeetingHistory extends Model
{
    use HasFactory;

    protected $table = 'meeting_histories';

    protected $fillable = [
        'meeting_room_id',
        'title',
        'date',
        'start_time',
        'end_time',
        'related_users',
        'decision_maker_id',
        'specialist_users',
        'advisor_users', // ← Thêm dòng này
        'note',
        'moderator',
        'secretary_users',
        'attachment_path',
        'result_record_location',
        'created_by'
    ];

    protected $casts = [
        'related_users' => 'array',
        'specialist_users' => 'array',
        'advisor_users' => 'array', // ← Thêm dòng này
        'secretary_users' => 'array',
    ];

    // --- Relationships ---

    /**
     * Phòng họp liên quan
     */
    public function meetingRoom()
    {
        return $this->belongsTo(MeetingRoom::class);
    }

    /**
     * Người quyết định
     */
    public function decisionMaker()
    {
        return $this->belongsTo(User::class, 'decision_maker_id');
    }

    /**
     * Người liên quan (từ danh sách ID)
     */
    public function relatedUsers()
    {
        return User::whereIn('id', $this->related_users ?? [])->get();
    }

    /**
     * Thành phần chuyên môn
     */
    public function specialistUsers()
    {
        return User::whereIn('id', $this->specialist_users ?? [])->get();
    }

    /**
     * Thư ký
     */
    public function secretaryUsers()
    {
        return User::whereIn('id', $this->secretary_users ?? [])->get();
    }

    /**
     * Thành phần tư vấn
     */
    public function advisorUsers()
    {
        return User::whereIn('id', $this->advisor_users ?? [])->get();
    }

}
