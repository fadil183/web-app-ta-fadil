@extends('layouts.app')

@section('content')
<style>
  .center-vertical {
    display: flex;
    justify-content: center;
    align-items: flex-start;
    height: 100vh;
  }
</style>
<body>
    <div class="center-vertical">
        <ul class="list-group">
            <li class="list-group-item"><a href="https://serratus.github.io/quaggaJS/">barcode scanner</a></li>
            <li class="list-group-item"><a href="https://developer.mozilla.org/en-US/docs/Web/API/MediaDevices">Media Capture & Stream API</a></li>
            <li class="list-group-item"><a href="https://www.itsolutionstuff.com/post/laravel-10-user-roles-and-permissions-tutorialexample.html">User Role and Permission</a></li>
        </ul>
    </div>
</body>
@endsection