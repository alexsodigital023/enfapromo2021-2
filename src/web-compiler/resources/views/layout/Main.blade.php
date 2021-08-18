<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Enfabebe Promo 2021 | @yield('title')</title>

  <link rel="stylesheet" href="css/app.css">

  <script src="js/app.js"></script>
</head>

<body class="@yield('state')">
  <div class="xPageInner">
    <header>
      @include('../sections/menu',['id'=>$menu])
    </header>
    <main>
      <section id='@yield("id")' class="section @yield('class')" data-stateName="@yield(' class')">
        @yield("content")
      </section>
    </main>
    <footer>
      @include('../sections/footer')
    </footer>
  </div>
</body>

</html>