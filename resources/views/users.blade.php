@extends ('layout')

@section ('content')
    <div class="users">
        <h1>Users</h1>
        @forelse ($users as $user)
            <li>{{ $user->email }}</li>
        @empty
            <p>no users</p>
        @endforelse
    </div>
@endsection