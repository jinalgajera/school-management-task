<?php

namespace App\Http\Controllers;

use App\Models\TeacherDetail;
use App\Models\User;
use Illuminate\Http\Request;
use DataTables;
use Illuminate\Support\Facades\Storage;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin/teacher/index');
    }

    /**show listing of data */
    public function data()
    {
        $teachers = TeacherDetail::with('user'); // Assuming relation: teacher belongsTo user

        return DataTables::of($teachers)
            ->addIndexColumn()
            ->addColumn('name', fn($row) => $row->user->name)
            ->addColumn('email', fn($row) => $row->user->email)
            ->addColumn('gender', fn($row) => ucfirst($row->gender))
            ->addColumn('status', fn($row) => $row->status ? 'Active' : 'Inactive')
            ->addColumn('action', function($row) {
                return '<a href="'.route('teachers.edit', $row->id).'" class="btn btn-sm btn-warning">Edit</a> <button class="btn btn-sm btn-danger" onclick="deleteTeacher('.$row->id.')">Delete</button>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin/teacher/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Manually check for existing email
        $existingUser = User::where('email', $request->email)->first();
        if ($existingUser) {
            return back()->withErrors(['email' => 'The email has already been taken.'])->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => 'teacher',
            'password' => bcrypt('12345678'), // or a random one
        ]);

        $filename='';
        if ($request->hasFile('profile_photo')) {
            $file = $request->file('profile_photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('storage/profile_photos'), $filename);
            $validated['profile_photo'] = 'profile_photos/' . $filename;
        }

        TeacherDetail::create([
            'user_id' => $user->id,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'address' => $request->address,
            'qualification' => $request->qualification,
            'experience' => $request->experience,
            'joining_date' => $request->joining_date,
            'profile_photo' => $filename,
            'status' => $request->status,
        ]);

        return redirect()->route('teachers.index')->with('success', 'Teacher added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(TeacherDetail $teacher)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TeacherDetail $teacher)
    {
        $teacher = TeacherDetail::with('user')->findOrFail($teacher->id);
        return view('admin.teacher.edit', compact('teacher'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, TeacherDetail $teacher)
    {
        $teacher = TeacherDetail::findOrFail($teacher->id);
        $user = $teacher->user;

        // Check if email is being changed
        if ($request->email !== $user->email) {
            // Manually check for unique email
            $existingUser = User::where('email', $request->email)->first();
            if ($existingUser) {
                return back()->withErrors(['email' => 'The email has already been taken.'])->withInput();
            }
        }

        // Update user (name and email)
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        // Prepare data for teacher update
        $data = $request->except('name', 'email');

        // Handle profile photo upload
        if ($request->hasFile('profile_photo')) {
            // Delete old photo if exists
            $photoPath = 'profile_photos/' . $teacher->profile_photo;
            if ($teacher->profile_photo && Storage::disk('public')->exists($photoPath)) {
                Storage::disk('public')->delete($photoPath);
            }

            $file = $request->file('profile_photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('storage/profile_photos'), $filename);
            $validated['profile_photo'] = 'profile_photos/' . $filename;
            $data['profile_photo'] = $filename;
        }

        // Update teacher data
        $teacher->update($data);

        return redirect()->route('teachers.index')->with('success', 'Teacher updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $teacher = TeacherDetail::findOrFail($id);

        // Delete profile photo if exists
        $photoPath = 'profile_photos/' . $teacher->profile_photo;
        if ($teacher->profile_photo && Storage::disk('public')->exists($photoPath)) {
            Storage::disk('public')->delete($photoPath);
        }

        // Delete the related user
        if ($teacher->user) {
            $teacher->user->delete();
        }

        // Delete the teacher
        $teacher->delete();

        return response()->json(['message' => 'Teacher deleted successfully.']);
    }
}
