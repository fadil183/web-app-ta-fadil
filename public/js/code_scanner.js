//code scanner

var inputElement = document.getElementById("order_id");

function onScanSuccess(decodedText, decodedResult) {
  console.log(`Code scanned = ${decodedText}`, decodedResult);
  inputElement.value = `${decodedText}`;
  html5QrcodeScanner.clear();
  document.getElementById('btnStartScanner').style.display = 'block';

}


  let html5QrcodeScanner = new Html5QrcodeScanner(
    "qr-reader",
    {
      fps: 15,
      qrbox: { width: 600, height: 300 },
      disableFlip: true,
      rememberLastUsedCamera: true,
    },
  /* verbose= */ true);
 function btnScan(){
  html5QrcodeScanner.render(onScanSuccess);
  document.getElementById('btnStartScanner').style.display = 'none';
}

document.getElementById('btnStartScanner').onclick=btnScan;


