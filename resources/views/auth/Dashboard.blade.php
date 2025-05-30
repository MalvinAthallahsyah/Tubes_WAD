<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Telkom Marketplace</title>
</head>
<body>
    <div class="header">
        <h1>Telkom Marketplace Dashboard</h1>
    </div>

    <div class="container">
        <div class="user-info">
            <h2>Welcome, {{ auth()->user()->name }}!</h2>
            <p>Email: {{ auth()->user()->email }}</p>
        </div>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout-btn">Logout</button>
        </form>
    </div>
</body>
</html>
