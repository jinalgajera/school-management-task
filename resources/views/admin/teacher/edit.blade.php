@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Update Teacher</h2>
    <form id="teacherForm" action="{{ route('teachers.update', $teacher->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $teacher->user->name ?? '') }}">
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="text" name="email" class="form-control" value="{{ old('email', $teacher->user->email ?? '') }}">
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">Phone</label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone', $teacher->phone ?? '') }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Gender</label><br>
            @foreach(['male', 'female', 'other'] as $gender)
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="gender" value="{{ $gender }}"
                        {{ old('gender', $teacher->gender ?? '') == $gender ? 'checked' : '' }}>
                    <label class="form-check-label text-capitalize">{{ $gender }}</label>
                </div>
            @endforeach
        </div>

        <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <textarea name="address" class="form-control">{{ old('address', $teacher->address ?? '') }}</textarea>
        </div>

        <div class="mb-3">
            <label for="qualification" class="form-label">Qualification</label>
            <input type="text" name="qualification" class="form-control" value="{{ old('qualification', $teacher->qualification ?? '') }}">
        </div>

        <div class="mb-3">
            <label for="experience" class="form-label">Experience (Years)</label>
            <input type="text" name="experience" class="form-control" value="{{ old('experience', $teacher->experience ?? '') }}">
        </div>

        <div class="mb-3">
            <label for="joining_date" class="form-label">Joining Date</label>
            <input type="date" name="joining_date" class="form-control"
                value="{{ old('joining_date', isset($teacher->joining_date) ? \Carbon\Carbon::parse($teacher->joining_date)->format('Y-m-d') : now()->format('Y-m-d')) }}">
        </div>

        <div class="mb-3">
            <label for="profile_photo" class="form-label">Profile Photo</label>
            <input type="file" name="profile_photo" class="form-control">
            @if(isset($teacher) && $teacher->profile_photo)
                <img src="{{ asset('storage/profile_photos/' . $teacher->profile_photo) }}" class="mt-2" width="100">
            @endif
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" class="form-select">
                <option value="1" {{ old('status', $teacher->status ?? 1) == 1 ? 'selected' : '' }}>Active</option>
                <option value="0" {{ old('status', $teacher->status ?? 1) == 0 ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
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