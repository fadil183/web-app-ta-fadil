
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

var selectedCameraId = null;
//sembunyikan video jika camera belum dipilih
video.style.display = "none"
video.style.display = "none";
startScanButton.style.display = "none";
stopScanButton.style.display = "none";
captureButton.style.display = 'none';
document.addEventListener('DOMContentLoaded', function () {

})

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
            // // Cek apakah terdapat ID kamera yang disimpan di localStorage
            // selectedCameraId = localStorage.getItem('selectedCameraId');
            // if (selectedCameraId) {
            //     // cameraSelect.value = selectedCameraId;
            //     // startStream();
            // }
        })
        .catch((err) => {
            console.error('Error enumerating devices: ', err);
        });
}

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


// Panggil fungsi untuk mendapatkan daftar kamera
getCameraList();


function stopStream() {
    video.style.display = 'none';
    captureButton.style.display = 'none';
    // Dapatkan objek stream dari kamera
    const videoStream = video.srcObject;

    // Dapatkan track yang terkait dengan kamera
    const videoTrack = videoStream.getVideoTracks()[0];

    // Hentikan track kamera
    videoTrack.stop();
}


// Fungsi untuk mengambil gambar
captureButton.addEventListener('click', () => {
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    context.drawImage(video, 0, 0, video.videoWidth, video.videoHeight);
    const imageDataURL = canvas.toDataURL('image/jpeg');
    // canvas.val(imageDataURL);
    $('.image-data').val(imageDataURL);
    document.getElementById('image-view').innerHTML = '<img src="' + imageDataURL + '"/>';
    stopStream();
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
        startScanButton.classList.remove('btn-success');
        startScanButton.classList.add('btn-danger');
        startScanButton.disabled = true;
        startScanButton.value='Scanning';
    });
});

// Fungsi untuk menghentikan pemindaian
stopScanButton.addEventListener('click', () => {
    Quagga.stop();
    scannerIsRunning = false;
    // outputDiv.innerText = 'Scanner stopped.';
});

// Memantau hasil pemindaian
Quagga.onDetected((result) => {
    if (scannerIsRunning) {
        txtInputOrderId.value = `${result.codeResult.code}`;
        // stop scan
        Quagga.stop();
        //sembunyikan tombol start scan
        startScanButton.style.display = 'none';
        captureButton.style.display = 'block';

    }
});

// Fungsi untuk mengganti kamera saat pengguna memilih dari dropdown
cameraSelect.addEventListener('change', (event) => {
    video.style.display = 'block';
    startScanButton.style.display = 'block';
    startStream();
    cameraSelect.disabled = true;

});

function startImageCapture() {
    video.style.display = 'block';
    captureButton.style.display = 'block';
    startStream();
}

function stopImageCapture() {
    stopStream();
    video.style.display = 'none';
    captureButton.style.display = 'none';
    captureButton.val('ambil ulang foto');
}