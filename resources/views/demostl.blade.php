<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>3D STL & PTS Viewer (with Length Measurement)</title>
  <style>
    body { margin: 0; background: #111; color: white; font-family: sans-serif; overflow: hidden; }
    #viewer { width: 100vw; height: 85vh; display: block; }
    .controls { padding: 10px; text-align: center; background: #222; }
    input, button { margin: 10px; color: white; background: #333; border: 1px solid #555; padding: 6px 12px; border-radius: 5px; cursor: pointer; }
    input:hover, button:hover { background: #444; }
    #info { text-align: center; font-size: 18px; margin-top: 10px; }
  </style>
</head>
<body>

<div class="controls">
  <label>Upload STL: <input type="file" id="stlFile" accept=".stl"></label>
  <label>Upload PTS: <input type="file" id="ptsFile" accept=".pts"></label>
  <button id="clearBtn">Clear Points</button>
</div>

<canvas id="viewer"></canvas>
<div id="info">Total Curve Length: <span id="lengthDisplay">0.00</span> units</div>

<!-- ✅ THREE.js libraries -->
<script src="https://cdn.jsdelivr.net/npm/three@0.128.0/build/three.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/controls/OrbitControls.js"></script>
<script src="https://cdn.jsdelivr.net/npm/three@0.128.0/examples/js/loaders/STLLoader.js"></script>

<script>
  let scene, camera, renderer, controls;
  let raycaster, mouse;
  let selectedPoints = [];
  let ptsObjects = [];
  let curveLine = null;

  init();
  animate();

  function init() {
    const canvas = document.getElementById('viewer');
    scene = new THREE.Scene();
    scene.background = new THREE.Color(0x111111);

    camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
    camera.position.set(0, 0, 100);

    renderer = new THREE.WebGLRenderer({ canvas });
    renderer.setSize(window.innerWidth, window.innerHeight * 0.85);

    controls = new THREE.OrbitControls(camera, renderer.domElement);
    controls.enableDamping = true;

    // Lighting
    scene.add(new THREE.AmbientLight(0x404040));
    const dirLight = new THREE.DirectionalLight(0xffffff, 1);
    dirLight.position.set(1, 1, 1);
    scene.add(dirLight);

    raycaster = new THREE.Raycaster();
    mouse = new THREE.Vector2();

    renderer.domElement.addEventListener('click', onMouseClick, false);
    document.getElementById('clearBtn').addEventListener('click', clearSelection);
  }

  function animate() {
    requestAnimationFrame(animate);
    controls.update();
    renderer.render(scene, camera);
  }

  // Load STL
  document.getElementById('stlFile').addEventListener('change', (e) => {
    const file = e.target.files[0];
    if (!file) return;

    const loader = new THREE.STLLoader();
    const reader = new FileReader();

    reader.onload = function (event) {
      const geometry = loader.parse(event.target.result);
      const material = new THREE.MeshStandardMaterial({ color: 0x00ffff });
      const mesh = new THREE.Mesh(geometry, material);
      scene.add(mesh);
    };

    reader.readAsArrayBuffer(file);
  });

  // Load PTS
  document.getElementById('ptsFile').addEventListener('change', (e) => {
    const file = e.target.files[0];
    if (!file) return;

    const reader = new FileReader();
    reader.onload = function (event) {
      const lines = event.target.result.split('\n');
      const points = [];

      for (let line of lines) {
        const [x, y, z] = line.trim().split(/\s+/).map(Number);
        if (!isNaN(x) && !isNaN(y) && !isNaN(z)) {
          points.push(new THREE.Vector3(x, y, z));
        }
      }

      const geometry = new THREE.BufferGeometry().setFromPoints(points);
      const material = new THREE.PointsMaterial({ color: 0xff0000, size: 0.5 });
      const pointCloud = new THREE.Points(geometry, material);
      scene.add(pointCloud);
      ptsObjects.push(pointCloud);
    };

    reader.readAsText(file);
  });

  // Handle mouse click
  function onMouseClick(event) {
    event.preventDefault();
    mouse.x = (event.clientX / window.innerWidth) * 2 - 1;
    mouse.y = -(event.clientY / (window.innerHeight * 0.85)) * 2 + 1;

    raycaster.setFromCamera(mouse, camera);
    if (ptsObjects.length === 0) return;

    const pts = ptsObjects[0];
    const positions = pts.geometry.attributes.position.array;
    const tempVec = new THREE.Vector3();

    let nearestDist = Infinity;
    let nearestPoint = null;

    for (let i = 0; i < positions.length; i += 3) {
      tempVec.set(positions[i], positions[i + 1], positions[i + 2]);
      const dist = raycaster.ray.distanceToPoint(tempVec);
      if (dist < nearestDist) {
        nearestDist = dist;
        nearestPoint = tempVec.clone();
      }
    }

    if (nearestPoint && nearestDist < 3) {
      selectedPoints.push(nearestPoint);

      // Green sphere marker
      const sphereGeom = new THREE.SphereGeometry(0.6, 16, 16);
      const sphereMat = new THREE.MeshBasicMaterial({ color: 0x00ff00 });
      const marker = new THREE.Mesh(sphereGeom, sphereMat);
      marker.position.copy(nearestPoint);
      scene.add(marker);

      if (selectedPoints.length >= 2) {
        drawCurve(selectedPoints);
        updateCurveLength();
      }
    }
  }

  // Draw smooth red dashed curve
  function drawCurve(points) {
    if (curveLine) scene.remove(curveLine);

    const curve = new THREE.CatmullRomCurve3(points);
    const curvePoints = curve.getPoints(200);
    const geometry = new THREE.BufferGeometry().setFromPoints(curvePoints);

    const material = new THREE.LineDashedMaterial({
      color: 0xff0000,
      dashSize: 1,
      gapSize: 0.5
    });

    curveLine = new THREE.Line(geometry, material);
    curveLine.computeLineDistances();
    scene.add(curveLine);
  }

  // Compute total curve length
  function updateCurveLength() {
    if (selectedPoints.length < 2) {
      document.getElementById('lengthDisplay').textContent = "0.00";
      return;
    }

    let totalLength = 0;
    for (let i = 1; i < selectedPoints.length; i++) {
      totalLength += selectedPoints[i - 1].distanceTo(selectedPoints[i]);
    }

    document.getElementById('lengthDisplay').textContent = totalLength.toFixed(2);
  }

  // Clear all points and lines
  function clearSelection() {
    selectedPoints = [];
    if (curveLine) scene.remove(curveLine);
    curveLine = null;

    // Remove green markers
    for (let i = scene.children.length - 1; i >= 0; i--) {
      const obj = scene.children[i];
      if (obj.isMesh && obj.material.color && obj.material.color.getHex() === 0x00ff00) {
        scene.remove(obj);
      }
    }

    document.getElementById('lengthDisplay').textContent = "0.00";
  }

  // Handle window resize
  window.addEventListener('resize', () => {
    camera.aspect = window.innerWidth / (window.innerHeight * 0.85);
    camera.updateProjectionMatrix();
    renderer.setSize(window.innerWidth, window.innerHeight * 0.85);
  });
</script>

</body>
</html>
