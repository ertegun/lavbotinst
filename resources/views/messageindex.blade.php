<!-- carindex.blade.php -->

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <title>Index Page</title>
  <link rel="stylesheet" href="{{asset('css/app.css')}}">
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>

<body>
  <div class="container">
    <div class="row">
      <div class="col-md-4">
        <a href="/getInbox" target="_blank" class="btn btn-primary">getInbox</a>
      </div>
      <div class="col-md-4">
        <a href="/rb" target="_blank" class="btn btn-primary">RunBot</a>
      </div>
    </div>
    <br />
    @if (\Session::has('success'))
    <div class="alert alert-success">
      <p>{{ \Session::get('success') }}</p>
    </div><br />
    @endif
   
  </div>
</body>

</html>