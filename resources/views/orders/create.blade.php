@extends('layouts.app')
@section('content')
<!-- qrcode lib -->
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

<script src="https://rawgit.com/serratus/quaggaJS/master/dist/quagga.min.js"></script>

<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2>Tambah Bukti Kemas</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-primary form-control" href="{{ route('orders.index') }}"> Back</a>
        </div>
    </div>
</div>
@if ($errors->any())
<div class="alert alert-danger">
    <strong>Whoops!</strong> There were some problems with your input.<br><br>
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('orders.store') }}" method="POST">
    @csrf
    <div class="col-xs-12 col-sm-12 col-md-12">

        <div class="form-group">
            <strong>Kamera</strong>

            <div id="notif-warning" class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Pilih kamera terlebih dahulu</strong>
                </button>
            </div>
            <select id="cameraSelect" class="form-control" required>
                <option value="">Kamera Belum dipilih</option>
            </select>
        </div>
        <div class="form-group">
            <strong>Nomor pesanan / resi :</strong>
            <input id="id_order" type="text" name="id_order" class="form-control" placeholder="nomor pesanan / nomor resi" value="">
            <div id="qr-reader" style="width: 100%"></div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Hasil Gambar Kemas Paket:</strong>
            <div class="row">
                <div id="image-view"></div>
                 <!-- ketika sudah menangkap gambar maka atur data gambar uri ke class image-tag -->
                 <input id="image-data" class="image-data" type="hidden" name="image">
                 
                {{-- tag untuk menempatkan video stream --}}
                <video id="video" class="form-control" width="100%" height="auto" autoplay></video>
                <input id="stopScan" class="form-control" type="button" value="Stop Scan"></input>
                <!-- untuk memindai barcode -->
                <input id="startScan" class="btn btn-success" type="button" value="Start Scan"></input>
                <!--tombol untuk menangkap gambar -->
                <input id="capture" class="btn btn-warning " type="button" value="Capture"></input>
               
                <!-- serta tampilkan bukti gambar ke pengguna -->
                <canvas id="canvas" style="display:none;"></canvas>
                <div id="output"></div>

            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Detail:</strong>
            <textarea class="form-control" style="height:150px" name="detail_order" placeholder="Detail"></textarea>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
        <button type="submit" class="btn btn-primary form-control">Submit</button>
    </div>

</form>

<script src="{{ asset('js/rekambuktikemas.js')}}"></script>
@endsection