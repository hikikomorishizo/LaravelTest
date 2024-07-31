<!DOCTYPE html>
<html>
<head>
    <title>User List</title>
</head>
<body>
    <h1>User List</h1>

    <h2>Create User</h2>
    <form action="{{ route('users.create') }}" method="POST">
        @csrf
        <input type="text" name="username" placeholder="Username" required>
        <input type="text" name="firstName" placeholder="First Name" required>
        <input type="text" name="lastName" placeholder="Last Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="text" name="phone" placeholder="Phone">
        <input type="number" name="userStatus" placeholder="User Status" value="0">
        <button type="submit">Create</button>
    </form>

    <h2>Search User by Username</h2>
    <form action="{{ route('users.search') }}" method="GET">
        @csrf
        <input type="text" name="username" placeholder="Enter Username" required>
        <button type="submit">Search</button>
    </form>
</body>
</html>
