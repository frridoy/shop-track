<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    public function index()
    {
        $branches = Branch::get();
        return view('admin.branch.index', compact('branches'));
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

        $lastCode = Branch::latest('id')->value('branch_code');
        $number = $lastCode ? (int) substr($lastCode, 1) + 1 : 1;
        $branch_code = 'B' . str_pad($number, 4, '0', STR_PAD_LEFT);

        $branch = Branch::create([
            'branch_name' => ucwords($request->branch_name),
            'branch_email' => $request->branch_email,
            'branch_contact' => $request->branch_contact,
            'branch_address' => $request->branch_address,
            'is_active' => $request->is_active,
            'branch_code' => $branch_code,
        ]);

        if ($branch) {
            return response()->json([
                'status' => 1,
                'message' => 'Branch Created Successfully',
                'redirect' => route('branches.index')
            ]);
        }
    }
}
