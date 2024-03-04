<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SBA-OJT PORTAL Reset Password</title>
    <style>
        /* Inline CSS */
        body {
            background-color: #f3f4f6;
            padding: 2rem;
        }

        .container {
            max-width: 28rem;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 0.5rem;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            overflow: hidden;
        }

        .content {
            padding: 1.5rem;
            text-align: center;
            /* Center align content */
        }

        .title {
            font-size: 1.5rem;
            /* Increased size for title text */
            font-weight: bold;
            margin-bottom: 1rem;
        }

        .text {
            color: #4b5563;
            margin-bottom: 0.75rem;
        }

        .button {
            display: inline-block;
            background-color: #AD974F;
            color: #1F2937;
            /* Button text color set to white */
            font-weight: bold;
            font-size: 1rem;
            /* Increased size for button text */
            padding: 0.75rem 1.5rem;
            /* Increased padding for button */
            border-radius: 0.25rem;
            text-decoration: none;
        }

        .button:hover {
            background-color: #AD974F;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="content">
            <h1 class="title">Reset Password</h1>
            <p class="text">The Reset Password link will expire after 30 minutes.</p>
            <p class="text">Click the button below to reset your password.</p>
            <a href="{{ route('reset.password', $token) }}" class="button">Reset Password</a>
        </div>
    </div>
</body>

</html>