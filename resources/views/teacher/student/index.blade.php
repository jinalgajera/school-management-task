@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Students List</h4>
        <a href="{{ route('students.create') }}" class="btn btn-primary">
            <i class="fa fa-plus"></i> Add Student
        </a>
    </div>
    <table class="table table-bordered" id="student-table">
        <thead>
            <tr>
                <th>Teacher</th>
                <th>Student</th>
                <th>Phone</th>
                <th>Class</th>
                <th>Email</th>
                <th>Roll Number</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
    </table>
</div>
@endsection

@push('scripts')   
    <script>
        $(function () {
            $('#student-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('students.data') }}',
                columns: [
                    { data: 'teacher_name', name: 'teacher_name' },  // Use alias, not real DB column
                    { data: 'student_name', name: 'name' },
                    { data: 'phone_no', name: 'phone' },
                    { data: 'class', name: 'class' },
                    { data: 'email', name: 'email' },
                    { data: 'roll_number', name: 'roll_number' },
                    { data: 'status', name: 'status', orderable: false, searchable: false },
                    { data: 'action', name: 'action', orderable: false, searchable: false },
                ]
            });
        });

        function deleteStudent(id) {
            if (confirm("Are you sure you want to delete this student?")) {
                $.ajax({
                    url: "{{url('/students')}}/" + id,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        alert(response.message);
                        $('#student-table').DataTable().ajax.reload();
                    },
                    error: function(xhr) {
                        alert("Failed to delete student.");
                    }
                });
            }
        }
    </script>
@endpush

