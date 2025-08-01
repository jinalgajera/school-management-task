@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Create Announcement</h3>
    @php
        $user = auth()->user();
    @endphp
    <form id="admin_announce" method="POST" action="{{ route('announcements.store') }}">
        @csrf

        <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" name="title" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Message</label>
            <textarea name="message" class="form-control" rows="5"></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Target Audience</label>
            <select name="target" class="form-control" required>
                @if ($user->role === 'admin')
                    <option value="teachers">Teachers</option>
                @elseif ($user->role === 'teacher')
                    <option value="students">Students</option>
                    <option value="parents">Parents</option>
                    <option value="students_and_parents">Students & Parents</option>
                @endif
            </select>
        </div>

        <button type="submit" class="btn btn-success">Post Announcement</button>
    </form>
</div>
@endsection
@push('scripts')
<script>
    $(document).ready(function () {
        $('#admin_announce').validate({
            rules: {
                title: { required: true },
                message: { required: true },
            },
            messages: {
                title: "Please enter your Title",
                message: "Please enter your Message",
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
