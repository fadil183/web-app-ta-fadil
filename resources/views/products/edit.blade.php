@extends('layouts.app')

@section('content')
<script src="https://unpkg.com/html5-qrcode@2.0.9/dist/html5-qrcode.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.25/webcam.min.js"></script>

    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Edit Product</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-primary" href="{{ route('products.index') }}"> Back</a>
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

    <form action="{{ route('products.update',$product->id) }}" method="POST">
    	@csrf
        @method('PUT')

         <div class="row">
		    <div class="col-xs-12 col-sm-12 col-md-12">
		        <div class="form-group">
		            <strong>Nomor Pesanan:</strong>
                    <div id="qr-reader" style="width: 600dp"></div>    
		            <input type="text" name="order_id" value="{{ $product->order_id }}" class="form-control">
		        </div>
		    </div>
		    <div class="col-xs-12 col-sm-12 col-md-12">
		        <div class="form-group">
		            <div class="row">
                        <div class="col-md-6">
                        <strong>data diubah:</strong>
		                <input disabled class="form-control"  name="updated_at" type="date" value="{{ $product->updated_at }}">
                        </div>
                        <div class="col-md-6">
                        <strong>data dimasukan:</strong>
		                <input disabled class="form-control"  name="created_at" type="date" value+="{{ $product->created_at }}">
                        </div>
                    </div>
                    <div class="row">
                    <strong>Foto</strong>
                        <div class="col">
                           
                            <div id="my_camera"></div>
                            <input class="btn btn-info" type=button value="Take Snapshot" onClick="take_snapshot()">
                        </div>
                        <div class="col">
                            <input class="image-tag" type="hidden" name="image"  >
                            <input type="hidden" name="saved_image_name" value="{{$product->order_image}}">
                            <div id="results" class="overflow-hidden w-100" alt="Responsive image">Your captured image will appear here...</div>
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
    <script src="{{ asset('js/image_capturer.js')}}"></script>
    <script src="{{ asset('js/code_scanner.js')}}"></script>
    <!-- load image from previous saved image from storage -->
    <script>
            document.getElementById('results').innerHTML = '<img src="{{asset('uploads/images/'.$product->order_image)}}"/>'
    </script>
    
@endsection