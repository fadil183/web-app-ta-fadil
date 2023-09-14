@extends('layouts.app')
@section('content')
<!-- qrcode lib -->
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<!-- webcam lib -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/webcamjs/1.0.26/webcam.js" integrity="sha512-AQMSn1qO6KN85GOfvH6BWJk46LhlvepblftLHzAv1cdIyTWPBKHX+r+NOXVVw6+XQpeW4LJk/GTmoP48FLvblQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script> -->

<script src="https://rawgit.com/serratus/quaggaJS/master/dist/quagga.min.js"></script>

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
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Kamera</strong>
            <select id="cameraSelect" class="form-control" required>
                <option value="">Kamera Belum dipilih</option>
            </select>
        </div>
        <div class="form-group">
            <strong>Nomor pesanan / resi :</strong>
            <input id="order_id" type="text" name="id_order" class="form-control" placeholder="nomor pesanan / nomor resi" value="">
            <div id="qr-reader" style="width: 100%"></div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12">
        <div class="form-group">
            <strong>Hasil Gambar Kemas Paket:</strong>
            <div class="row">
                <div id="image-view"></div>
                <video id="video" class="form-control" width="100%" height="auto" autoplay></video>
                <input id="startScan" class="form-control btn btn-success" type="button" value="Start Scan"></input>
                <input id="stopScan"  class="form-control"type="button" value="Stop Scan"></input>
                <!--tombol untuk menangkap gambar -->
                <input id="capture" class="form-control btn btn-warning" type="button" value="Capture"></input>
                <!-- ketika sudah menangkap gambar maka atur data gambar uri ke class image-tag -->
                <input id="image-data" class="image-data" type="hidden" name="image">
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
<!-- <script src="{{ asset('js/jsQR.js')}}"></script> -->
<!-- <script>
    const video = document.getElementById('video');
    const canvas = document.getElementById('canvas');
    const context = canvas.getContext('2d');
    const startScanButton = document.getElementById('startScan');
    const stopScanButton = document.getElementById('stopScan');
    const captureButton = document.getElementById('capture');
    const outputDiv = document.getElementById('output');
    const cameraSelect = document.getElementById('cameraSelect');
    var txtInputOrderId = document.getElementById("order_id");
    // var imgView= document.getElementById('image_view').innerHTML;
    // var imgData=document.getElementById('image_data');

    const selectedCameraId = null;
    //fungsi untuk menjalankan kamera

    // Fungsi untuk memilih kamera
    function getCameraList() {
        navigator.mediaDevices.enumerateDevices()
            .then((devices) => {
                devices.forEach((device) => {
                    if (device.kind === 'videoinput') {
                        const option = document.createElement('option');
                        option.value = device.deviceId;
                        option.text = device.label || `Camera ${cameraSelect.length + 1}`;
                        cameraSelect.appendChild(option);
                    }
                });
                // Cek apakah terdapat ID kamera yang disimpan di localStorage
                selectedCameraId = localStorage.getItem('selectedCameraId');
                if (selectedCameraId) {
                    cameraSelect.value = selectedCameraId;
                }
            })
            .catch((err) => {
                console.error('Error enumerating devices: ', err);
            });
    }
    // Panggil fungsi untuk mendapatkan daftar kamera
    getCameraList();

    // fungsi memulai stream video
    function startStream() {
        const selectedDeviceId = event.target.value;
        const constraints = {
            video: {
                deviceId: {
                    exact: selectedDeviceId
                }
            }
        };
        // Simpan ID kamera yang dipilih di localStorage
        localStorage.setItem('selectedCameraId', selectedDeviceId);
        navigator.mediaDevices.getUserMedia(constraints)
            .then((stream) => {
                video.srcObject = stream;
            })
            .catch((err) => {
                console.error('Error accessing the camera: ', err);
            });
    }


    // Fungsi untuk mengganti kamera saat pengguna memilih dari dropdown
    cameraSelect.addEventListener('change', (event) => {
        startStream();
    });

    // Fungsi untuk mengambil gambar
    captureButton.addEventListener('click', () => {
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        context.drawImage(video, 0, 0, video.videoWidth, video.videoHeight);
        const imageDataURL = canvas.toDataURL('image/jpeg');
        // canvas.val(imageDataURL);
        $('.image-data').val(imageDataURL);
        document.getElementById('image-view').innerHTML = '<img src="' + imageDataURL + '"/>';

    });


    // Fungsi untuk memulai pemindaian
    startScanButton.addEventListener('click', () => {
        const selectedDeviceId = cameraSelect.value;

        const config = {
            inputStream: {
                name: "Live",
                type: "LiveStream",
                target: video,
                constraints: {
                    deviceId: selectedDeviceId,
                    facingMode: "environment",
                },
                area: {
                    top: "0%",
                    right: "0%",
                    left: "0%",
                    bottom: "0%"
                },
            },
            numOfWorkers: navigator.hardwareConcurrency || 2,
            locate: true,
            decoder: {
                readers: [
                    "code_128_reader",
                    "ean_reader",
                    // "ean_8_reader",
                    // "code_39_reader",
                    // "code_39_vin_reader",
                    // "codabar_reader",
                    // "upc_reader",
                    // "upc_e_reader",
                    // "i2of5_reader",
                    // "2of5_reader",
                    // "code_93_reader"
                ],
            },
        };

        Quagga.init(config, (err) => {
            if (err) {
                console.error('Error initializing Quagga: ', err);
                return;
            }
            Quagga.start();
            scannerIsRunning = true;
            outputDiv.innerText = 'Scanning...';
        });
    });

    // Fungsi untuk menghentikan pemindaian
    stopScanButton.addEventListener('click', () => {
        Quagga.stop();
        scannerIsRunning = false;
        outputDiv.innerText = 'Scanner stopped.';
    });

    // Memantau hasil pemindaian
    Quagga.onDetected((result) => {
        if (scannerIsRunning) {
            txtInputOrderId.value = `${result.codeResult.code}`;
        }
    });
</script> -->
@endsection