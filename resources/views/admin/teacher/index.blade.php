@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Teachers List</h4>
        <a href="{{ route('teachers.create') }}" class="btn btn-primary">
            <i class="fa fa-plus"></i> Add Teacher
        </a>
    </div>
    <table class="table table-bordered" id="teachers-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Gender</th>
                <th>Phone</th>
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
            $('#teachers-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('teachers.data') }}',
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'name', name: 'user.name' },
                    { data: 'email', name: 'user.email' },
                    { data: 'gender', name: 'gender' },
                    { data: 'phone', name: 'phone' },
                    { data: 'status', name: 'status' },
                    { data: 'action', name: 'action', orderable: false, searchable: false },
                ]
            });
        });

        function deleteTeacher(id) {
            if (confirm("Are you sure you want to delete this teacher?")) {
                $.ajax({
                    url: "{{url('/teachers')}}/" + id,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        alert(response.message);
                        $('#teachers-table').DataTable().ajax.reload();
                    },
                    error: function(xhr) {
                        alert("Failed to delete teacher.");
                    }
                });
            }
        }
    </script>
@endpush

