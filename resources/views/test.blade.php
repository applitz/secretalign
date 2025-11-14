<!DOCTYPE html>
<html>
<head>
<title>NEMO WORKSPACE PORTAL</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script type="text/javascript">
function authenticate(auth, url) {
var iframe = document.getElementById('nemoPortal');
iframe.contentWindow.postMessage(auth, url);
}
window.onmessage = function (event) {
console.log(event.data);
}
</script>
</head>
<body style="overflow: hidden;">
<!--It is mandatory to have the 'Simse' auth header before load the url into the
iframe-->
<iframe
onload="authenticate('{{$slime}}', 'https://downloads-alsecret.nemocloud-services.com/DownloadUploadService/nemobox/app/workspace/embedded/documents-patient/default?patientId=54edc18c-703f-4f2a-9245-983587d17f55')"
id="nemoPortal" style="position: absolute; width: 100%; height: 100%; border:
none"
src="https://downloads-alsecret.nemocloud-services.com/DownloadUploadService/nemobox/app/workspace/embedded/documents-patient/default?patientId=54edc18c-703f-4f2a-9245-983587d17f55">
</iframe>
</body>
</html>
