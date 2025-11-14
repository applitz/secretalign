<!-- resources/views/iframe.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Full Screen View</title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }
        iframe {
            width: 100%;
            height: 100%;
            border: none;
        }
    </style>
</head>
<body>
    <iframe id="myIframe" src="<?php echo e($patient->iframe_link); ?>" allowfullscreen></iframe>

    <button id="fullscreenButton" style="position: absolute; top: 10px; right: 10px; z-index: 999;">
        Full Screen
    </button>

    <script>
        document.getElementById('fullscreenButton').addEventListener('click', function () {
            const iframe = document.getElementById('myIframe');
            if (iframe.requestFullscreen) {
                iframe.requestFullscreen();
            } else if (iframe.mozRequestFullScreen) { // Firefox
                iframe.mozRequestFullScreen();
            } else if (iframe.webkitRequestFullscreen) { // Chrome, Safari, and Opera
                iframe.webkitRequestFullscreen();
            } else if (iframe.msRequestFullscreen) { // IE/Edge
                iframe.msRequestFullscreen();
            }
        });
    </script>
</body>
</html>
<?php /**PATH /home/u531876341/domains/secretalign-user.com/public_html/resources/views/patients/case_iframe.blade.php ENDPATH**/ ?>