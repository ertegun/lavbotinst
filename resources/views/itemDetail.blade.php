<!-- caredit.blade.php -->

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <!-- <title>Laravel MongoDB CRUD Tutorial With Example</title> -->
  <!-- <link rel="stylesheet" href="{{asset('css/app.css')}}"> -->
  <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>

  <!-- Compiled and minified CSS -->
  <!-- Compiled and minified JavaScript -->
  <!--Import Google Icon Font-->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <!--Import materialize.css-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" media="screen,projection" />
  <!--Let browser know website is optimized for mobile-->
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!-- <meta property="og:url" content="http://grikar.ga" /> -->
  <meta property="og:type" content="article" />
  <meta property="og:title" content="{{$messages[0]->media_share['caption']['text']}}" />
  <meta property="og:description" content="{{$messages[0]->media_share['caption']['text']}}" />
  <meta property="og:image" content="{{$messages[0]->media_share['image_versions2']['candidates'][0]['url']}}" />
</head>

<body>
  <div class="container">
    <div class="row">
      <div class="col s12 m12">
        <div class="card">
          <div class="card-image">
            @if($messages[0]->media_share['media_type']==2)
            <video src="{{$messages[0]->media_share['video_versions'][0]['url']}}" class="responsive-video" controls autoplay>Your browser does not support the video tag.</video>
            @endif
            @if($messages[0]->media_share['media_type']==1)
              <img src="{{$messages[0]->media_share['image_versions2']['candidates'][0]['url']}}">
            @endif
            <!-- <span class="card-title">Card Title</span> -->
          </div>
          <div class="card-content">
            <p>{{$messages[0]->media_share['caption']['text']}}</p>
          </div>
          <!-- <div class="card-action">
          <a href="#">This is a link</a>
        </div> -->
        </div>
      </div>
    </div>
  </div>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>

</html>