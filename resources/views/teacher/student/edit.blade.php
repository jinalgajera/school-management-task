@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Student</h2>

    <form id="studentForm" action="{{ route('students.update', $student->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $student->name) }}">
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">Phone</label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone', $student->phone) }}">
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="text" name="email" class="form-control" value="{{ old('email', $student->email) }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Gender</label><br>
            @foreach(['male' => 'Male', 'female' => 'Female', 'other' => 'Other'] as $value => $label)
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender" value="{{ $value }}"
                        {{ old('gender', $student->gender) === $value ? 'checked' : '' }}>
                    <label class="form-check-label">{{ $label }}</label>
                </div>
            @endforeach
        </div>   

        <div class="mb-3">
            <label for="dob" class="form-label">Date of Birth</label>
            <input type="date" name="dob" class="form-control" value="{{ old('dob', $student->dob) }}">
        </div>

        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <textarea name="address" class="form-control">{{ old('address', $student->address) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="class" class="form-label">Class (Standard)</label>
            <input type="text" name="class" class="form-control" value="{{ old('class', $student->class) }}">   
        </div>

        <div class="mb-3">
            <label for="section" class="form-label">Section</label>
            <select name="section" class="form-select">
                @foreach(['A','B','C','D','E'] as $sec)
                    <option value="{{ $sec }}" {{ old('section', $student->section) === $sec ? 'selected' : '' }}>
                        {{ $sec }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="roll_number" class="form-label">Roll Number</label>
            <input type="text" name="roll_number" class="form-control" value="{{ old('roll_number', $student->roll_number) }}">
        </div>

        <div class="mb-3">
            <label for="admission_date" class="form-label">Admission Date</label>
            <input type="date" name="admission_date" class="form-control" value="{{ old('admission_date', $student->admission_date) }}">
        </div>

        <div class="mb-3">
            <label for="profile_photo" class="form-label">Profile Photo</label>
            <input type="file" name="profile_photo" class="form-control">
        </div>
        {{-- Existing photo preview --}}
        @if ($student->profile_photo)
            <div class="mb-3">
                <img src="{{ asset('storage/student_photos/' . $student->profile_photo) }}" alt="Profile" width="100">
            </div>
        @endif

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" class="form-select">
                <option value="1" {{ old('status', $student->status) == 1 ? 'selected' : '' }}>Active</option>
                <option value="0" {{ old('status', $student->status) == 0 ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        $('#studentForm').validate({
            rules: {
                name: { required: true },
                phone: { required: true, digits: true, minlength: 10, maxlength: 15 },
                email: { required: true, email: true },
                dob: { required: true },
                gender: { required: true },
                address: { required: true },
                class: { required: true },
                section: { required: true },
                roll_number: { required: true },
                admission_date: {required: true },
                profile_photo: { extension: "jpg|jpeg|png|gif" },
                status: { required: true }
            },
            messages: {
                name: "Please enter your name",
                phone: {
                    required: "Please enter your phone number",
                    digits: "Phone number should contain only digits",
                    minlength: "Phone number must be at least 10 digits",
                    maxlength: "Phone number must not exceed 15 digits"
                },
                email: {
                    required: "Please enter an email address",
                    email: "Please enter a valid email address (e.g. user@example.com)"
                },
                dob: "Please enter dob",
                gender: "Please select a gender",
                address: "Please enter your address",
                class: "Please enter class",
                section: "Please select section",
                roll_number: "Please enter roll number",
                admission_date: "Please enter admission date",
                profile_photo: "Only image files (jpg, jpeg, png, gif) are allowed",
                status: "Please select status"
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('text-danger');
                if (element.prop('type') === 'radio') {
                    error.insertAfter(element.closest('.form-check-inline').parent());
                } else {
                    error.insertAfter(element);
                }
            }
        });
    });
</script>
@endpush
