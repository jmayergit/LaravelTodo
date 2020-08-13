@extends ('layout')

@section ('content')
    <div class="todos">
        <h1>Todos</h1>
        @forelse ($todos as $todo)
            <li>{{ $todo->description }}</li>
        @empty
            <p>no todos</p>
        @endforelse
    </div>
@endsection