var container;
var camera, scene, renderer;
var targetRotation = 0;
var targetRotationOnMouseDown = 0;
var mouseX = 0;
var mouseXOnMouseDown = 0;
var parent, glowParent;
var windowHalfX = window.innerWidth / 2;
var windowHalfY = window.innerHeight / 2;
var composer;
var blackMaterial, glowMaterial;
var dataFromDB;
var controls;
var particles;
var analysisStarted = true;
var musetext;

//Glow
var glowscene, glowcomposer, glowcamera;

init();		
animate();

//Initializing function
function init() {
	var linematerial;
	var cube;
	var particle;
	var cubeGeometry;
	var xgeometry, xline, ygeometry, yline, ygeometry, yline;

	//Checking for WebGL support on Browser
	if ( ! Detector.webgl ) Detector.addGetWebGLMessage();

	container = document.createElement( 'div' );
	//container = document.getElementById('cubescene');
	document.body.appendChild( container );

	camera = new THREE.PerspectiveCamera( 50, window.innerWidth / window.innerHeight, 1, 1000 );
	camera.position.set( 0, 0, 500 );
	
	glowcamera = new THREE.PerspectiveCamera( 50, window.innerWidth / window.innerHeight, 1, 1000 );
	glowcamera.position.set( 0, 50, 500 );

	//MAIN SCENE
	scene = new THREE.Scene();
	scene.fog = new THREE.Fog( 0x140c0c, 350, 1700 );
	
	// GLOW SCENE
	glowscene = new THREE.Scene();
	glowscene.add( new THREE.AmbientLight( 0xffffff ) );
	
	//LIGHTS
	var dirLight = new THREE.DirectionalLight( 0xffffff, 0.4 );
	dirLight.position.set( -150, -150, 150 ).normalize();
	scene.add(dirLight);
	var dirLight2 = new THREE.DirectionalLight( 0xffffff, 0.4 );
	dirLight2.position.set( 150, -150, 150 ).normalize();
	scene.add(dirLight2);
	var dirLight3 = new THREE.DirectionalLight( 0xffffff, 0.4 );
	dirLight3.position.set( -150, 150, 150 ).normalize();
	scene.add(dirLight3);
	var dirLight4 = new THREE.DirectionalLight( 0xffffff, 0.4 );
	dirLight4.position.set( 150, 150, 150 ).normalize();
	scene.add(dirLight4);

	//**************************************************************************************

	cubeGeometry = new THREE.CubeGeometry( 200, 200, 200, 2, 2, 2 );
	
	var cubeMesh = new THREE.MeshLambertMaterial({color: 0xffffff, shading: THREE.FlatShading, transparent: true, vertexColors:THREE.FaceColors});

	var face;
	var colorindices = 
	[
		'0xff0000', //--(Sensory 0xff0000)--Orange - physical effort
		'0x00ff00', //--(Thinking 0x00ff00)-- Blue - mental effort 
		'0x0000ff',  //-- (Mental Effort 0x0000ff)-- Red - Direct Sensory Experience 
		'0xff8000', //--(Physical Effort 0xff8000)-- Green - Thinking 
		'0xb200b2', //Purple - Beauty
		'0xffff00', //Yellow - utility
	];
	var colorIndex = 0;
	for (var i = 0; i < cubeGeometry.faces.length; i++) {
			face = cubeGeometry.faces[i];
		if(i%4 == 0) {
			color = new THREE.Color( 0xffffff);
			color.setHex( colorindices[colorIndex]  );
			colorIndex++;
		}
			face.color = color;
	}
	cubeGeometry.colorsNeedUpdate = true;
	cube = new THREE.Mesh( cubeGeometry, cubeMesh ); 
	cubeMesh.opacity=0.5;
	
	parent = new THREE.Object3D();
	parent.add(cube);
	scene.add( parent );

	//Drawing the three axes. This may be deleted later based on the requirement
	linematerial = new THREE.LineBasicMaterial({linewidth: 10,
        color: 0x00ccff,});
    ylinegeometry = new THREE.Geometry();
    ylinegeometry.vertices.push(new THREE.Vector3(0, 100, 0));
   	ylinegeometry.vertices.push(new THREE.Vector3(0, -100, 0));
	xlinegeometry = new THREE.Geometry();
   	xlinegeometry.vertices.push(new THREE.Vector3(100,0, 0));
   	xlinegeometry.vertices.push(new THREE.Vector3(-100,0, 0));
	zlinegeometry = new THREE.Geometry();
   	zlinegeometry.vertices.push(new THREE.Vector3(0, 0, 100));
   	zlinegeometry.vertices.push(new THREE.Vector3(0, 0, -100));
	yline = new THREE.Line(ylinegeometry, linematerial);
	xline = new THREE.Line(xlinegeometry, linematerial);
	zline = new THREE.Line(zlinegeometry, linematerial);
	parent.add (yline);
	parent.add (xline);
	parent.add (zline);

	//----------------------------------------------------------------------------
	//Adding text to vertices
	//DIRECT EXPERIENCE TEXT
	var dexptextGeometry = new THREE.TextGeometry("Direct Experience", {
					size: 7,
					height: 2,
					curveSegments: 4,
					font: "optimer",
					weight: "bold",
					style: "normal",
	});
	var dexptextmat = new THREE.MeshNormalMaterial({color: 0xf0f0f0});
	var dexptext = new THREE.Mesh(dexptextGeometry, dexptextmat);
	dexptext.position.x=105;//-40;
	dexptext.position.y=0;//105;
	dexptext.position.z=0;
	parent.add( dexptext );

	//THINKING Text
	var thinktextGeometry = new THREE.TextGeometry("Thinking", {
					size: 7,
					height: 2,
					curveSegments: 4,
					font: "optimer",
					weight: "bold",
					style: "normal",
	});
	var thinktextmat = new THREE.MeshNormalMaterial({color: 0x0000ff});
	var thinktext = new THREE.Mesh(thinktextGeometry, thinktextmat);
	thinktext.position.x=-145;//-20;
	thinktext.position.y=0;//-108;
	thinktext.position.z=0;
	parent.add( thinktext );
	
	//UTILITY
	var utilitytextGeometry = new THREE.TextGeometry("Utility", {
					size: 7,
					height: 2,
					curveSegments: 4,
					font: "optimer",
					weight: "bold",
					style: "normal",
	});
	var utilitytextmat = new THREE.MeshNormalMaterial({color: 0x0000ff});
	var utilitytext = new THREE.Mesh(utilitytextGeometry, utilitytextmat);
	utilitytext.position.x=-15;
	utilitytext.position.y=0;
	utilitytext.position.z=-105;
	parent.add( utilitytext );

	//NON UTILITY
	var nonutilitytextGeometry = new THREE.TextGeometry("Non Utility", {
					size: 7,
					height: 2,
					curveSegments: 4,
					font: "optimer",
					weight: "bold",
					style: "normal",
	});
	var nonutilitytextmat = new THREE.MeshNormalMaterial({color: 0x0000ff});
	var nonutilitytext = new THREE.Mesh(nonutilitytextGeometry, nonutilitytextmat);
	nonutilitytext.position.x=-25;
	nonutilitytext.position.y=0;
	nonutilitytext.position.z=105;
	parent.add( nonutilitytext );
	
	//Mental Prowess
	var mentaltextGeometry = new THREE.TextGeometry("Mental Prowess", {
					size: 7,
					height: 2,
					curveSegments: 4,
					font: "optimer",
					weight: "bold",
					style: "normal",
	});
	var mentaltextmat = new THREE.MeshNormalMaterial({color: 0x0000ff});
	var mentaltext = new THREE.Mesh(mentaltextGeometry, mentaltextmat);
	mentaltext.position.x=-32;//-170;
	mentaltext.position.y=105;//0;
	mentaltext.position.z=0;
	parent.add( mentaltext );

	//Physical Prowess
	var physicaltextGeometry = new THREE.TextGeometry("Physical Prowess", {
					size: 7,
					height: 2,
					curveSegments: 4,
					font: "optimer",
					weight: "bold",
					style: "normal",
	});
	var physicaltextmat = new THREE.MeshNormalMaterial({color: 0x000000});
	var physicaltext = new THREE.Mesh(physicaltextGeometry, physicaltextmat);
	physicaltext.position.x=-35;//105;
	physicaltext.position.y=-108;//0;
	physicaltext.position.z=0;
	parent.add( physicaltext );
//-----------------------------------------------------------------------------------

	//Cloning elements
	blackMaterial = new THREE.MeshBasicMaterial( {color: 0x000000, transparent: true} ); 
	glowMaterial = new THREE.MeshBasicMaterial( {color: 0xFFFFFF, transparent: true} ); 
	glowParent = new THREE.Object3D();

	//User Result based on his answers
	userResult();
	
//****************RENDERING*****************
	renderer = new THREE.WebGLRenderer({antialias:true});
	renderer.autoClear = false;
	renderer.setSize(window.innerWidth, window.innerHeight); //window.innerWidth*4/5, window.innerHeight*9/10 );
	renderer.setClearColor( scene.fog.color, 1 );
	container.appendChild( renderer.domElement );

	var renderTargetParameters = { minFilter: THREE.LinearFilter, magFilter: THREE.LinearFilter, format: THREE.RGBFormat, stencilBuffer: false };
	var renderTarget = new THREE.WebGLRenderTarget( window.innerWidth, window.innerHeight, renderTargetParameters );

	//GLOW Rendering
	var renderModelGlow = new THREE.RenderPass( glowscene, camera );
	glowcomposer = new THREE.EffectComposer( renderer, renderTarget );
	var effectHorizBlur = new THREE.ShaderPass( THREE.HorizontalBlurShader );
	var effectVertiBlur = new THREE.ShaderPass( THREE.VerticalBlurShader );
	effectHorizBlur.uniforms[ "h" ].value = 2 / window.innerWidth;
	effectVertiBlur.uniforms[ "v" ].value = 2 / window.innerHeight;
	glowcomposer.addPass( renderModelGlow );
	glowcomposer.addPass( effectHorizBlur );
	glowcomposer.addPass( effectVertiBlur );
	
	//Base Rendering
	composer = new THREE.EffectComposer( renderer, renderTarget );

	var renderBaseModel = new THREE.RenderPass( scene, camera );
	composer.addPass( renderBaseModel );

	var effectBlend = new THREE.ShaderPass( THREE.AdditiveBlendShader, "tDiffuse1" );
	effectBlend.uniforms[ 'tDiffuse2' ].value = glowcomposer.renderTarget2;
	effectBlend.renderToScreen = true;
	composer.addPass( effectBlend );

	//Event handlers
	document.onkeydown = handleKeydown;
	//document.addEventListener( 'mousedown', onDocumentMouseDown, false );
	document.addEventListener( 'touchstart', onDocumentTouchStart, false );
	document.addEventListener( 'touchmove', onDocumentTouchMove, false );
	controls = createControls(camera);
	//Window event
	window.addEventListener( 'resize', onWindowResize, false );
}

