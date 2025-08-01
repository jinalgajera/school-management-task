@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>All Announcements</h4>
        <a href="{{ route('announcements.create') }}" class="btn btn-primary">
            <i class="fa fa-plus"></i> Add Announcements
        </a>
    </div>

    <table class="table table-bordered" id="announcementTable">
        <thead>
            <tr>
                <th>#</th>
                <th>Title</th>
                <th>Target</th>
                <th>Posted By</th>
            </tr>
        </thead>
    </table>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function () {
    $('#announcementTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('announcements.index') }}",
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
            { data: 'title', name: 'title' },
            { data: 'target', name: 'target' },
            { data: 'user', name: 'user.name' },
        ]
    });
});
</script>
@endpush
