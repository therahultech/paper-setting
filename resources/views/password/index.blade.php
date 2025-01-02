<!DOCTYPE html>
<html>
<head>
    <title>Generate Hashed Password</title>
</head>
<body>
    <h1>Generate Hashed Password</h1>
    <form method="POST" action="{{ route('password.generate') }}">
        @csrf
        <label for="password">Enter Password:</label>
        <input type="password" name="password" required>
        <button type="submit">Generate Password</button>
    </form>

    @if (isset($hashedPassword))
        <h3>Hashed Password:</h3>
        <p>{{ $hashedPassword }}</p>
    @endif

    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</body>
</html>
