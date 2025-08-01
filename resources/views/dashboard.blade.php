@extends('layouts.app')

@section('content')
    <div class="container">
        {{-- Admin Dashboard --}}        
        @if(auth()->user()->role === 'admin')
            <h1>Admin Dashboard</h1>
            <p>Welcome, {{ auth()->user()->name }}</p>

            {{-- Teacher Dashboard --}}
        @else(auth()->user()->role === 'teacher')
            <h1>Teacher Dashboard</h1>
            <p>Welcome, {{ auth()->user()->name }}</p>

            <h4 class="mt-4">Announcements from Admin</h4>
            @forelse($announcements as $announcement)
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">{{ $announcement->title }}</h5>
                        <p class="card-text">{{ $announcement->message }}</p>
                        <p class="card-text">
                            <small class="text-muted">Posted by {{ $announcement->user->name ?? 'Admin' }} on {{ $announcement->created_at->format('d M Y') }}</small>
                        </p>
                    </div>
                </div>
            @empty
                <p>No announcements available.</p>
            @endforelse
        @endif
    </div>

@endsection