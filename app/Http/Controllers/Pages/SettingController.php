<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\MeetingRoom;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class SettingController extends Controller
{
// NGƯỜI DÙNG
    public function showUserManager()
    {
        $users = User::with('department')->get();
        $departments = Department::all();
        return view('pages.setting.usersManager', compact('users', 'departments'));
    }

    public function addUsers(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:20',
            'department_id' => 'required|exists:departments,id',
            'is_admin' => 'nullable|boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        $validated = $validator->validated();

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone_number' => $validated['phone'],
            'department_id' => $validated['department_id'],
            'admin' => $validated['is_admin'] ?? 0,
            'password' => bcrypt('123456')
        ]);

        return response()->json([
            'message' => 'Success',
            'user_id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone_number,
            'department' => $user->department->name ?? 'Chưa có',
            'is_admin' => $user->admin == 1
        ]);
    }

    public function deleteUsers(Request $request)
    {
        // dd($request);
        $request->validate([
            'id' => 'required|exists:users,id',
        ]);

        User::destroy($request->id);

        return response()->json(['message' => 'Đã xoá thành công']);
    }

    public function editUsers(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $request->id,
            'phone' => 'required|string|max:20',
            'department_id' => 'required|exists:departments,id',
            'is_admin' => 'nullable|boolean'
        ]);

        $user = User::find($validated['id']);
        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone_number' => $validated['phone'],
            'department_id' => $validated['department_id'],
            'admin' => $validated['is_admin'] ?? 0
        ]);

        return response()->json([
            'message' => 'Cập nhật thành công',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone_number,
                'department' => $user->department->name ?? 'Chưa có',
                'is_admin' => $user->admin == 1
            ]
        ]);
    }

// PHÒNG BAN
    public function showDepartmentManager()
    {
        $departments = Department::all(); // Lấy toàn bộ phòng ban
        return view('pages.setting.departmentManager', compact('departments'));
    }

    public function addDepartment(Request $request)
    {
        $request->validate([
            'department_name' => 'required|string|max:255'
        ]);

        $department = Department::create([
            'name' => $request->department_name
        ]);

        return response()->json([
            'message' => 'Success',
            'department_name' => $department->name,
            'id' => $department->id
        ]);
    }

    public function deleteDepartment(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:departments,id',
        ]);

        Department::destroy($request->id);

        return response()->json(['message' => 'Xóa thành công']);
    }
// PHÒNG HỌP
    public function showMeetingRoomManager()
    {
        $meetingRooms = MeetingRoom::with('creator')->get(); // eager load user tạo
        return view('Pages.setting.meetingRoomManager', compact('meetingRooms'));
    }

    public function addMeetingRoom(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $room = MeetingRoom::create([
            'name' => $request->name,
            'created_by' => auth()->id()
        ]);

        return response()->json([
            'success' => true,
            'data' => [
                'id' => $room->id,
                'name' => $room->name,
                'creator' => auth()->user()->name,
            ]
        ]);
    }

    public function DelteMeetingRoom(Request $request)
    {
        $room = MeetingRoom::find($request->id);

        if (!$room) {
            return response()->json([
                'success' => false,
                'message' => 'Phòng họp không tồn tại.'
            ]);
        }

        $room->delete();

        return response()->json([
            'success' => true
        ]);
    }


}
