
// Camera
var cameras = new Array(); //create empty array to later insert available devices
navigator.mediaDevices.enumerateDevices() // get the available devices found in the machine
    .then(function (devices) {
        devices.forEach(function (device) {
            var i = 0;
            if (device.kind === "videoinput") { //filter video devices only
                cameras[i] = device.deviceId; // save the camera id's in the camera array
                i++;
            }
        });
        console.log(cameras[i]);
        console.log('ttet'); 
    })


Webcam.set(
    'constraits',
    {
        deviceId:{exact:"environment"},
        width: 900,
        height: 700,
        image_format: 'jpeg',
        jpeg_quality: 90,
    });

Webcam.attach('#my_camera');
function take_snapshot() {
    Webcam.snap(
        function (data_uri) {
            //menyimpan data sementara hasil foto
            $('.image-tag').val(data_uri);
            //menampilkan hasil
            document.getElementById('results').innerHTML = '<img src="' + data_uri + '"/>';
        });
}

