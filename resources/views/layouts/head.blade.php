<?php
if(env('APP_ENV')==='production'){
    $is_production=true;
}else{
    $is_production=false;
}?>
@section('head')
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-179570799-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-179570799-1');
</script>
<meta charset="UTF-8">
<title>@yield('pagename')</title>
<link rel="stylesheet" href="{{ asset('css/app.css',$is_production) }}">
<script src="{{ mix('js/app.js') }}" defer></script>
<script src="https://kit.fontawesome.com/7791d4487f.js" crossorigin="anonymous"></script>
<script src="https://unpkg.com/vuejs-paginate@latest"></script>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection