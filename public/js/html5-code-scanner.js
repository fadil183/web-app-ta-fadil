//code scanner
var inputElement = document.getElementById("order_id");
function onScanSuccess(decodedText, decodedResult) {
    console.log(`Code scanned = ${decodedText}`, decodedResult);
    inputElement.value=`${decodedText}`;
    html5QrcodeScanner.clear();
}

var html5QrcodeScanner = new Html5QrcodeScanner(
    "qr-reader", { fps: 10, qrbox : { width: 350, height: 150 } });
    html5QrcodeScanner.render(onScanSuccess);

//webcam
Webcam.set({
    width: 490,
    height: 350,
    image_format: 'jpeg',
    jpeg_quality: 90
});

Webcam.attach( '#my_camera' );

function take_snapshot() {
    Webcam.snap( function(data_uri) {
        $(".image-tag").val(data_uri);
        document.getElementById('results').innerHTML = '<img src="'+data_uri+'"/>';
    } );
}