//Getting MUSE
function getMuse(x, y, z){
	var muse="";
	if(x<=0 && y<=0 && z<=0){ //3
		muse="ROSIE BEAVERSTAR";
	}else if(x<=0 && y<=0 && z>0){ //7
		muse="BRUTA KOG";
	}else if(x<=0 && y>0 && z>0){ //8
		muse="HYPATIA KOG";
	}else if(x<=0 && y>0 && z<=0){ //4
		muse="POLLY TEKNICA";
	}else if(x>0 && y<=0 && z<=0){ //1
		muse="FORTUNA AROUSA";
	}else if(x>0 && y>0 && z<=0){ //2
		muse="GAIA USENSE";
	}else if(x>0 && y>0 && z>0){ //6
		muse="COCO COMPLEXIA";
	}else if(x>0 && y<=0 && z>0){ //5
		muse="MONICA WILDE";
	}
	musetext = "From your decision, this aesthetic object was inspired primarily by the Muse: "+muse;
}

//Adding User Result
function userResult(){

//User Point based on the survey results
	var spheremat = new THREE.MeshPhongMaterial({ambient: 0xffffff, color: 0xFFFFFF, shading: THREE.SmoothShading});
	var sphere = new THREE.Mesh(new THREE.SphereGeometry(4, 4, 4),  spheremat);
    sphere.overdraw = true;
	answer_X=100-answer_X;
	if(answer_X < 50){ //Normalizing for the cube
		if(answer_X != 0){
			answer_X=-(answer_X*2);
		}else{
			answer_X=-100;
		}
	}
	else{
		answer_X=(answer_X-50)*2;
	}
	answer_Y=100-answer_Y;
	if(answer_Y < 50){ //Normalizing for the cube
		if(answer_Y != 0){
			answer_Y=-((50-answer_Y)*2);
		}else{
			answer_Y=-100;
		}
	}
	else{
		answer_Y=(answer_Y-50)*2;
	}
	
	if(answer_Z < 50){ //Normalizing for the cube
		if(answer_Z != 0){
			answer_Z=-(answer_Z*2);
		}else{
			answer_Z=-100;
		}
	}
	else{
		answer_Z=(answer_Z-50)*2;
	}
	sphere.position.x = answer_Z;
	sphere.position.y = answer_Y;
	sphere.position.z = answer_X;
	parent.add(sphere);
	
	getMuse(answer_Z, answer_Y, answer_X); //Adding muse text
	
	var glowuserP= new THREE.Object3D();
	var glowsphere = new THREE.Mesh(new THREE.SphereGeometry(4, 4, 4),  glowMaterial);
    glowsphere.overdraw = true;
	glowuserP.add(glowsphere);
	var glowuserLight = new THREE.PointLight( 0xFFFFFF );
	glowuserP.position.x = answer_Z;
	glowuserP.position.y = answer_Y;
	glowuserP.position.z = answer_X;
	glowuserP.add(glowuserLight);
	glowParent.add(glowuserP);

	glowscene.add(glowParent);
	
}

