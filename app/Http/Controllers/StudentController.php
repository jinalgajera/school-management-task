<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Auth;
use File;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('teacher.student.index');
    }

    /**show listing of data */
    public function data()
    {
        $students = Student::with('teacher'); // eager load teacher name
        $user = Auth::user();

        return datatables()->of($students)
        ->addColumn('teacher_name', function ($row) {
            return $row->teacher && $row->teacher->name ? $row->teacher->name : 'N/A';
        })
        ->addColumn('student_name', fn($row) => $row->name)
        ->addColumn('phone_no', fn($row) => $row->phone)
        ->addColumn('class', fn($row) => $row->class)
        ->addColumn('email', fn($row) => $row->email)
        ->addColumn('roll_number', fn($row) => $row->roll_number)
        ->addColumn('status', function($row) {
            return $row->status
                ? '<span class="badge bg-success">Active</span>'
                : '<span class="badge bg-danger">Inactive</span>';
        })
        ->addColumn('action', function($row) use ($user) {
            if ($user->role === 'teacher') {
                $editUrl = route('students.edit', $row->id);
                return '<a href="'.$editUrl.'" class="btn btn-sm btn-warning">Edit</a>
                    <button onclick="deleteStudent('.$row->id.')" class="btn btn-sm btn-danger">Delete</button>';
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
        return view('teacher.student.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $data['teacher_id'] = Auth::id();

        if ($request->hasFile('profile_photo')) {
            $file = $request->file('profile_photo');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('storage/student_photos'), $filename);
            $data['profile_photo'] = $filename;
        }

        Student::create($data);

        return redirect()->route('students.index')->with('success', 'Student added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Student $student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $student = Student::with('teacher')->findOrFail($id);
        return view('teacher.student.edit', compact('student'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        
        $student = Student::findOrFail($id);
        //dd($student);
        // Handle profile photo upload
        if ($request->hasFile('profile_photo')) {
            // Delete old photo if exists
            $photoPath = 'student_photos/' . $student->profile_photo;
            if ($student->profile_photo && Storage::disk('public')->exists($photoPath)) {
                Storage::disk('public')->delete($photoPath);
            }

            $file = $request->file('profile_photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('storage/student_photos'), $filename);
            $validated['profile_photo'] = 'student_photos/' . $filename;
            $student->profile_photo = $filename;
        }

        //student update       
        $student->name = $request->name;
        $student->phone = $request->phone;
        $student->email = $request->email;
        $student->gender = $request->gender;
        $student->dob = $request->dob;
        $student->address = $request->address;
        $student->class = $request->class;
        $student->section = $request->section;
        $student->roll_number = $request->roll_number;
        $student->admission_date = $request->admission_date;
        $student->status = $request->status;
        $student->save();
        return redirect()->route('students.index')->with('success', 'Student updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $student = Student::findOrFail($id);

        // Delete profile photo if exists
        $photoPath = 'student_photos/' . $student->profile_photo;
        if ($student->profile_photo && Storage::disk('public')->exists($photoPath)) {
            Storage::disk('public')->delete($photoPath);
        }

        $student->delete();
        return response()->json(['message' => 'Student deleted successfully.']);
    }
}
