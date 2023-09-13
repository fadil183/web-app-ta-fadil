
const video = document.getElementById('my_camera');
const button = document.getElementById('btnGetCamera');
const select = document.getElementById('select');
const canvas = document.getElementById('canvas');

let currentStream;

button.addEventListener('click', event => {
    const constraints = {
      video: true,
      audio: false
    };
    navigator.mediaDevices
      .getUserMedia(constraints)
      .then(stream => {
        video.srcObject = stream;
      })
      .catch(error => {
        console.error(error);
      });
  });
  
function gotDevices(mediaDevices) {
    select.innerHTML = '';
    select.appendChild(document.createElement('option'));
    let count = 1;
    mediaDevices.forEach(mediaDevice => {
        if (mediaDevice.kind === 'videoinput') {
            const option = document.createElement('option');
            option.value = mediaDevice.deviceId;
            const label = mediaDevice.label || `Camera ${count++}`;
            const textNode = document.createTextNode(label);
            option.appendChild(textNode);
            select.appendChild(option);
        }
    });
}
button.addEventListener('click', event => {
    if (typeof currentStream !== 'undefined') {
      stopMediaTracks(currentStream);
    }
    const videoConstraints = {};
    if (select.value === '') {
      videoConstraints.facingMode = 'environment';
    } else {
      videoConstraints.deviceId = { exact: select.value };
    }
    const constraints = {
      video: videoConstraints,
      audio: false
    };
    navigator.mediaDevices
      .getUserMedia(constraints)
      .then(stream => {
        currentStream = stream;
        video.srcObject = stream;
        return navigator.mediaDevices.enumerateDevices();
      })
      .then(gotDevices)
      .catch(error => {
        console.error(error);
      });
  });
  
  

navigator.mediaDevices.enumerateDevices().then(gotDevices);


function captureImage() {
    canvas.getContext('2d').drawImage(video, 0, 0, canvas.width, canvas.height);
    const imageData = canvas.toDataURL('image/png');
    const image = new Image();
    image.src = imageData;

    // Tambahkan gambar ke dokumen
    $('.image-tag').val(imageData);
    document.getElementById('results').innerHTML = '<img src="' + image + '"/>';
}

