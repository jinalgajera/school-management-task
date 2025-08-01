@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Parents List</h4>
        <a href="{{ route('parentUsers.create') }}" class="btn btn-primary">
            <i class="fa fa-plus"></i> Add Parent
        </a>
    </div>
    <table class="table table-bordered" id="parent-table">
        <thead>
            <tr>
                <th>Student Name</th>
                <th>Parent Name</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Profession</th>
                <th>Action</th>
            </tr>
        </thead>
    </table>
</div>
@endsection

@push('scripts')   
    <script>
        $(function () {
            $('#parent-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('parentUsers.data') }}',
                columns: [
                    { data: 'student_name', name: 'student_name' },  // Use alias, not real DB column
                    { data: 'name', name: 'name' },
                    { data: 'phone', name: 'phone' },
                    { data: 'email', name: 'email' },
                    { data: 'profession', name: 'profession' },
                    { data: 'action', name: 'action', orderable: false, searchable: false },
                ]
            });
        });

        function deleteParentUsers(id) {
            if (confirm("Are you sure you want to delete this Parent?")) {
                $.ajax({
                    url: "{{url('/parentUsers')}}/" + id,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        alert(response.message);
                        $('#parent-table').DataTable().ajax.reload();
                    },
                    error: function(xhr) {
                        alert("Failed to delete Parent.");
                    }
                });
            }
        }
    </script>
@endpush

