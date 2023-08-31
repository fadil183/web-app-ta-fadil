//code scanner
var inputElement = document.getElementById("order_id");
function onScanSuccess(decodedText, decodedResult) {
    console.log(`Code scanned = ${decodedText}`, decodedResult);
    inputElement.value=`${decodedText}`;
    html5QrcodeScanner.clear();
}

let html5QrcodeScanner = new Html5QrcodeScanner(
    "qr-reader",
    {
      fps: 5,
      qrbox:{width: 600, height: 200},
      disableFlip: true
    },
    /* verbose= */ true);
  html5QrcodeScanner.render(onScanSuccess);

