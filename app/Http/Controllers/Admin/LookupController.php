<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lookup;
use Illuminate\Http\Request;

class LookupController extends Controller
{
    public function index()
    {
        $lookups = Lookup::select('id', 'lookup_name', 'lookup_type', 'is_active', 'created_by')->whereNull('is_updated')->get();
        return view('admin.lookup.index', compact('lookups'));
    }

    public function create()
    {
        return view('admin.lookup.create');
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'lookup_name' => 'required|string|max:100|unique:lookups,lookup_name',
            'lookup_type' => 'required',
        ]);

        $lookup = Lookup::create([
            'lookup_type' => $request->lookup_type,
            'lookup_name' => $request->lookup_name,
            'is_active' => $request->is_active,
        ]);

        if ($lookup) {
            return response()->json([
                'status' => 1,
                'message' => 'Lookup created successfully',
                'redirect' => route('lookup.index')
            ]);
        }
    }

    public function edit($id)
    {
        $lookup = Lookup::findOrFail($id);
        return view('admin.lookup.edit', compact('lookup'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'lookup_name' => 'required|string|max:100',
            'lookup_type' => 'required',
        ]);

        $lookup = Lookup::findOrFail($id);

        if ($lookup->lookup_name != $request->lookup_name) {

            $lookup->update([
                'is_updated' => 1,
            ]);
            Lookup::create([
                'lookup_type' => $request->lookup_type,
                'lookup_name' => $request->lookup_name,
                'is_active'   => $request->is_active,
            ]);

        } else {
            $lookup->update([
                'lookup_type' => $request->lookup_type,
                'lookup_name' => $request->lookup_name,
                'is_active'   => $request->is_active,
            ]);
        }

        return response()->json([
            'status'   => 1,
            'message'  =>'Lookup updated successfully',
            'redirect' => route('lookup.index'),
        ]);
    }
}
