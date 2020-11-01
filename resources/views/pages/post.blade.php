@extends('layouts.default')
@section('content')
<!-- <div class="row"> -->
      <!-- <div class="col s12 m12"> -->
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
      <!-- </div> -->
    <!-- </div> -->
@stop