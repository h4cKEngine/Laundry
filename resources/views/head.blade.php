<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- Token CSRF -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- Fonts -->
        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <!-- Styles -->
        <link rel="stylesheet" type="text/css" href="{{ asset('./css/navbar.css') }}" >
        <link rel="icon" type="image/x-icon" href="{{ asset('./img/laundryLogo.png') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css') }}" integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" crossorigin="anonymous" referrerpolicy="no-referrer" >
        <!-- Scripts -->
        {{-- <script type="text/javascript" src="{{ asset('https://code.jquery.com/jquery-3.6.1.min.js') }}"></script> --}}
        <script type="text/javascript" src="{{ asset('js/jquery-3.6.1.min.js') }}"></script>
</head>