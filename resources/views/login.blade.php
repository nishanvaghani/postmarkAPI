
<!DOCTYPE html>
<html lang="en">

<head>
	<title>Login Page</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--===============================================================================================-->
	<!-- <link rel="icon" type="image/png" href="images/icons/favicon.ico"/> -->
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('login_assets/vendor/bootstrap/css/bootstrap.min.css') }}">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('login_assets/fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('login_assets/vendor/animate/animate.css') }}">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('login_assets/vendor/css-hamburgers/hamburgers.min.css') }}">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('login_assets/vendor/select2/select2.min.css') }}">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('login_assets/css/util.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('login_assets/css/main.css') }}">
	<!--===============================================================================================-->
</head>

<body>

	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<div class="login100-pic js-tilt" data-tilt>
					<img src="{{ asset('login_assets/images/img-01.png') }}" alt="IMG">
				</div>

				<form class="login100-form validate-form">
					<span class="login100-form-title">
						Member Login
					</span>

					<div class="wrap-input100 validate-input" data-validate="Valid email is required: ex@abc.xyz">
						<input class="input100" type="text" name="email" id="email" placeholder="Email">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<i class="fa fa-envelope" aria-hidden="true"></i>
						</span>
					</div>
					<div id="alert">
						@if(isset($message))
						<div class="test text-danger" id="inner_alert" style="text-align: center;" role="alert">
							{{ $message }}
						</div>
						@endif
					</div>
					<div class="container-login100-form-btn">
						<button class="login100-form-btn">
							Send Email
						</button>
					</div>

					<div class="text-center p-t-12">

					</div>

					<div class="text-center p-t-136">

					</div>
				</form>
			</div>
		</div>
	</div>




	<!--===============================================================================================-->
	<script src="{{ asset('login_assets/vendor/jquery/jquery-3.2.1.min.js') }}"></script>
	<!--===============================================================================================-->
	<script src="{{ asset('login_assets/vendor/bootstrap/js/popper.js') }}"></script>
	<script src="{{ asset('login_assets/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
	<!--===============================================================================================-->
	<script src="{{ asset('login_assets/vendor/select2/select2.min.js') }}"></script>
	<!--===============================================================================================-->
	<script src="{{ asset('login_assets/vendor/tilt/tilt.jquery.min.js') }}"></script>
	<script>
		$('.js-tilt').tilt({
			scale: 1.1
		})

		$('.login100-form').on('submit', function(event) {
			var email = $('#email').val();
			var data = {
				'email': $('#email').val(),
				'_token' : '{{ csrf_token() }}'
			};
			$.ajax({
				url: "{{route('send.mail')}}",
				method: "POST",
				data: data,
				success: function(data) {
					if (data) {
						$('#email').val(null);
						$('#inner_alert').remove();
						$('#alert').append(`<div class="test text-success" id="inner_alert" style="text-align: center;" role="alert">
							Email Sent. Please check your inbox.
						</div>`);
					}
				},
				error: function(data) {
					console.log(data)
					$('#inner_alert').remove();
					$('#alert').append(`<div class="test text-danger" id="inner_alert" style="text-align: center;" role="alert">
						${data.responseJSON.message}
					</div>`);
				}
			});
			event.preventDefault();
		});
	</script>
	<!--===============================================================================================-->
	<script src="{{ asset('login_assets/js/main.js') }}"></script>

</body>

</html>