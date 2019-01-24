<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<script type="text/javascript" src="https://code.jquery.com/jquery-1.10.2.js"></script>
</head><body>
	<!--
		Ideally these elements aren't created until it's confirmed that the
		client supports video/camera, but for the sake of illustrating the
		elements involved, they are created with markup (not JavaScript)
	-->
	<video id="video" width="640" height="480" autoplay></video>
	<button id="snap" class="sexyButton">Snap Photo</button>
	<canvas id="canvas" width="640" height="480"></canvas>

	<script>

		// Put event listeners into place
		window.addEventListener("DOMContentLoaded", function() {
			// Grab elements, create settings, etc.
            var canvas = document.getElementById('canvas');
            var context = canvas.getContext('2d');
            var video = document.getElementById('video');
            var mediaConfig =  { video: true };
            var errBack = function(e) {
            	console.log('An error has occurred!', e)
            };

			// Put video listeners into place
            if(navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
                navigator.mediaDevices.getUserMedia(mediaConfig).then(function(stream) {
					//video.src = window.URL.createObjectURL(stream);
					video.srcObject = stream;
                    video.play();
                });
            }

            /* Legacy code below! */
            else if(navigator.getUserMedia) { // Standard
				navigator.getUserMedia(mediaConfig, function(stream) {
					video.src = stream;
					video.play();
				}, errBack);
			} else if(navigator.webkitGetUserMedia) { // WebKit-prefixed
				navigator.webkitGetUserMedia(mediaConfig, function(stream){
					video.src = window.webkitURL.createObjectURL(stream);
					video.play();
				}, errBack);
			} else if(navigator.mozGetUserMedia) { // Mozilla-prefixed
				navigator.mozGetUserMedia(mediaConfig, function(stream){
					video.src = window.URL.createObjectURL(stream);
					video.play();
				}, errBack);
			}

			// Trigger photo take
			document.getElementById('snap').addEventListener('click', function() {
				context.drawImage(video, 0, 0, 640, 480);
			});
		}, false);

	</script>
<button id="bt_upload">Upload</button>
 
<script>
  $(document).ready(function() {    
                                
    $("#bt_upload").click(function() {
      var canvas = document.getElementById('canvas');
      var dataURL = canvas.toDataURL();
      $.ajax({
         type: "POST", 
         url: "upload_data.php", 
         data: { img: dataURL }      
      }).done(function(msg){ 
         alert(msg); 
      });
    });
                                
  });   
   
</script>
</body></html>