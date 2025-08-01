<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        @php
            $user = Auth::user();
            $isAdmin = $user && $user->role === 'admin';
        @endphp
        <a class="navbar-brand" href="{{ route('dashboard') }}">School Management</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
           <ul class="navbar-nav me-auto">
                 <li class="nav-item">
                    <a class="nav-link {{ request()->is('dashboard') ? 'active' : '' }}" 
                    href="{{ route('dashboard') }}">
                        Dashboard
                    </a>
                </li>
                @if($isAdmin)
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('teachers*') ? 'active' : '' }}" 
                        href="{{route('teachers.index')}}">
                            Teachers
                        </a>
                    </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('/students*') ? 'active' : '' }}" 
                    href="{{route('students.index')}}">
                        Students
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->is('/parentUsers*') ? 'active' : '' }}" 
                    href="{{route('parentUsers.index')}}">
                        Parents
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->is('announcements*') ? 'active' : '' }}" 
                    href="{{route('announcements.index')}}">
                        Announcements
                    </a>
                </li>
            </ul>
           <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ Auth::user()->name }}
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <!-- <a class="dropdown-item" href="{{ route('profile.edit') }}">Profile</a>
                        <div class="dropdown-divider"></div> -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="dropdown-item" type="submit">Logout</button>
                        </form>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>