//Function for mapping different objects from the object table
function getDemographicdata(){
		$.ajax({
			url: 'getdemographicdata.php',
			type: 'POST',
			dataType: 'json',
			success: function(data){
					dataFromDB = data;
					showData();
				},
			error: function(xhr, ajaxOptions, thrownError){
				alert("Error "+xhr.responseText);
				}
		});
}

function getUserAestheticdata(){
		$.ajax({
			url: 'getuseraestheticdata.php',
			type: 'POST',
			dataType: 'json',
			success: function(data){
					dataFromDB = data;
					showData();
				},
			error: function(xhr, ajaxOptions, thrownError){
				alert("Error "+xhr.responseText);
				}
		});
}

function getUserCumulativedata(){
		$.ajax({
			url: 'getusercumulativedata.php',
			type: 'POST',
			data: { 'email':username },
			dataType: 'json',
			success: function(data){
					dataFromDB = data;
					showData();
				},
			error: function(xhr, ajaxOptions, thrownError){
				alert("Error "+xhr.responseText);
				}
		});
}

function showAlldata(){
		$.ajax({
			url: 'getalldata.php',
			type: 'POST',
			dataType: 'json',
			success: function(data){
					dataFromDB = data;
					showData();
				},
			error: function(xhr, ajaxOptions, thrownError){
				alert("Error "+xhr.responseText);
				}
		});
}

