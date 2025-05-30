<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Telkom Marketplace</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #ffffff;
        }

        .header {
            background-color: #e53935; /* warna merah Telkom */
            color: white;
            padding: 15px 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .container {
            padding: 20px;
        }

        .logout-btn {
            background-color: #e53935;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Telkom Marketplace Dashboard</h1>
    </div>

    <div class="container">
        <h2>Welcome, {{ auth()->user()->name }}!</h2>
        <p>Email: {{ auth()->user()->email }}</p>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout-btn">Logout</button>
        </form>
    </div>
</body>
</html>
