@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Add Parent</h2>

    <form id="parentForm" action="{{ route('parentUsers.store') }}" method="POST">
        @csrf

        {{-- Student Name --}}
        <div class="mb-3">
            <label for="student_id " class="form-label">Select Student</label>
            <select name="student_id " class="form-select">
                <option value="">Select Student</option>
                @foreach($students as $student)
                    <option value="{{$student->id}}">{{$student->name}}</option>
                @endforeach
            </select>
        </div>

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

        {{-- profession --}}
        <div class="mb-3">
            <label for="profession" class="form-label">Profession</label>
            <input type="text" name="profession" class="form-control">   
        </div>       

        {{-- Submit --}}
        <button type="submit" class="btn btn-primary">Create</button>
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
                student_id: "Please Select Student name",
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
                profession: "Please select a gender",
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