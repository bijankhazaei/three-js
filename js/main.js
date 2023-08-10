import * as THREE from 'three';
import { GLTFLoader } from 'three/addons/loaders/GLTFLoader.js';

const scene = new THREE.Scene();
const camera = new THREE.PerspectiveCamera( 75, window.innerWidth / window.innerHeight, 0.1, 1000 );
const loader = new GLTFLoader();
const renderer = new THREE.WebGLRenderer();
renderer.setSize( window.innerWidth, window.innerHeight );
document.body.appendChild( renderer.domElement );


loader.load('cloth_base_mesh/scene.gltf', function (gltf) {
	scene.add(gltf.scene)

	camera.position.z = 5;
	renderer.render( scene, camera );
} , undefined, function (err) {
	console.log(err)
})
