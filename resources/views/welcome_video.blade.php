<!DOCTYPE html>
<html>
<head>
    <title>Welcome</title>
    <style>
        html, body {
            margin: 0;
            padding: 0;
            overflow: hidden;
            width: 100%;
            height: 100%;
            background-color: black;
        }
        #intro-video {
            width: 100vw;
            height: 100vh;
            object-fit: cover;
            opacity: 0;
            transform: scale(1.05);
            animation: fadeIn 2s ease-in-out forwards;
        }

        @keyframes fadeIn {
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

    </style>
</head>
<body>
    <video id="intro-video" autoplay playsinline>
        <source src="{{ asset('public/assets/intro.mp4') }}" type="video/mp4">
        Your browser does not support the video tag.
    </video>

    <script>
        const video = document.getElementById('intro-video');

        // Set volume to 50%
        video.volume = 0.5;

        // Enable sound after user interaction (required by some browsers)
        window.addEventListener('click', () => {
            video.muted = false;
            video.play();
        });

        // Redirect after 5 seconds or when video ends
        setTimeout(() => {
            window.location.href = "{{ url('/home') }}";  // Change to your target route
        }, 5000);
    </script>
</body>
</html>
