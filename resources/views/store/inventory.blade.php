<!DOCTYPE html>
<html>
<head>
    <title>Store Inventory</title>
</head>
<body>
    <h1>Store Inventory</h1>
    <ul>
        @foreach($inventory as $status => $count)
            <li>{{ $status }}: {{ $count }}</li>
        @endforeach
    </ul>
</body>
</html>