function getObjects(){
		$.ajax({
			url: 'getobjectcoor.php',
			type: 'POST',
			dataType: 'json',
			success: function(data){
					dataFromDB = data;
					showData();
				},
			error: function(xhr, ajaxOptions, thrownError){
				alert("Error "+xhr.responseText);
				}
		});
}
function showData(){
		var particleGeometry = new THREE.Geometry();
		var objectColors = [];
		var i = 0;
		for ( i = 0; i < dataFromDB.length; i++ ) {
			var cubeCoor = dataFromDB[i];
			var vertex = new THREE.Vector3();
			if(cubeCoor[3]){
				vertex.x = cubeCoor[1];
				vertex.y = cubeCoor[2];
				vertex.z = cubeCoor[3];
			}else{
				vertex.x = cubeCoor[0];
				vertex.y = cubeCoor[1];
				vertex.z = cubeCoor[2];
			}
			//Normalizing as per cube
			vertex.x=100-vertex.x;
			if(vertex.x < 50){ //Normalizing for the cube
				if(vertex.x != 0){
					vertex.x=-(vertex.x*2);
				}else{
					vertex.x=-100;
				}
			}
			else{
				vertex.x=((vertex.x-50)*2);
			}
			vertex.y=100-vertex.y;
			if(vertex.y < 50){ //Normalizing for the cube
				if(vertex.y != 0){
					vertex.y=-((50-vertex.y)*2);
				}else{
					vertex.y=-100;
				}
			}
			else{
				vertex.y=((vertex.y-50)*2);
			}
			if(vertex.z < 50){ //Normalizing for the cube
				if(vertex.z != 0){
					vertex.z=-(vertex.z*2);
				}else{
					vertex.z=-100;
				}
			}
			else{
				vertex.z=(vertex.z-50)*2;
			}
			
			var temp=vertex.x;
			vertex.x=vertex.z;
			vertex.z=temp;
			
			//Adding Country Text
			if(cubeCoor[3]){
				var specifierGeometry = new THREE.TextGeometry(cubeCoor[0], {
								size: 2,
								height: 1,
								curveSegments: 5,
								font: "optimer",
								weight: "normal",
								style: "normal",
				});
				var specifiertextmat = new THREE.MeshBasicMaterial({color: 0xffff00});
				var specifiertext = new THREE.Mesh(specifierGeometry, specifiertextmat);
				specifiertext.position.x=vertex.x+2;
				specifiertext.position.y=vertex.y+2;
				specifiertext.position.z=vertex.z+2;
				parent.add( specifiertext );
			}
			particleGeometry.vertices.push( vertex );
		}
		
		for( var i = 0; i < particleGeometry.vertices.length; i++ ) {
			objectColors[i] = new THREE.Color();
			objectColors[i].setHSL( Math.random(), 1.0, 0.5 );
		}
		particleGeometry.colors = objectColors;
		
		particles = new THREE.ParticleSystem( particleGeometry, new THREE.ParticleBasicMaterial({color: Math.random()*0xFFFFFF, size:7, vertexColors:true}));
		parent.add(particles);
		
		if(analysisStarted){
			analysisStarted = false;
		}
		render(); //Rendering again
}

