<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile - Telkom Marketplace</title>
    <link rel="stylesheet" href="{{ asset('css/profile.css') }}">
</head>
<body>
    <div class="profile-container">
        <h1>My Profile</h1>
        <div class="profile-card">
            <div class="profile-header">
                <h2>{{ $user->name }}</h2>
            </div>
            <div class="profile-details">
                <p><strong>Email:</strong> {{ $user->email }}</p>
                <p><strong>Phone:</strong> {{ $user->phone ?? 'Not provided' }}</p>
                <p><strong>Address:</strong> {{ $user->address ?? 'Not provided' }}</p>
            </div>
            <a href="{{ route('dashboard') }}" class="back-btn">Back to Dashboard</a>
        </div>
    </div>
</body>
</html>
