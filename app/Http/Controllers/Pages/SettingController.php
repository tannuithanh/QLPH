<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\MeetingRoom;
use App\Models\Role;
use App\Models\RoleUser;
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
            'department_id' => 'required|exists:departments,id',
            'is_admin' => 'nullable|boolean',
            'phone' => 'nullable|string|max:20'
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
            'phone_number' => $validated['phone'] ?? null,
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
            'phone' => 'nullable|string|max:20',
            'department_id' => 'required|exists:departments,id',
            'is_admin' => 'nullable|boolean'
        ]);

        $user = User::find($validated['id']);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone_number' => $validated['phone'] ?? null,
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

// PHÂN QUYỀN
    public function showRoleManager()
    {
        $roles = Role::withCount('users')->get(); // Nếu muốn đếm số user, dùng withCount
        $users = User::all();
        $roleUsers = RoleUser::with(['user', 'role'])->get();
        return view('pages.setting.roleManager', compact('roles', 'users', 'roleUsers'));
    }

    public function addAllRoleManager(Request $request)
    {
        $request->validate([
            'role' => 'required|string|exists:roles,name'
        ]);

        $role = Role::where('name', $request->role)->firstOrFail();
        $allUsers = User::all();

        $addedCount = 0;
        $newlyAddedUsers = [];

        foreach ($allUsers as $user) {
            // ❗ Kiểm tra nếu user đã có bất kỳ role nào → bỏ qua
            $alreadyHas = RoleUser::where('user_id', $user->id)->exists();

            if (!$alreadyHas) {
                $pivot = RoleUser::create([
                    'user_id' => $user->id,
                    'role_id' => $role->id,
                ]);

                $addedCount++;

                $newlyAddedUsers[] = [
                    'name' => $user->name,
                    'role' => $role->display_name,
                    'pivot_id' => $pivot->user_id,
                ];
            }
        }

        if ($addedCount === 0) {
            return response()->json([
                'success' => false,
                'message' => "Tất cả người dùng đã có quyền. Mỗi người chỉ được có 1 quyền duy nhất."
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => "Đã gán quyền '{$role->display_name}' cho {$addedCount} người dùng.",
            'users' => $newlyAddedUsers
        ]);
    }

    public function deleteRoleManager(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id'
        ]);

        $deleted = RoleUser::where('user_id', $request->user_id)->delete();

        if ($deleted) {
            return response()->json([
                'success' => true,
                'message' => 'Đã xoá phân quyền của người dùng.'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Người dùng này không có phân quyền để xoá.'
        ]);
    }

    public function addRoleManagerSingle(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role_id' => 'required|exists:roles,id'
        ]);

        $user = User::findOrFail($request->user_id);
        $role = Role::findOrFail($request->role_id);

        // ❗ Kiểm tra nếu user đã có bất kỳ role nào
        $alreadyHas = RoleUser::where('user_id', $user->id)->exists();

        if ($alreadyHas) {
            return response()->json([
                'success' => false,
                'message' => "Người dùng '{$user->name}' đã có phân quyền, không thể gán thêm."
            ]);
        }

        $pivot = RoleUser::create([
            'user_id' => $user->id,
            'role_id' => $role->id,
        ]);

        return response()->json([
            'success' => true,
            'message' => "Đã gán quyền '{$role->display_name}' cho người dùng '{$user->name}'.",
            'user' => [
                'name' => $user->name,
                'role' => $role->display_name,
                'pivot_id' => $pivot->user_id
            ]
        ]);
    }
}
