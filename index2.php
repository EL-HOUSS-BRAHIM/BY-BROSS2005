<?php
session_start();
if (isset($_SESSION['userid'])) {
  header("Location: login.php");
}?>
<!DOCTYPE html>


<html class="loading">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">    
    <title>BROSS CHECKER</title>
    <link href="https://fonts.googleapis.com/css?family=Muli:300,300i,400,400i,600,600i,700,700i%7CComfortaa:300,400,700" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="theme-assets/css/vendors.css">
    <link rel="stylesheet" type="text/css" href="theme-assets/css/app-lite.css">
    <link rel="stylesheet" type="text/css" href="theme-assets/css/core/menu/menu-types/vertical-menu.css">
    <link rel="stylesheet" type="text/css" href="theme-assets/css/core/colors/palette-gradient.css">
    	 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    	 <style>
    	 /* Header Styles */
header {
    position: relative;
    background: linear-gradient(to right, #9f78ff, #32cafe); /* Creates a gradient from #CC33FF to #00CCFF */
    color: #99ccff;
    padding: 1rem;
}

header h3 {
    color: #fff;
    position: absolute;
    top: 30px;
    right: 1500px;
    lift: 10px;
    font-size: 25px;
}
@media (max-width: 1000px) { /* styles for screens with width less than 600px */
    header h3 {
        position: relative;
        top: auto;
        right: auto;
    }
}

header .menu-main {
    list-style: none;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

header .menu-main li a {
    color: #fff;
    text-decoration: none;
    padding: 0.5rem;
}

header .menu-member {
    list-style: none;
    display: flex;
    justify-content: flex-end;
    align-items: center;
}

header .menu-member li a {
    color: #fff;
    text-decoration: none;
    padding: 0.5rem;
}
</style>
  </head>
    <body>
<header class="header-main">
    <h3>WELCOME</h3>
    <nav class="header-main-nav">
        <div class="wrapper">
        <ul class="menu-member">
  <?php
    if(isset($_SESSION["userid"])) {
    ?>
      <li><a href="#"><?php echo $_SESSION["useruid"]; ?></a></li>
      <li><a href="theme-assets/inc/logout.php">LOGOUT</a></li>
    <?php
    } else {
    ?>
    <li><a href="signup.php">SIGNUP</a></li>
    <li><a href="login.php">LOGIN</a></li>
    <?php
    }
    ?>
  </ul>
        </div>
    </nav>
</header>
</body>
  <body class="vertical-layout" data-color="bg-gradient-x-purple-blue">   
    <div class="app-content content">
      <div class="content-wrapper">
        <div class="content-wrapper-before mb-3">        	
        </div>        
  <div class="content-body">
  	<div class="mt-2"></div>
	<div class="row">
		<div class="col-md-8">
			<div class="card">
				<div class="card-body text-center">
					<h4 class="mb-2"><strong>BROSS CHK</strong></h4>

					<div class="form-row">
					<textarea rows="14" class="form-control text-center form-checker mb-2" placeholder="You know what to do Right?"></textarea>
					<textarea rows="1" class="form-control text-center" style="width:70%; float: left ;"  id="skgate" placeholder="sk_live_xxxxx"></textarea>
					<textarea rows="1" class="form-control text-center" style="width: 15%; margin-bottom: 1px;" id="crn" placeholder="CURRENCY"></textarea>
					<textarea rows="1"class="form-control text-center" style="width: 14%; float: right margin-bottom: 1px;" id="cst" placeholder="AMOUNT"></textarea></br>
			</div>
					          <select name="gate" id="gate" class="form-control" style="margin-bottom: 1px;">
					            
				<option style="background:rgba(165, 154, 154, 0.281);color:rgb(255, 208, 0);color:orange" value="wine/payment_intents.php">Stripe PAYMENT INTENTS-GATE-</option>         
				<option style="background:rgba(165, 154, 154, 0.281);color:rgb(255, 208, 0);color:red" value="wine/charges.php">Stripe CHARGES-GATE- </option>
				<option style="background:rgba(165, 154, 154, 0.281);color:rgb(255, 208, 0);color:red" value="wine/chk-sk-balance.php">SK Checker with balance </option>
</select>
	<br>										
					<button class="btn btn-play btn-glow btn-bg-gradient-x-blue-cyan text-white" style="width: 49%; float: left;"><i class="fa fa-play"></i>START</button>
					<button class="btn btn-stop btn-glow btn-bg-gradient-x-red-pink text-white" style="width: 49%; float: right;" disabled><i class="fa fa-stop"></i>STOP</button>



				</div>
			</div>
		</div>
<div class="col-md-4">
  <div class="card mb-2">
  	<div class="card-body">

<h5>TOTAL :<span class="badge badge-primary float-right carregadas">0</span></h5><hr>

<h5>LIVE :<span class="badge badge-success float-right charge">0</span></h5><hr>

<h5>CVV :<span class="badge badge-success float-right cvvs">0</span></h5><hr>

<h5>CCN :<span class="badge badge-success float-right aprovadas">0</span></h5><hr>

<h5>DECLINED :<span class="badge badge-danger float-right reprovadas">0</span></h5><hr>

<div style="align-items: center; color: white;">Use Proxy ?<input type="checkbox" id="proxy" name="proxy" value="no" onchange="checkProxy(this)">

<br><br><a href="https://namso-gen.com/" target="_blank" style="align-items: center; color: white;">Namsogen</a> || <a href="http://ccgen-by-bross.42web.io/" target="_blank" style="align-items: center; color: white;">ccgenby-bross</a>
                  </div> 
                </div>
              </div>

              <script>
function checkProxy(checkbox) {
    if (checkbox.checked) {
        checkbox.value = "yes";
    } else {
        checkbox.value = "no";
    }
}
</script>
            		<div class="col-xl-12">
			<div class="card">
				<div class="card-body">
					<div class="float-right">
						<button type="show" class="btn btn-primary btn-sm show-charge"><i class="fa fa-eye-slash"></i></button>
					<button class="btn btn-success btn-sm btn-copy1"><i class="fa fa-copy"></i></button>					
					</div>
					<h4 class="card-title mb-1"><i class="fa fa-check-circle text-success"></i> LIVE</h4>					
			<div id='lista_charge'></div>
				</div>				
			</div>
		</div>
		            		<div class="col-xl-12">
			<div class="card">
				<div class="card-body">
					<div class="float-right">
						<button type="show" class="btn btn-primary btn-sm show-live"><i class="fa fa-eye-slash"></i></button>
					<button class="btn btn-success btn-sm btn-copy2"><i class="fa fa-copy"></i></button>					
					</div>
					<h4 class="card-title mb-1"><i class="fa fa-check text-success"></i> CVV</h4>					
			<div id='lista_cvvs'></div>
				</div>				
			</div>
		</div>
		<div class="col-xl-12">
			<div class="card">
				<div class="card-body">
					<div class="float-right">
						<button type="show" class="btn btn-primary btn-sm show-lives"><i class="fa fa-eye-slash"></i></button>
					<button class="btn btn-success btn-sm btn-copy"><i class="fa fa-copy"></i></button>					
					</div>
					<h4 class="card-title mb-1"><i class="fa fa-times text-success"></i> CCN</h4>					
			<div id='lista_aprovadas'></div>
				</div>				
			</div>
		</div>
		<div class="col-xl-12">
			<div class="card">
				<div class="card-body">
					<div class="float-right">
						<button type='hidden' class="btn btn-primary btn-sm show-dies"><i class="fa fa-eye"></i></button>
					<button class="btn btn-danger btn-sm btn-trash"><i class="fa fa-trash"></i></button>					
					</div>
					<h4 class="card-title mb-1"><i class="fa fa-times text-danger"></i> DECLINED</h4>		
						<div style='display: none;' id='lista_reprovadas'></div>
				</div>				
			</div>
		</div>
		
</section>
        </div>
      </div>
    </div>
 
    <script src="theme-assets/js/core/libraries/jquery.min.js" type="text/javascript"></script>

<style>
    footer {
  text-align: center;
  padding: 3px;
  background-color: #ffffff;
  color: #000000;
}

</style>



<script>







$(document).ready(function(){


const swalWithBootstrapButtons = Swal.mixin({
  customClass: {
    confirmButton: 'btn btn-success',
    cancelButton: 'btn btn-danger'
  },
  buttonsStyling: false
})
    
$('.show-charge').click(function(){
var type = $('.show-charge').attr('type');
$('#lista_charge').slideToggle();
if(type == 'show'){
$('.show-charge').html('<i class="fa fa-eye"></i>');
$('.show-charge').attr('type', 'hidden');
}else{
$('.show-charge').html('<i class="fa fa-eye-slash"></i>');
$('.show-charge').attr('type', 'show');
}});

$('.show-live').click(function(){
var type = $('.show-live').attr('type');
$('#lista_cvvs').slideToggle();
if(type == 'show'){
$('.show-live').html('<i class="fa fa-eye"></i>');
$('.show-live').attr('type', 'hidden');
}else{
$('.show-live').html('<i class="fa fa-eye-slash"></i>');
$('.show-live').attr('type', 'show');
}});

$('.show-lives').click(function(){
var type = $('.show-lives').attr('type');
$('#lista_aprovadas').slideToggle();
if(type == 'show'){
$('.show-lives').html('<i class="fa fa-eye"></i>');
$('.show-lives').attr('type', 'hidden');
}else{
$('.show-lives').html('<i class="fa fa-eye-slash"></i>');
$('.show-lives').attr('type', 'show');
}});

$('.show-dies').click(function(){
var type = $('.show-dies').attr('type');
$('#lista_reprovadas').slideToggle();
if(type == 'show'){
$('.show-dies').html('<i class="fa fa-eye"></i>');
$('.show-dies').attr('type', 'hidden');
}else{
$('.show-dies').html('<i class="fa fa-eye-slash"></i>');
$('.show-dies').attr('type', 'show');
}});

$('.btn-trash').click(function(){
	Swal.fire({title: 'REMOVED DEAD', icon: 'success', showConfirmButton: false, toast: true, position: 'top-end', timer: 3000});
$('#lista_reprovadas').text('');
});

$('.btn-copy1').click(function(){
	Swal.fire({title: 'COPIED LIVE', icon: 'success', showConfirmButton: false, toast: true, position: 'top-end', timer: 3000});
var lista_charge = document.getElementById('lista_charge').innerText;
var textarea = document.createElement("textarea");
textarea.value = lista_charge;
document.body.appendChild(textarea); 
textarea.select(); 
document.execCommand('copy');           document.body.removeChild(textarea); 
});

$('.btn-copy2').click(function(){
	Swal.fire({title: 'COPIED CVV', icon: 'success', showConfirmButton: false, toast: true, position: 'top-end', timer: 3000});
var lista_live = document.getElementById('lista_cvvs').innerText;
var textarea = document.createElement("textarea");
textarea.value = lista_live;
document.body.appendChild(textarea); 
textarea.select(); 
document.execCommand('copy');           document.body.removeChild(textarea); 
});

$('.btn-copy').click(function(){
	Swal.fire({title: 'COPIED CCN', icon: 'success', showConfirmButton: false, toast: true, position: 'top-end', timer: 3000});
var lista_lives = document.getElementById('lista_aprovadas').innerText;
var textarea = document.createElement("textarea");
textarea.value = lista_lives;
document.body.appendChild(textarea); 
textarea.select(); 
document.execCommand('copy');           document.body.removeChild(textarea); 
});


$('.btn-play').click(function(){
var skgate = $("#skgate").val();
var cst = $("#cst").val();
var crn = $("#crn").val();
var proxy = $("#proxy").val();
var e = document.getElementById("gate");
var gate = e.options[e.selectedIndex].value;
var lista = $('.form-checker').val().trim();
var array = lista.split('\n');
var charge = 0, live = 0, lives = 0, dies = 0, testadas = 0, txt = '';

if(!lista){
	Swal.fire({title: 'You did not provide a card :(', icon: 'error', showConfirmButton: false, toast: true, position: 'top-end', timer: 3000});
	return false;
}

Swal.fire({title: 'Your cards are being checked...', icon: 'success', showConfirmButton: false, toast: true, position: 'top-end', timer: 3000});

var line = array.filter(function(value){
if(value.trim() !== ""){
	txt += value.trim() + '\n';
	return value.trim();
}
});

/*
var line = array.filter(function(value){
return(value.trim() !== "");
});
*/

var total = line.length;


/*
line.forEach(function(value){
txt += value + '\n';
});
*/

$('.form-checker').val(txt.trim());
// ảo ma hả, đừng lấy code chứ !!
if(total > 999999999){
  Swal.fire({title: 'YOU CAN NOT PERFORM THAT ACTION: REDUCE NUMBER OF CARDS TO < 999999999', icon: 'warning', showConfirmButton: false, toast: true, position: 'top-end', timer: 3000});
  return false;
}

$('.carregadas').text(total);
$('.btn-play').attr('disabled', true);
$('.btn-stop').attr('disabled', false);

line.forEach(function(data){
var callBack = $.ajax({
	url: gate + '?lista=' + data + '&skgate=' + skgate + '&crn=' + crn + '&cst=' + cst + '&proxy=' + proxy,
	success: function(retorno){
		if(retorno.indexOf("LIVE=") >= 0){
			$('#lista_charge').append(retorno);
			removelinha();
			charge = charge +1;
			}
			else if(retorno.indexOf("CVV=") >= 0){
			$('#lista_cvvs').append(retorno);
			removelinha();
			live = live +1;
		    }
			else if(retorno.indexOf("CCN=") >= 0){
			$('#lista_aprovadas').append(retorno);
			removelinha();
			lives = lives +1;
		    }
		    else{
			$('#lista_reprovadas').append(retorno);
			removelinha();
			dies = dies +1;
		}
		testadas = charge + live + lives + dies;
	    $('.charge').text(charge);
	    $('.cvvs').text(live);
		$('.aprovadas').text(lives);
		$('.reprovadas').text(dies);
		$('.testadas').text(testadas);
		
		if(testadas == total){
			Swal.fire({title: 'ALL CARDS HAS BEEN CHECKED', icon: 'success', showConfirmButton: false, toast: true, position: 'top-end', timer: 3000});
			$('.btn-play').attr('disabled', false);
			$('.btn-stop').attr('disabled', true);
		}
        }
      });
      $('.btn-stop').click(function(){
      Swal.fire({title: 'PAUSED', icon: 'warning', showConfirmButton: false, toast: true, position: 'top-end', timer: 3000});
      $('.btn-play').attr('disabled', false);
      $('.btn-stop').attr('disabled', true);      
      	callBack.abort();
      	return false;
      });
    });
  });
});

function removelinha() {
var lines = $('.form-checker').val().split('\n');
lines.splice(0, 1);
$('.form-checker').val(lines.join("\n"));
}


  
	
</script>

  </body>
</html>