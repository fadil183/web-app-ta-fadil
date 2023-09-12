
//Camera
Webcam.set({
    width: 900,
    height: 700,
    image_format: 'jpeg',
    jpeg_quality: 90,
    facingMode: { exact: 'environment' }
});

Webcam.attach( '#my_camera' );
    function take_snapshot() {
        Webcam.snap( 
            function(data_uri) {
                $('.image-tag').val(data_uri);
                document.getElementById('results').innerHTML = '<img src="'+data_uri+'"/>';
        });
    }