//Function for resetting the scene
function resetScene(){
	var obj, i, objchild;
	for ( i = scene.children.length - 1; i >= 0 ; i -- ) {
		obj = scene.children[ i ];
		if (obj !== camera) {
			if ( obj instanceof THREE.Object3D ) {
				if(obj===parent){
					for ( i = obj.children.length - 1; i >= 0 ; i -- ) {
						objchild = obj.children[ i ];
						if ( objchild instanceof THREE.ParticleSystem ) {
							parent.remove(objchild);
							scene.remove(objchild);
						}
						if ( objchild.geometry instanceof THREE.TextGeometry ) 
						{
							if(objchild.material instanceof THREE.MeshBasicMaterial){
								if((objchild.material.color.r == 1) && (objchild.material.color.g == 1)){
									parent.remove(objchild);
									scene.remove(objchild);
								}
							}
						}
					}
				}
			}
		}
	}
	for ( i = glowscene.children.length - 1; i >= 0 ; i -- ) {
		obj = glowscene.children[ i ];
		if (obj !== camera) {
			if ( obj instanceof THREE.Object3D ) {
				if(obj===parent){
					for ( i = obj.children.length - 1; i >= 0 ; i -- ) {
						objchild = obj.children[ i ];
						if ( objchild instanceof THREE.ParticleSystem ) {
							parent.remove(objchild);
							glowscene.remove(objchild);
						}
					}
				}
			}
		}
	}
	render();
}

// onKeyDown event handler
function handleKeydown(e) {
    var kCode = ((e.which) || (e.keyCode));
    switch (kCode) {
        case 37: targetRotation += 0.025;//parent.rotation.y += 0.0175;
		break; // Left key
        case 38: parent.rotation.x += 0.025;
				 glowParent.rotation.x += 0.025;
		break; // Up key
        case 39: targetRotation -= 0.025;//parent.rotation.y -= 0.0175;
		break; // Right key
        case 40: parent.rotation.x -= 0.025;
				 glowParent.rotation.x -= 0.025;
		break; // Down key
    }
	render();
}

