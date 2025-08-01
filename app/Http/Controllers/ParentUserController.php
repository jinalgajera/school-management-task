<?php

namespace App\Http\Controllers;

use App\Models\ParentUser;
use App\Models\Student;
use Illuminate\Http\Request;
use Auth;

class ParentUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('teacher.parentuser.index');
    }

    /**show listing of data */
    public function data()
    {
        $parentUser = ParentUser::with('student'); // eager load teacher name
        $user = Auth::user();

        return datatables()->of($parentUser)
        ->addColumn('student_name', fn($row) => $row->student && $row->student->name ? $row->student->name : 'N/A')
        ->addColumn('name', fn($row) => $row->name)
        ->addColumn('phone', fn($row) => $row->phone)
        ->addColumn('email', fn($row) => $row->email)
        ->addColumn('profession', fn($row) => $row->profession)
        ->addColumn('action', function($row) use ($user) {
            if ($user->role === 'teacher') {
                $editUrl = route('parentUsers.edit', $row->id);
                return '<a href="'.$editUrl.'" class="btn btn-sm btn-warning">Edit</a>
                <button onclick="deleteParentUsers('.$row->id.')" class="btn btn-sm btn-danger">Delete</button>';
            }
            return '-';
        })
        ->rawColumns(['status', 'action']) // allow HTML
        ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $students = Student::where('status', 1)->get();
        return view('teacher.parentuser.create', compact('students'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $data['student_id'] = $request->student_id_;
        ParentUser::create($data);

        return redirect()->route('parentUsers.index')->with('success', 'Parent created successfully.');

    }

    /**
     * Display the specified resource.
     */
    public function show(ParentUser $parentUser)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $students = Student::where('status', 1)->get();
        $parentUser = ParentUser::with('student')->findOrFail($id);

        return view('teacher.parentuser.edit', compact('parentUser', 'students'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $parentUser = ParentUser::findOrFail($id);

        // Update without validation
        $parentUser->update([
            'student_id' => $request->student_id,
            'name'       => $request->name,
            'email'      => $request->email,
            'phone'      => $request->phone,
            'profession' => $request->profession,
        ]);

        return redirect()->route('parentUsers.index')->with('success', 'Parent updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $parentUser = ParentUser::findOrFail($id);
        $parentUser->delete();
        return response()->json(['message' => 'Parent deleted successfully.']);
    }
}
