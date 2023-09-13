//code scanner

var inputElement = document.getElementById("order_id");

function onScanSuccess(decodedText, decodedResult) {
  console.log(`Code scanned = ${decodedText}`, decodedResult);
  inputElement.value = `${decodedText}`;
  html5QrcodeScanner.clear();
}

function startScan() {
  let html5QrcodeScanner = new Html5QrcodeScanner(
    "qr-reader",
    {
      fps: 15,
      qrbox: { width: 500, height: 200 },
      disableFlip: true,
      rememberLastUsedCamera: true,
    },
  /* verbose= */ true);
  html5QrcodeScanner.render(onScanSuccess);
}
