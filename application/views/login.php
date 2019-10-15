<!DOCTYPE html>
<html lang="es">

<head>
	<title>Iniciar Sesión</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="<?=base_url()?>asset/images/icons/favicon.ico" />
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>asset/vendor/bootstrap/css/bootstrap.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css"
		href="<?=base_url()?>asset/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>asset/vendor/animate/animate.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>asset/vendor/css-hamburgers/hamburgers.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>asset/vendor/select2/select2.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>asset/css/util.css">
	<link rel="stylesheet" type="text/css" href="<?=base_url()?>asset/css/main.css">
	<!--===============================================================================================-->
</head>

<body>

	<div class="limiter" id="app"  style="padding-top: 8%">
		<div class="container pt-5">

			<h2 class="text-center"><b>Sistema de Control</b></h2>
			<div class="wrap-login100" style="border-top: 0px; padding-top:8%">
				<div class="login100-pic js-tilt" data-tilt>
					<img src="<?=base_url()?>assets/img/logo_min.png">
				</div>
				<form class="login100-form validate-form" + method="POST">
					<span class="login100-form-title">
						Iniciar Sesión
					</span>

					<div class="wrap-input100 validate-input" data-validate="Usuario inválido">
						<input class="input100" type="text" name="username" placeholder="Nombre de usuario"
							v-model="usuario.name">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-user" aria-hidden="true"></i>
						</span>
					</div>

					<div class="wrap-input100 validate-input" data-validate="Contraseña requerida">
						<input class="input100" type="password" name="password" placeholder="Password"
							v-model="usuario.pass">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-lock" aria-hidden="true"></i>
						</span>
					</div>

					<div class="container-login100-form-btn">
						<button class="login100-form-btn green-bg"  @click="ingresar">
							Ingresar
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>




	<!--===============================================================================================-->
	<script src="<?=base_url()?>asset/vendor/jquery/jquery-3.2.1.min.js"></script>
	<!--===============================================================================================-->
	<script src="<?=base_url()?>asset/vendor/bootstrap/js/popper.js"></script>
	<script src="<?=base_url()?>asset/vendor/bootstrap/js/bootstrap.min.js"></script>
	<!--===============================================================================================-->
	<script src="<?=base_url()?>asset/vendor/select2/select2.min.js"></script>
	<!--===============================================================================================-->
	<script src="<?=base_url()?>asset/vendor/tilt/tilt.jquery.min.js"></script>
	<script>
		$('.js-tilt').tilt({
			scale: 1.1
		})
	</script>
	<!--===============================================================================================-->
	<script src="<?=base_url()?>asset/js/main.js"></script>
	<script src="<?=base_url()?>asset/js/vue.js"></script>
	<script src="<?=base_url()?>asset/js/axios.js"></script>
	<script>
		var app = new Vue({
			el: "#app",
			data: {
				usuario: { name: '', pass: '' }
			},
			created: function () {
			},
			methods: {
				ingresar() {
					var url = "<?=base_url()?>index.php/api/clasificacion/";
					axios.post(url, {
						username: this.usuario.name,
						password: this.usuario.pass
					})
						.then(response => {
							//alert("Exito");

						}).catch(error => {

						});
				}
			}
		});
	</script>

</body>

</html>