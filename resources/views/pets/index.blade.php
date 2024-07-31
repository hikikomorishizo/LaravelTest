<!DOCTYPE html>
<html>
<head>
    <title>Pets List</title>
</head>
<body>
    <h1>Pets List</h1>

    <!-- Form to Add Pet -->
    <form action="/pets" method="POST">
        @csrf
        <input type="text" name="name" placeholder="Name" required>
        <input type="text" name="status" placeholder="Status" required>
        <button type="submit">Add Pet</button>
    </form>

    <!-- Form to Search by Name -->
    <h2>Search Pets by Name</h2>
    <form action="/pets" method="GET">
        <input type="text" name="search_name" placeholder="Enter pet name">
        <button type="submit">Search by Name</button>
    </form>

    <!-- Form to Search by ID -->
    <h2>Search Pets by ID</h2>
    <form action="/pets" method="GET">
        <input type="number" name="search_id" placeholder="Enter pet ID">
        <button type="submit">Search by ID</button>
    </form>

    <ul>
        @foreach($pets as $pet)
            <li>
                {{ $pet['name'] }} - {{ $pet['status'] }}
                <a href="/pets/{{ $pet['id'] }}">View</a>
                <form action="/pets/{{ $pet['id'] }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Delete</button>
                </form>
            </li>
        @endforeach
    </ul>
</body>
</html>