//Window resize function
function onWindowResize() {
	camera.aspect = window.innerWidth / window.innerHeight;
	camera.updateProjectionMatrix();
	renderer.setSize( window.innerWidth*4/5, window.innerHeight );
	controls.handleResize();
	render();
}

/*function onDocumentMouseDown( event ) {
	event.preventDefault();
	document.addEventListener( 'mousemove', onDocumentMouseMove, false );
	document.addEventListener( 'mouseup', onDocumentMouseUp, false );
	document.addEventListener( 'mouseout', onDocumentMouseOut, false );

	mouseXOnMouseDown = event.clientX - windowHalfX;
	targetRotationOnMouseDown = targetRotation;
}

function onDocumentMouseMove( event ) {
	mouseX = event.clientX - windowHalfX;
	targetRotation = targetRotationOnMouseDown + ( mouseX - mouseXOnMouseDown ) * 0.02;
}

function onDocumentMouseUp( event ) {
	document.removeEventListener( 'mousemove', onDocumentMouseMove, false );
	document.removeEventListener( 'mouseup', onDocumentMouseUp, false );
	document.removeEventListener( 'mouseout', onDocumentMouseOut, false );
}

function onDocumentMouseOut( event ) {
	document.removeEventListener( 'mousemove', onDocumentMouseMove, false );
	document.removeEventListener( 'mouseup', onDocumentMouseUp, false );
	document.removeEventListener( 'mouseout', onDocumentMouseOut, false );
}*/

function onDocumentTouchStart( event ) {
	if ( event.touches.length == 1 ) {
		event.preventDefault();
	mouseXOnMouseDown = event.touches[ 0 ].pageX - windowHalfX;
	targetRotationOnMouseDown = targetRotation;
	}
}

function onDocumentTouchMove( event ) {
	if ( event.touches.length == 1 ) {
		event.preventDefault();
		mouseX = event.touches[ 0 ].pageX - windowHalfX;
		targetRotation = targetRotationOnMouseDown + ( mouseX - mouseXOnMouseDown ) * 0.05;
	}
}

function animate() {
	requestAnimationFrame( animate );
	controls.update();
	render();
}

function createControls(camera){
    
    controls = new THREE.TrackballControls(camera);
    
    controls.zoomSpeed = 1.2;
    
    controls.noZoom = false;
    controls.noPan = false;
	controls.noRotate = false;
	controls.noRoll = false;
    
    controls.staticMoving = true;
    controls.dynamicDampingFactor = 0.3;
    
    controls.keys = [ 65, 83, 68 ];

    return controls;
}

function zoomfn (inOut){
	if(inOut){
		if(camera.position.z>0){
			camera.position.z-=5;
		}
	}else{
		if(camera.position.z<=500){
			camera.position.z+=5;
		}
	}
	controls.update();
	camera.updateProjectionMatrix();
	render();
}

//Rendering function
function render() {
	parent.rotation.y += ( targetRotation - parent.rotation.y ) * 0.05;
	glowParent.rotation.y += ( targetRotation - glowParent.rotation.y ) * 0.05;
	renderer.clear();
    camera.updateMatrixWorld();
//	renderer.render( scene, camera );
	glowcomposer.render();
	composer.render();
}

$(document).ready(function() {
	$("#museopted").text(musetext); //Setting muse text
	
	$("#demographybtn").click(function() {
		if(!analysisStarted){
			resetScene();
		}
		getDemographicdata();
	});
	$("#aestheticsbtn").click(function() {
		if(!analysisStarted){
			resetScene();
		}
		getUserAestheticdata();
	});
	$("#usersbtn").click(function() {
		if(!analysisStarted){
			resetScene();
		}
		getUserCumulativedata();
	});
	$("#objectbtn").click(function() {
		if(!analysisStarted){
			resetScene();
		}
		getObjects();
	});
	$("#allbtn").click(function() {
		if(!analysisStarted){
			resetScene();
		}
		showAlldata();
	});
	$("#zoomin").click(function(event) {
		event.preventDefault();
		zoomfn(true);
	});
	$("#zoomout").click(function(event) {
		event.preventDefault();
		zoomfn(false);
	});
});