<!DOCTYPE html>
<html>
<head>
    <title>User Details</title>
</head>
<body>
    <h1>User Details</h1>

    @if(session('error'))
        <p>{{ session('error') }}</p>
    @endif
    @if(session('success'))
        <p>{{ session('success') }}</p>
    @endif

    @if(isset($user))
        <h2>User Information</h2>
        <p><strong>Username:</strong> {{ $user['username'] }}</p>
        <p><strong>First Name:</strong> {{ $user['firstName'] }}</p>
        <p><strong>Last Name:</strong> {{ $user['lastName'] }}</p>
        <p><strong>Email:</strong> {{ $user['email'] }}</p>
        <p><strong>Phone:</strong> {{ $user['phone'] }}</p>
        <p><strong>User Status:</strong> {{ $user['userStatus'] }}</p>

        <h2>Update User</h2>
        <form action="{{ route('users.update', ['username' => $user['username']]) }}" method="POST">
            @csrf
            @method('PUT')
            <input type="text" name="firstName" value="{{ old('firstName', $user['firstName']) }}" placeholder="First Name" required>
            <input type="text" name="lastName" value="{{ old('lastName', $user['lastName']) }}" placeholder="Last Name" required>
            <input type="email" name="email" value="{{ old('email', $user['email']) }}" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="text" name="phone" value="{{ old('phone', $user['phone']) }}" placeholder="Phone">
            <input type="number" name="userStatus" value="{{ old('userStatus', $user['userStatus']) }}" placeholder="User Status">
            <button type="submit">Update User</button>
        </form>

        <form action="{{ route('users.destroy', ['username' => $user['username']]) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit">Delete User</button>
        </form>
    @else
        <p>No user found.</p>
    @endif

    <a href="{{ route('users.index') }}">Back to User List</a>
</body>
</html>
