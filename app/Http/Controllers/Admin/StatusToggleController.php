<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StatusToggleController extends Controller
{
    public function toggle(Request $request, $id)
    {
        $modelClass = $request->query('model');

        if (!class_exists($modelClass)) {
            return redirect()->back()->with('error', 'Invalid model.');
        }

        $model = $modelClass::findOrFail($id);
        $model->is_active = !$model->is_active;
        $model->save();

        return redirect()->back()->with('success', 'Status updated successfully.');
    }
}
