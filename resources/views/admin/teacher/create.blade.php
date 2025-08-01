@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Add New Teacher</h2>

    <form id="teacherForm" action="{{ route('teachers.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" class="form-control">
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="text" name="email" class="form-control">
        </div>

        {{-- Phone --}}
        <div class="mb-3">
            <label for="phone" class="form-label">Phone</label>
            <input type="text" name="phone" class="form-control">
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

        {{-- Address --}}
        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <textarea name="address" class="form-control"></textarea>
        </div>

        {{-- Qualification --}}
        <div class="mb-3">
            <label for="qualification" class="form-label">Qualification</label>
            <input type="text" name="qualification" class="form-control">
        </div>

        {{-- Experience --}}
        <div class="mb-3">
            <label for="experience" class="form-label">Experience (Years)</label>
            <input type="text" name="experience" class="form-control" min="0">
        </div>

        {{-- Joining Date --}}
        <div class="mb-3">
            <label for="joining_date" class="form-label">Joining Date</label>
            <input type="date" name="joining_date" class="form-control">
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
        $('#teacherForm').validate({
            rules: {
                name: { required: true },
                email: { required: true, email: true },
                phone: { required: true, digits: true, minlength: 10, maxlength: 15 },
                gender: { required: true },
                address: { required: true },
                qualification: { required: true },
                experience: { digits: true, min: 0 },
                profile_photo: { extension: "jpg|jpeg|png|gif" },
                status: { required: true }
            },
            messages: {
                name: "Please enter your name",
                email: {
                    required: "Please enter an email address",
                    email: "Please enter a valid email address (e.g. user@example.com)"
                },
                phone: {
                    required: "Please enter your phone number",
                    digits: "Phone number should contain only digits",
                    minlength: "Phone number must be at least 10 digits",
                    maxlength: "Phone number must not exceed 15 digits"
                },
                gender: "Please select a gender",
                address: "Please enter your address",
                qualification: "Please enter your qualification",
                experience: {
                    digits: "Experience must be a number",
                    min: "Experience cannot be negative"
                },
                profile_photo: "Only image files (jpg, jpeg, png, gif) are allowed",
                status: "Please select a status"
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