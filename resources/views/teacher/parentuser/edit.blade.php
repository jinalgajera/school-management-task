@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Parent</h2>

    <form id="parentForm" action="{{ route('parentUsers.update', $parentUser->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Student Name --}}
        <div class="mb-3">
            <label for="student_id" class="form-label">Select Student</label>
            <select name="student_id" class="form-select">
               <option value="">Select Student</option>
                @foreach($students as $student)
                    <option value="{{ $student->id }}" {{ $parentUser->student_id == $student->id ? 'selected' : '' }}>
                        {{ $student->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $parentUser->name) }}">
        </div>

        {{-- Phone --}}
        <div class="mb-3">
            <label for="phone" class="form-label">Phone</label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone', $parentUser->phone) }}">
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="text" name="email" class="form-control" value="{{ old('email', $parentUser->email) }}">
        </div>


        {{-- Profession --}}
        <div class="mb-3">
            <label for="profession" class="form-label">Profession</label>
            <input type="text" name="profession" class="form-control" value="{{ old('profession', $parentUser->profession) }}">
        </div>

        <button type="submit" class="btn btn-success">Update</button>
    </form>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        $('#parentForm').validate({
            rules: {
                student_id: { required: true },
                name: { required: true },
                phone: { required: true, digits: true, minlength: 10, maxlength: 15 },
                email: { required: true, email: true },
                profession: { required: true },
            },
            messages: {
                student_id: "Please select a student",
                name: "Please enter name",
                phone: {
                    required: "Please enter phone number",
                    digits: "Phone number must contain only digits",
                    minlength: "Phone must be at least 10 digits",
                    maxlength: "Phone must not exceed 15 digits"
                },
                email: {
                    required: "Please enter an email address",
                    email: "Please enter a valid email address (e.g. user@example.com)"
                },
                profession: "Please enter profession",
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('text-danger');
                error.insertAfter(element);
            }
        });
    });
</script>
@endpush
