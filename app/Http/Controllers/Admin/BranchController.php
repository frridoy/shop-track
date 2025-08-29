<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function index()
    {
        return view('admin.branch.index');
    }

    public function create()
    {
        return view('admin.branch.create');
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'branch_name' => 'required|string|max:255|unique:branches,branch_name',
            'branch_email' => 'required|email|max:255|unique:branches,branch_email',
            'branch_contact' => 'required|max:255|unique:branches,branch_contact',
            'branch_address' => 'required',
        ]);

        $branch = Branch::create([
            'branch_name' => ucwords($request->branch_name),
            'branch_email' => $request->branch_email,
            'branch_contact' => $request->branch_contact,
            'branch_address' => $request->branch_address,
            'is_active' => $request->is_active,
        ]);

        if ($branch) {
            return response()->json([
                'status' => 1,
                'message' => 'Branch Created Successfully',
            ]);
        }
    }
}
