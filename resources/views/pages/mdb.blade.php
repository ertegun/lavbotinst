@extends('layouts.default')
@section('content')
<div class="row">
  <div class="col-md-4">
    <a href="/getInbox" target="_blank" class="waves-effect waves-light btn"><i class="material-icons right">cloud</i>getInbox</a>
  </div>
  <div class="col-md-4">
    <a href="/rb" target="_blank" class="waves-effect waves-light btn"><i class="material-icons left">cloud</i>RunBot</a>
  </div>
</div>
<div class="row">
  <div class="col-md-12">
    <table class="">
      <thead>
        <tr>
          <th>ID</th>
          <th>Company</th>
          <th>Model</th>
          <th>Price</th>
          <th colspan="2">Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach($messages as $msg)
        <tr>
          <td>{{$msg->datetime_str}}</td>
          <td>{{$msg->item_id}}</td>
          <td>{{$msg->user_id}}</td>
          <td>{{$msg->item_id}}</td>
          <td> </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@stop