<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Three.js STL/PLY Viewer</title>
    <style>
        body { margin: 0; }
        canvas { display: block; }
        #fileInput { position: absolute; top: 10px; left: 10px; z-index: 100; }
    </style>
    <script src="{{ asset('public/assets/three/build/three.js') }}"></script>
    <script type="importmap">
        {
            "imports": {
                "three": "{{asset('public/assets/three/build/three.module.js')}}",
                "OrbitControls": "{{asset('public/assets/three/examples/jsm/controls/OrbitControls.js')}}"
            }
        }
    </script>
</head>
<body>
    <input type="file" id="fileInput" accept=".stl, .ply">
    <script type="module">


        import { STLLoader } from "{{asset('public/assets/three/examples/jsm/loaders/STLLoader.js')}}";
    import { PLYLoader } from "{{asset('public/assets/three/examples/jsm/loaders/PLYLoader.js')}}";
    import { OrbitControls } from '{{asset("public/assets/three/examples/jsm/controls/OrbitControls.js")}}';

    let scene, camera, renderer, controls;

init();
animate();

function init() {
    // Scene
    scene = new THREE.Scene();
    scene.background = new THREE.Color(0xaaaaaa);

    // Camera
   camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
   // camera = new THREE.PerspectiveCamera(10, 1420/764 , 0.1, 1000);
    camera.position.set(0, 0, 5);

    // Renderer
    renderer = new THREE.WebGLRenderer({ antialias: true });
    renderer.setSize(window.innerWidth, window.innerHeight);
    document.body.appendChild(renderer.domElement);

    // Controls
    controls = new OrbitControls(camera, renderer.domElement);
    controls.enableDamping = true;

    // Lighting
    const ambientLight = new THREE.AmbientLight(0xffffff, 0.5);
    scene.add(ambientLight);

    const directionalLight = new THREE.DirectionalLight(0xffffff, 1);
    directionalLight.position.set(1, 1, 1).normalize();
    scene.add(directionalLight);

    // File input event
    document.getElementById('fileInput').addEventListener('change', handleFile);

    // Handle window resize
    window.addEventListener('resize', onWindowResize);
}

function onWindowResize() {
    camera.aspect = window.innerWidth / window.innerHeight;
    camera.updateProjectionMatrix();
    renderer.setSize(window.innerWidth, window.innerHeight);
}

function handleFile(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            const contents = e.target.result;
            const extension = file.name.split('.').pop().toLowerCase();
            let loader;

            // Remove existing mesh
            while (scene.children.length > 2) {
                scene.remove(scene.children[2]);
            }
console.log(contents)
            if (extension === 'stl') {
                loader = new STLLoader();
                const geometry = loader.parse(contents);
                const material = new THREE.MeshStandardMaterial({ color: 0x0055ff });
                const mesh = new THREE.Mesh(geometry, material);
                scene.add(mesh);
            } else if (extension === 'ply') {
                loader = new PLYLoader();
                const geometry = loader.parse(contents);
                geometry.computeVertexNormals();
                const material = new THREE.MeshStandardMaterial({
                    vertexColors: THREE.VertexColors,
                    flatShading: true
                });
                const mesh = new THREE.Mesh(geometry, material);
                scene.add(mesh);
            } else {
                alert('Unsupported file format');
            }
        };

        reader.readAsArrayBuffer(file);
    }
}

function animate() {
    requestAnimationFrame(animate);
    controls.update();
    renderer.render(scene, camera);
}
    </script>
</body>
</html>
