@section('head')
<meta charset="UTF-8">
<title>@yield('pagename')</title>
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
<script src="{{ mix('js/app.js') }}" defer></script>
<script src="https://kit.fontawesome.com/7791d4487f.js" crossorigin="anonymous"></script>
<script src="https://unpkg.com/vuejs-paginate@latest"></script>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection