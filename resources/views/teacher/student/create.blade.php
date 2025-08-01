@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Add Student</h2>

    <form id="studentForm" action="{{ route('students.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" class="form-control">
        </div>

        {{-- Phone --}}
        <div class="mb-3">
            <label for="phone" class="form-label">Phone</label>
            <input type="text" name="phone" class="form-control">
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="text" name="email" class="form-control">
        </div>

        {{-- Gender --}}
        <div class="mb-3">
            <label class="form-label">Gender</label><br>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="gender" value="male">
                <label class="form-check-label">Male</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="gender" value="female">
                <label class="form-check-label">Female</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="gender" value="other">
                <label class="form-check-label">Other</label>
            </div>
        </div>   
        
        {{-- dob --}}
        <div class="mb-3">
            <label for="dob" class="form-label">Date of Birth</label>
            <input type="date" name="dob" class="form-control">
        </div>

        {{-- Address --}}
        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <textarea name="address" class="form-control"></textarea>
        </div>

        {{-- class --}}
        <div class="mb-3">
            <label for="class" class="form-label">Class (Standard)</label>
            <input type="text" name="class" class="form-control">   
        </div>

        {{-- section --}}
        <div class="mb-3">
            <label for="section" class="form-label">Section</label>
            <select name="section" class="form-select">
                <option value="A" selected>A</option>
                <option value="B">B</option>
                <option value="C">C</option>
                <option value="D">D</option>
                <option value="E">E</option>
            </select>
        </div>

        {{-- roll number --}}
        <div class="mb-3">
            <label for="roll_number" class="form-label">Roll Number</label>
            <input type="text" name="roll_number" class="form-control">
        </div>

        {{-- admission date --}}
        <div class="mb-3">
            <label for="admission_date" class="form-label">Admission Date</label>
            <input type="date" name="admission_date" class="form-control">
        </div>

        {{-- Profile Photo --}}
        <div class="mb-3">
            <label for="profile_photo" class="form-label">Profile Photo</label>
            <input type="file" name="profile_photo" class="form-control">
        </div>

        {{-- Status --}}
        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" class="form-select">
                <option value="1" selected>Active</option>
                <option value="0">Inactive</option>
            </select>
        </div>

        {{-- Submit --}}
        <button type="submit" class="btn btn-primary">Create</button>
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
                gender: { required: true },
                dob: { required: true },
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