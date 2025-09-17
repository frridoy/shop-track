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
        $customers = Customer::select('id', 'name', 'email', 'mobile_no', 'sex', 'blood_group', 'dob', 'address', 'is_active')->get();
        return view('admin.customer.index', compact('customers'));
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

        if ($customer) {
            return response()->json([
                'status' => 1,
                'message' => 'Customer created successfully.',
                'redirect' => route('customers.index')
            ]);
        }
    }

    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        return view('admin.customer.edit', compact('customer'));
    }

    public function update(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);

        $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'nullable|email|max:255|unique:customers,email,' . $customer->id,
            'mobile_no'   => 'nullable|string|max:20',
            'sex'         => 'nullable|in:Male,Female,Other',
            'blood_group' => 'nullable|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'dob'         => 'nullable|date',
            'address'     => 'nullable|string|max:500',
            'is_active'   => 'required|boolean',
        ]);

        $customer->update([
            'name'        => $request->input('name'),
            'email'       => $request->input('email'),
            'mobile_no'   => $request->input('mobile_no'),
            'sex'         => $request->input('sex'),
            'blood_group' => $request->input('blood_group'),
            'dob'         => $request->input('dob'),
            'address'     => $request->input('address'),
            'is_active'   => $request->input('is_active'),
        ]);

        return redirect()->route('customers.index')
            ->with('success', 'Customer updated successfully!');
    }
}
