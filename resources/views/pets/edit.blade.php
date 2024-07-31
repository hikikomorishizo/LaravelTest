<!DOCTYPE html>
<html>
<head>
    <title>Edit Pet</title>
</head>
<body>
    <h1>Edit Pet</h1>

    <form action="{{ route('pets.update', $pet['id']) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="{{ old('name', $pet['name']) }}" required>
        <br>

        <label for="status">Status:</label>
        <input type="text" id="status" name="status" value="{{ old('status', $pet['status']) }}" required>
        <br>

        <button type="submit">Update Pet</button>
    </form>

    <a href="{{ route('pets.show', $pet['id']) }}">Back to Pet</a>
    <a href="{{ route('pets.index') }}">Back to List</a>
</body>
</html>
