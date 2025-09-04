<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerContoller extends Controller
{
    public function index()
    {
        return view('admin.customer.index');
    }
    public function create()
    {
        return view('admin.customer.create');
    }
    public function store(Request $request)
    {
        $validate = $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|email|unique:customers,email',
            'mobile_no'   => 'required|string|unique:customers,mobile_no',
            'sex'         => 'nullable|string|max:10',
            'blood_group' => 'nullable|string|max:10',
            'dob'         => 'nullable|date',
            'address'     => 'nullable|string|max:255',
            'is_active'   => 'required',
        ]);

        $customer = Customer::create([
            'name'         => $request->name,
            'email'        => $request->email,
            'mobile_no'    => $request->mobile_no,
            'sex'          => $request->sex,
            'blood_group'  => $request->blood_group,
            'dob'          => $request->dob,
            'address'      => $request->address,
            'is_active'    => $request->is_active,
            'created_by'   => Auth::id(),
        ]);

        if($customer){
            return response()->json([
                'status' => 1,
                'message' => 'Customer created successfully.',
                'redirect' => route('customers.create')
            ]);
        }
    }
}
