<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <meta name="googlebot" content="noindex, nofollow">


    <title>Systra - BPP</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">

    <!-- Styles -->
    <style>
        html,
        body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Lato', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links>a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .button {
            background-color: #4CAF50;
            /* Green */
            border: none;
            color: white;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
        }

        .m-b-md {
            margin-bottom: 30px;
        }

        footer {
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="flex-center position-ref full-height">
        @if (Route::has('login'))
        <div class="top-right links">
            @auth
            <a href="{{ url('/home') }}">Home</a>
            @else
            <a href="{{ route('login') }}">Login</a>

            @endauth
        </div>
        @endif

        <div class="content">

            <a class="navbar-brand" href="{{route('home')}}"><img src="{{asset('images/systra.jpg')}}" alt="systra"></a>
            <div class="title m-b-md">
                Business Partner Portal
            </div>
            {{-- 
            <div class="links">
                <a href="">Systra India Pvt Limited</a>
            </div> --}}

            @if (Route::has('login'))

            @auth
            <a href="{{ url('/home') }}">
                <button type="button" class="button ">Proceed to Homepage</button></a>
            @else
            <a href="{{ route('login') }}">
                <button type="button" class="button ">Proceed to Login</button></a>

            @endauth

            @endif
        </div>

    </div>

    <footer>
        <p>SYSTRA &#169; <script>
                document.write(new Date().getFullYear())
            </script>
        </p>

    </footer>
</body>

</html>