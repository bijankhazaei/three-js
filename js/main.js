import * as THREE from 'three';

import Stats from 'three/addons/libs/stats.module.js';

import { OrbitControls } from 'three/addons/controls/OrbitControls.js';
import { RoomEnvironment } from 'three/addons/environments/RoomEnvironment.js';

import { GLTFLoader } from 'three/addons/loaders/GLTFLoader.js';
import { DRACOLoader } from 'three/addons/loaders/DRACOLoader.js';

let mixer;

const clock = new THREE.Clock();
const container = document.getElementById( 'container' );

const stats = new Stats();
container.appendChild( stats.dom );

const renderer = new THREE.WebGLRenderer( { antialias: true } );
renderer.setPixelRatio( window.devicePixelRatio );
renderer.setSize( window.innerWidth, window.innerHeight );
container.appendChild( renderer.domElement );

const pmremGenerator = new THREE.PMREMGenerator( renderer );

const scene = new THREE.Scene();
scene.background = new THREE.Color( 0xbfe3dd );
scene.environment = pmremGenerator.fromScene( new RoomEnvironment( renderer ), 0.04 ).texture;

const camera = new THREE.PerspectiveCamera( 40, window.innerWidth / window.innerHeight, 1, 100 );
camera.position.set( 4, 4, 4 );

const controls = new OrbitControls( camera, renderer.domElement );
controls.target.set( 0, 1, 1 );
controls.update();
controls.enablePan = false;
controls.enableDamping = true;

const dracoLoader = new DRACOLoader();

const loader = new GLTFLoader();
loader.setDRACOLoader( dracoLoader );
loader.load( 'bodysuit/scene.gltf', function ( gltf ) {

	const model = gltf.scene;

	model.traverse((child) => {
		if(child.isMesh) {
			console.log(child.material.map);
			if(child.material.map) {
				const myTexture = new THREE.TextureLoader().load('cloth_base_mesh/textures/preview.png');
				child.material.map = myTexture;
				child.material.map.needsUpdate = true;
			}
		}
	})

	model.position.set( 0, 0, 0);
	model.scale.set( 2, 2, 2 );
	scene.add( model );

	mixer = new THREE.AnimationMixer( model );

	animate();

}, undefined, function ( e ) {

	console.error( e );

} );


window.onresize = function () {

	camera.aspect = window.innerWidth / window.innerHeight;
	camera.updateProjectionMatrix();

	renderer.setSize( window.innerWidth, window.innerHeight );

};


function animate() {

	requestAnimationFrame( animate );

	const delta = clock.getDelta();

	mixer.update( delta );

	controls.update();

	stats.update();

	renderer.render( scene, camera );
}