<!doctype html>
<html>

<head>
  @include('includes.head')
</head>
<style>
  body {
    display: flex;
    min-height: 100vh;
    flex-direction: column;
  }

  main {
    flex: 1 0 auto;
  }
</style>

<body>
  <header>
    @include('includes.header')
  </header>
  <main>
    <div class="container">
      <!-- Page Content goes here -->
      @yield('content')
    </div>

  </main>

  @include('includes.footer')
  <!-- Compiled and minified JavaScript -->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
  <script>
    $(document).ready(function() {
      $('.sidenav').sidenav();
    });
  </script>
</body>

</html>