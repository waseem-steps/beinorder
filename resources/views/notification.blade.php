@extends('layouts.master')

@section('content')
<!-- page content -->
<div class="right_col" role="main">
    <audio id="xyz" src="{{ asset('sounds\bell_ring.mp3') }}"  muted></audio>
<script src="https://js.pusher.com/4.1/pusher.min.js"></script>

<script>

    var pusher = new Pusher('{{env("MIX_PUSHER_APP_KEY")}}', {
      cluster: '{{env("PUSHER_APP_CLUSTER")}}',
      encrypted: true
    });

    var channel = pusher.subscribe('notify-channel');

    channel.bind('App\\Events\\Notify', function(data) {
 
 document.getElementById('xyz').muted = false;
 //document.getElementById('xyz').play();
       // alert('new order');
        document.getElementById('xyz').play();
        new PNotify({
        title: 'New Order',
        text: 'New Order has been submitted\n www.google.com',
        type: 'info',
        styling: 'bootstrap3'
        });
    });
</script>
</div>
<!-- /page content -->
@endsection


