<!DOCTYPE html>
<html>
<head>
    <title>Pet Details</title>
    <script>
        function setCurrentDate() {
            var now = new Date();
            var isoDate = now.toISOString();
            document.getElementById('shipDate').value = isoDate;
        }

        window.onload = setCurrentDate;
    </script>
</head>
<body>
    <h1>Pet Details</h1>

    <strong>ID:</strong> {{ $pet['id'] }} <br>
    <strong>Name:</strong> {{ $pet['name'] }} <br>
    <strong>Status:</strong> {{ $pet['status'] }} <br>

    <!-- Display category if available -->
    @if(isset($pet['category']))
        <strong>Category:</strong> {{ $pet['category']['name'] }} (ID: {{ $pet['category']['id'] }}) <br>
    @endif

    <!-- Display photo URLs if available -->
    @if(isset($pet['photoUrls']) && count($pet['photoUrls']) > 0)
        <strong>Photo URLs:</strong>
        <ul>
            @foreach($pet['photoUrls'] as $photoUrl)
                <li>{{ $photoUrl }}</li>
            @endforeach
        </ul>
    @endif

    <!-- Display tags if available -->
    @if(isset($pet['tags']) && count($pet['tags']) > 0)
        <strong>Tags:</strong>
        <ul>
            @foreach($pet['tags'] as $tag)
                <li>{{ $tag['name'] }} (ID: {{ $tag['id'] }})</li>
            @endforeach
        </ul>
    @endif

    <!-- Form to place an order -->
    <h2>Place an Order for This Pet</h2>
    <form action="{{ url('/pets/' . $pet['id'] . '/order') }}" method="POST">
        @csrf
        <label for="quantity">Quantity:</label>
        <input type="number" name="quantity" min="1" required>
        <br>
        <label for="shipDate">Ship Date (ISO 8601):</label>
        <input type="text" id="shipDate" name="shipDate" required placeholder="2024-07-31T13:37:37.214Z">
        <br>
        <label for="status">Status:</label>
        <input type="text" name="status" value="placed" required>
        <br>
        <label for="complete">Complete:</label>
        <input type="checkbox" name="complete" value="1">
        <br>
        <button type="submit">Place Order</button>
    </form>

    <!-- Links to other actions -->
    <a href="{{ route('pets.index') }}">Back to List</a>
    <a href="{{ route('pets.edit', $pet['id']) }}">Edit</a>
    <form action="{{ route('pets.destroy', $pet['id']) }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit">Delete</button>
    </form>
</body>
</html>
