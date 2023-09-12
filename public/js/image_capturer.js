
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
    {
        video: true,
        width: 900,
        height: 700,
        image_format: 'jpeg',
        jpeg_quality: 90,
        constraits:{
            video: { facingMode: "user" }
        }
    });

Webcam.attach('#my_camera');
function take_snapshot() {
    Webcam.snap(
        function (data_uri) {
            $('.image-tag').val(data_uri);
            document.getElementById('results').innerHTML = '<img src="' + data_uri + '"/>';
        });
}