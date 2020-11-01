<!doctype html>
<html>

<head>
  @include('includes.head')
</head>
<style>

</style>
<body>
  <header class="row">
    @include('includes.header')
  </header>
  <div class="container">
    <!-- Page Content goes here -->
    @yield('content')
  </div>
  <footer class="row">
    @include('includes.footer')
  </footer>
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