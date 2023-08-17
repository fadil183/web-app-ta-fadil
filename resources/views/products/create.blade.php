@extends('layouts.app')
@section('content')
<script src="https://unpkg.com/html5-qrcode@2.0.9/dist/html5-qrcode.min.js"></script>
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Add New Product</h2>
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

    <form action="{{ route('products.store') }}" method="POST">
    	@csrf

         <div class="row">
		    <div class="col-xs-12 col-sm-12 col-md-12">
		        <div class="form-group">
		            <strong>Nomor Pesanan:</strong>
                    <div id="qr-reader" style="width: 600dp"></div>    
		            <input id="order_id" type="text" name="order_id" class="form-control" placeholder="nomor pesanan pada resi" value="">
		        </div>
		    </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
		        <div class="form-group">
		            <strong>picture:</strong>
                    ...
		        </div>
		    </div>
		    <div class="col-xs-12 col-sm-12 col-md-12">
		        <div class="form-group">
		            <strong>Detail:</strong>
		            <textarea class="form-control" style="height:150px" name="detail" placeholder="Detail"></textarea>
		        </div>
		    </div>
		    <div class="col-xs-12 col-sm-12 col-md-12 text-center">
		            <button type="submit" class="btn btn-primary">Submit</button>
		    </div>
		</div>

    </form>

    <script>
        //mengecek apakah ada element id=order_id
     var inputElement = document.getElementById("order_id");
    function onScanSuccess(decodedText, decodedResult) {
        console.log(`Code scanned = ${decodedText}`, decodedResult);
        inputElement.value=`${decodedText}`;
        html5QrcodeScanner.clear();
    }
    
    var html5QrcodeScanner = new Html5QrcodeScanner(
        "qr-reader", { fps: 10, QrDimensions : { width: 350, height: 150 } });
        html5QrcodeScanner.render(onScanSuccess);
    
    
    // let config = {
    // fps: 10,
    // qrbox: {width: 250, height: 100}
    // // ,
    // // rememberLastUsedCamera: true,
    // // Only support camera scan type.
    // // supportedScanTypes: [Html5QrcodeScanType.SCAN_TYPE_CAMERA]
    // };

    // let html5QrcodeScanner = new Html5QrcodeScanner(
    // "reader", config, /* verbose= */ false);
    // html5QrcodeScanner.render(onScanSuccess);
    

    
    
</script>
@endsection