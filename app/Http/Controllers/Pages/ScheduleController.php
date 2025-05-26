<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\MeetingHistory;
use App\Models\MeetingRoom;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ScheduleController extends Controller
{
    public function showManagerSchedule()
    {
        // Ngày đầu tuần (thứ 2) của tuần hiện tại
        $today = Carbon::today();
        $startOfWeek = $today->startOfWeek(Carbon::MONDAY)->toDateString();

        // Lấy dữ liệu từ ngày đầu tuần trở đi
        $histories = MeetingHistory::with(['meetingRoom', 'decisionMaker'])
            ->where('date', '>=', $startOfWeek)
            ->orderBy('date')
            ->orderBy('start_time')
            ->get();

        return view('Pages.meeting.managerMeetingSchedule', compact('histories'));
    }

    public function showRegisterSchedule(){
        $meetingRooms = MeetingRoom::all();
        $users = User::all();
        return view('Pages.meeting.registerMeetingSchedule', compact('meetingRooms','users'));
    }

    public function handleRegisterSchedule(Request $request)
    {
        $start = Carbon::parse($request->start_datetime);
        $end = Carbon::parse($request->end_datetime);
        $date = $start->toDateString();

        // 1. Kiểm tra phòng họp trùng giờ
        $conflictRoom = MeetingHistory::where('meeting_room_id', $request->meeting_room_id)
            ->where('date', $date)
            ->where(function ($query) use ($start, $end) {
                $query->where(function ($q) use ($start) {
                    $q->where('start_time', '<=', $start->format('H:i:s'))
                    ->where('end_time', '>', $start->format('H:i:s'));
                })->orWhere(function ($q) use ($end) {
                    $q->where('start_time', '<', $end->format('H:i:s'))
                    ->where('end_time', '>=', $end->format('H:i:s'));
                })->orWhere(function ($q) use ($start, $end) {
                    $q->where('start_time', '>=', $start->format('H:i:s'))
                    ->where('end_time', '<=', $end->format('H:i:s'));
                });
            })
            ->first();

        if ($conflictRoom) {
            return response()->json([
                'message' => 'Khung giờ này đã có cuộc họp trong phòng đã chọn. Vui lòng chọn giờ khác.'
            ], 409);
        }

        // 2. Danh sách tất cả người tham gia
        $allUserIds = collect(array_merge(
            json_decode($request->related_people, true) ?? [],
            json_decode($request->specialists, true) ?? [],
            json_decode($request->advisors, true) ?? [],
            json_decode($request->secretaries, true) ?? [],
            [$request->decision_maker]
        ))->unique()->filter();

        // 3. Kiểm tra người trùng lịch
        $conflictUsers = MeetingHistory::where('date', $date)
            ->where(function ($query) use ($start, $end) {
                $query->where(function ($q) use ($start) {
                    $q->where('start_time', '<=', $start->format('H:i:s'))
                    ->where('end_time', '>', $start->format('H:i:s'));
                })->orWhere(function ($q) use ($end) {
                    $q->where('start_time', '<', $end->format('H:i:s'))
                    ->where('end_time', '>=', $end->format('H:i:s'));
                })->orWhere(function ($q) use ($start, $end) {
                    $q->where('start_time', '>=', $start->format('H:i:s'))
                    ->where('end_time', '<=', $end->format('H:i:s'));
                });
            })
            ->get()
            ->filter(function ($meeting) use ($allUserIds) {
                $participants = collect(array_merge(
                    $meeting->related_users ?? [],
                    $meeting->specialist_users ?? [],
                    $meeting->secretary_users ?? [],
                    [$meeting->decision_maker_id]
                ));
                return $participants->intersect($allUserIds)->isNotEmpty();
            });

        if ($conflictUsers->count()) {
            $userIds = $conflictUsers->flatMap(function ($meeting) {
                return array_merge(
                    $meeting->related_users ?? [],
                    $meeting->specialist_users ?? [],
                    $meeting->secretary_users ?? [],
                    [$meeting->decision_maker_id]
                );
            })->intersect($allUserIds)->unique();

            $userNames = User::whereIn('id', $userIds)->pluck('name')->toArray();

            return response()->json([
                'message' => 'Một số người đã có lịch họp trong khung giờ này: ' . implode(', ', $userNames)
            ], 409);
        }

        // 4. Xử lý file
        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $fileName = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('file'), $fileName); // lưu vào public/file
            $attachmentPath = 'file/' . $fileName; // lưu đường dẫn tương đối
        }

        // 5. Lưu lịch họp
        $history = MeetingHistory::create([
            'meeting_room_id'        => $request->meeting_room_id,
            'title'                  => $request->title,
            'date'                   => $date,
            'start_time'             => $start->format('H:i:s'),
            'end_time'               => $end->format('H:i:s'),
            'related_users'          => json_decode($request->related_people, true),
            'specialist_users'       => json_decode($request->specialists, true),
            'secretary_users'        => json_decode($request->secretaries, true),
            'decision_maker_id'      => $request->decision_maker,
            'moderator'              => $request->moderator,
            'note'                   => $request->note,
            'devices'                => $request->devices,
            'result_record_location' => $request->result_record_location,
            'attachment_path'        => $attachmentPath,
            'created_by'             => auth()->id(),
            'advisor_users' => json_decode($request->advisors, true) ?? [],

        ]);

        return response()->json([
            'message' => 'Lịch họp đã được lưu thành công!',
            'data' => $history
        ]);
    }

    public function showEditSchedule($id)
    {
        $meetingRooms = MeetingRoom::all();
        $users = User::all();
        $history = MeetingHistory::findOrFail($id); // ← lấy lịch họp cần sửa
        return view('pages.meeting.editMeetingSchedule', compact('meetingRooms', 'users', 'history'));
    }

    public function handleEditSchedule(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:meeting_histories,id',
        ]);

        $meeting = MeetingHistory::findOrFail($request->id);

        $start = Carbon::parse($request->start_datetime);
        $end = Carbon::parse($request->end_datetime);
        $date = $start->toDateString();

        // 1. Kiểm tra phòng họp trùng giờ (bỏ chính lịch họp hiện tại ra)
        $conflictRoom = MeetingHistory::where('meeting_room_id', $request->meeting_room_id)
            ->where('date', $date)
            ->where('id', '!=', $meeting->id)
            ->where(function ($query) use ($start, $end) {
                $query->where(function ($q) use ($start) {
                    $q->where('start_time', '<=', $start->format('H:i:s'))
                    ->where('end_time', '>', $start->format('H:i:s'));
                })->orWhere(function ($q) use ($end) {
                    $q->where('start_time', '<', $end->format('H:i:s'))
                    ->where('end_time', '>=', $end->format('H:i:s'));
                })->orWhere(function ($q) use ($start, $end) {
                    $q->where('start_time', '>=', $start->format('H:i:s'))
                    ->where('end_time', '<=', $end->format('H:i:s'));
                });
            })
            ->first();

        if ($conflictRoom) {
            return response()->json([
                'message' => 'Khung giờ này đã có cuộc họp trong phòng đã chọn. Vui lòng chọn giờ khác.'
            ], 409);
        }

        // 2. Lấy danh sách tất cả người tham gia
        $allUserIds = collect(array_merge(
            json_decode($request->related_people, true) ?? [],
            json_decode($request->specialists, true) ?? [],
            json_decode($request->advisors, true) ?? [],
            json_decode($request->secretaries, true) ?? [],
            [$request->decision_maker]
        ))->unique()->filter();

        // 3. Kiểm tra người trùng lịch
        $conflictUsers = MeetingHistory::where('date', $date)
            ->where('id', '!=', $meeting->id)
            ->where(function ($query) use ($start, $end) {
                $query->where(function ($q) use ($start) {
                    $q->where('start_time', '<=', $start->format('H:i:s'))
                    ->where('end_time', '>', $start->format('H:i:s'));
                })->orWhere(function ($q) use ($end) {
                    $q->where('start_time', '<', $end->format('H:i:s'))
                    ->where('end_time', '>=', $end->format('H:i:s'));
                })->orWhere(function ($q) use ($start, $end) {
                    $q->where('start_time', '>=', $start->format('H:i:s'))
                    ->where('end_time', '<=', $end->format('H:i:s'));
                });
            })
            ->get()
            ->filter(function ($meetingItem) use ($allUserIds) {
                $participants = collect(array_merge(
                    $meetingItem->related_users ?? [],
                    $meetingItem->specialist_users ?? [],
                    $meetingItem->secretary_users ?? [],
                    $meetingItem->advisor_users ?? [],
                    [$meetingItem->decision_maker_id]
                ));
                return $participants->intersect($allUserIds)->isNotEmpty();
            });

        if ($conflictUsers->count()) {
            $userIds = $conflictUsers->flatMap(function ($meetingItem) {
                return array_merge(
                    $meetingItem->related_users ?? [],
                    $meetingItem->specialist_users ?? [],
                    $meetingItem->secretary_users ?? [],
                    $meetingItem->advisor_users ?? [],
                    [$meetingItem->decision_maker_id]
                );
            })->intersect($allUserIds)->unique();

            $userNames = User::whereIn('id', $userIds)->pluck('name')->toArray();

            return response()->json([
                'message' => 'Một số người đã có lịch họp trong khung giờ này: ' . implode(', ', $userNames)
            ], 409);
        }

        // 4. Xử lý file (nếu có thì thay, không thì giữ cũ)
        $attachmentPath = $meeting->attachment_path;
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $fileName = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('file'), $fileName);
            $attachmentPath = 'file/' . $fileName;
        }

        // 5. Cập nhật lịch họp
        $meeting->update([
            'meeting_room_id'        => $request->meeting_room_id,
            'title'                  => $request->title,
            'date'                   => $date,
            'start_time'             => $start->format('H:i:s'),
            'end_time'               => $end->format('H:i:s'),
            'related_users'          => json_decode($request->related_people, true),
            'specialist_users'       => json_decode($request->specialists, true),
            'advisor_users'          => json_decode($request->advisors, true),
            'secretary_users'        => json_decode($request->secretaries, true),
            'decision_maker_id'      => $request->decision_maker,
            'moderator'              => $request->moderator,
            'note'                   => $request->note,
            'devices'                => $request->devices,
            'result_record_location' => $request->result_record_location,
            'attachment_path'        => $attachmentPath,
        ]);

        return response()->json([
            'message' => 'Cập nhật lịch họp thành công!',
            'data' => $meeting
        ]);
    }

    public function deleteSchedule(Request $request)
    {
        $id = $request->id;

        $meeting = MeetingHistory::find($id);
        if (!$meeting) {
            return response()->json([
                'success' => false,
                'message' => 'Lịch họp không tồn tại.'
            ], 404);
        }

        // Xoá file nếu có
        if ($meeting->attachment_path && file_exists(public_path($meeting->attachment_path))) {
            unlink(public_path($meeting->attachment_path));
        }

        $meeting->delete();

        return response()->json([
            'success' => true,
            'message' => 'Lịch họp đã được xoá thành công!'
        ]);
    }

    public function searchSchedule(Request $request)
    {
        $from = $request->from;
        $to = $request->to;

        // Trường hợp không nhập ngày → reload bằng frontend
        if (!$from && !$to) {
            return response()->json([], 200);
        }

        // Nếu chỉ nhập 1 ngày → tìm đúng ngày đó
        if ($from && !$to) {
            $histories = MeetingHistory::where('date', $from)->get();
        } elseif (!$from && $to) {
            $histories = MeetingHistory::where('date', $to)->get();
        } else {
            // Nếu nhập cả 2 → kiểm tra from <= to
            if (Carbon::parse($from)->gt(Carbon::parse($to))) {
                return response()->json([
                    'message' => 'Ngày bắt đầu không được lớn hơn ngày kết thúc'
                ], 422);
            }

            $histories = MeetingHistory::whereBetween('date', [$from, $to])->get();
        }

        // Trả về JSON format bảng
        $result = $histories->map(function ($item) {
            return [
                'id' => $item->id,
                'meeting_room' => $item->meetingRoom->name ?? '-',
                'date' => Carbon::parse($item->date)->format('d/m/Y'),
                'start_time' => Carbon::parse($item->start_time)->format('H:i'),
                'end_time' => Carbon::parse($item->end_time)->format('H:i'),
                'title' => $item->title,
                'moderator' => $item->moderator,
                'devices' => $item->devices,
                'note' => $item->note,
                'attachment_path' => $item->attachment_path ? asset($item->attachment_path) : null,
                'created_at' => $item->created_at->format('d/m/Y H:i'),
                'creator' => optional(User::find($item->created_by))->name ?? '-',
                'decision_maker' => optional($item->decisionMaker)->name ?? '-',
                'related_users' => User::whereIn('id', $item->related_users ?? [])->pluck('name')->toArray(),
                'specialist_users' => User::whereIn('id', $item->specialist_users ?? [])->pluck('name')->toArray(),
                'advisor_users' => User::whereIn('id', $item->advisor_users ?? [])->pluck('name')->toArray(),
                'secretary_users' => User::whereIn('id', $item->secretary_users ?? [])->pluck('name')->toArray(),
            ];
        });

        return response()->json($result);
    }

}
