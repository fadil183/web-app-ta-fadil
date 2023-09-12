@extends('layouts.app')
@section('content')
<!-- qrcode lib -->
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<!-- webcam lib -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>


    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Add New Product</h2>
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

         <div class="row">
		    <div class="col-xs-12 col-sm-12 col-md-12">
		        <div class="form-group">
		            <strong>Nomor pesanan / resi :</strong> 
		            <input id="order_id" type="text" name="id_order" class="form-control" placeholder="nomor pesanan / nomor resi" value="">
                    <div id="qr-reader" style="width: 100%"></div>   
		        </div>
		    </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
		        <div class="form-group">
		            <strong>Bukti Gambar:</strong>
                    <div class="row">
                        <div class="col-md-6">
                            <div id="my_camera" style="width: 100%"></div>
                            <br/>
                            <input type="hidden" name="image" class="image-tag" >
                            <input class="form-control" type="button" value="Take Snapshot" onClick="take_snapshot()" >
                        </div>
                        <div class="col-md-6">
                            <div id="results">Your captured image will appear here...</div>
                        </div>
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
		</div>

    </form>

    <script src="{{ asset('js/image_capturer.js')}}"></script>
    <script src="{{ asset('js/code_scanner.js')}}"></script>

@endsection

