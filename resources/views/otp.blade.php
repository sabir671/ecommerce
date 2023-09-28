<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification</title>
</head>
<body>
    <h1>OTP Verification</h1>

    <!-- Display any validation errors if needed -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- OTP Form -->
    <form method="POST" action="{{ route('sendOtp') }}">
        @csrf

        <!-- Phone Number Field -->
        <div class="form-group">
            <label for="phone_number">Phone Number:</label>
            <input type="text" id="phone_number" name="phone_number" required>
        </div>

        <!-- Submit Button -->
        <button type="submit">Send OTP</button>
    </form>
</body>
</html>
