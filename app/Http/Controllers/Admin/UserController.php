<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        return view('admin.user-registration.index');
    }

    public function create()
    {
        $branches = Branch::where('is_active', 1)->get();
        return view('admin.user-registration.create', compact('branches'));
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'branch_id' => 'required|exists:branches,id',
            'user_type' => 'required|integer',
            'phone_no' => 'required|numeric|unique:users',
            'address' => 'nullable|string',
            'dob' => 'nullable|date',
            'sex' => 'nullable|in:male,female,other',
            'blood_group' => 'nullable|string',
            'emergency_contact' => 'nullable|numeric',
            'date_of_joining' => 'required|date',
            'date_of_leaving' => 'nullable|date',
            'is_active' => 'required|integer'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'branch_id' => $request->branch_id,
            'user_type' => $request->user_type,
            'phone_no' => $request->phone_no,
            'address' => $request->address,
            'dob' => $request->dob,
            'sex' => $request->sex,
            'blood_group' => $request->blood_group,
            'emergency_contact' => $request->emergency_contact,
            'date_of_joining' => $request->date_of_joining,
            'date_of_leaving' => $request->date_of_leaving,
            'is_active' => $request->is_active,
            'created_by' => Auth::id(),
        ]);

      if($user){
        return response()->json([
            'status' => 1,
            'message' => 'User Created Successfully',
            'redirect' => route('users.create')
        ]);
      }
    }

    public function edit($id)
    {
        return view('admin.user-registration.edit', compact('id'));
    }

    public function update(Request $request, $id) {}
}
