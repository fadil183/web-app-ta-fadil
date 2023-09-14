@extends('layouts.app')
@section('content')
    <script src="https://rawgit.com/serratus/quaggaJS/master/dist/quagga.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Edit Order</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('orders.index') }}"> Back</a>
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

    <form action="{{ route('orders.update', $order->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <strong>Kamera</strong>

            <div id="notif-warning" class="alert alert-warning alert-dismissible fade show" role="alert">
                <strong>Pilih kamera terlebih dahulu</strong>
                </button>
            </div>
            <select id="cameraSelect" class="form-control">
                <option value="">Kamera Belum dipilih</option>
            </select>
        </div>
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Nomor Pesanan:</strong>
                    {{-- <div id="qr-reader" style="width: 600dp"></div>     --}}
                    <input type="text" id="id_order" name="id_order" value="{{ $order->id_order }}"
                        class="form-control">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-6">
                            <strong>data terakhir diubah:</strong>
                            <input disabled class="form-control" name="updated_at" type="date"
                                value="{{ $order->updated_at }}">
                        </div>
                        <div class="col-md-6">
                            <strong>data dimasukan:</strong>
                            <input disabled class="form-control" name="created_at" type="date"
                                value="{{ $order->created_at }}">
                        </div>
                    </div>
                    <div class="row">
                        <strong>Foto</strong>
                        <div class="col">
                            <div id="image-view"></div>
                            {{-- ketika sudah menangkap gambar maka atur data url ke class image-tag --}}
                            <input id="image-data" class="image-data" type="hidden" name="image">


                            <video id="video" class="form-control" width="100%" height="auto" autoplay></video>
                            <input id="stopScan" class="form-control" type="button" value="Stop Scan"></input>
                            <!-- untuk memindai barcode -->
                            <input id="startScan" class="btn btn-success" type="button" value="Start Scan"></input>
                            <!--tombol untuk menangkap gambar -->
                            <input id="capture" class="btn btn-warning " type="button" value="Capture"></input>

                            <!-- serta tampilkan bukti gambar ke pengguna -->
                            <canvas id="canvas" style="display:none;"></canvas>

                        </div>
                        <div class="col">
                            <input type="hidden" name="saved_image_name" value="{{ $order->image_order }}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">

                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </div>

    </form>

    <script src="{{ asset('js/rekambuktikemas.js') }}"></script>

    <!-- load image from previous saved image from storage -->
    <script>
        document.getElementById('image-view').innerHTML =
            `<img src="{{ URL("storage/uploads/images/$order->image_order") }}"/>`;
    </script>

@endsection
