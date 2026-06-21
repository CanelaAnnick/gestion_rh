<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::orderBy('name')->get();
        return view('departments.index', compact('departments'));
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|unique:departments,name']);
        
        Department::create($request->only('name', 'description'));
        return back()->with('success', 'Département ajouté avec succès !');
    }

    public function update(Request $request, $id)
    {
        $request->validate(['name' => 'required|string|unique:departments,name,'.$id]);
        
        $department = Department::findOrFail($id);
        $department->update($request->only('name', 'description'));
        return back()->with('success', 'Département modifié.');
    }

    public function destroy($id)
    {
        Department::findOrFail($id)->delete();
        return back()->with('success', 'Département supprimé.');
    }
}