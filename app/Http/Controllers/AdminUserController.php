<?php
namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    public function __construct() { $this->middleware('can:access-admin-panel'); }

    public function index()
    {
        $users = User::latest()->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    public function updateRole(Request $request, User $user)
    {
        $validated = $request->validate(['role' => 'required|in:admin,instructor,student']);
        $user->update($validated);
        return back()->with('success', 'Роль пользователя обновлена!');
    }
}
