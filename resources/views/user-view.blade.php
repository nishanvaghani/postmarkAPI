<!DOCTYPE html>
<html lang="en">

<head>
    <title>User Details</title>
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
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    

    <style>
        .style-class {
            background: #fff;
            border-radius: 10px;
            overflow: hidden;

            display: -webkit-box;
            display: -webkit-flex;
            display: -moz-box;
            display: -ms-flexbox;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            padding: 100px;
        }
    </style>
</head>

<body>

    <div class="limiter">
        <div class="container-login100">
            <div class="style-class">
                <form class="login100-form validate-form">
                    <div id="alert-out">
                    </div>
                    <span class="login100-form-title">
                        Change User Email
                    </span>

                    <div class="wrap-input100 validate-input" data-validate="Valid email is required: ex@abc.xyz">
                        <input class="input100" type="text" name="old_email" id="old_email" placeholder="Enter Old Email">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-envelope" aria-hidden="true"></i>
                        </span>
                    </div>

                    <div class="wrap-input100 validate-input" data-validate="Valid email is required: ex@abc.xyz">
                        <input class="input100" type="text" name="new_email" id="new_email" placeholder="Enter New Email">
                        <span class="focus-input100"></span>
                        <span class="symbol-input100">
                            <i class="fa fa-envelope" aria-hidden="true"></i>
                        </span>
                    </div>

                    <div class="container-login100-form-btn">
                        <button class="login100-form-btn" name="btn_submit" id="btn_submit">
                            Change Email
                        </button>
                    </div>

                </form>
                <div class="container-login100-form-btn">
                    <form id="logout-form" action="{{ route('logout') }}" method="POST">
                        @csrf
                        <input type="hidden" name="token" id="token" value="{{ $token }}">
                        <button type="submit" class="btn btn-danger" name="btn_logout" id="btn_logout">
                            Logout
                        </button>
                    </form>
                </div>
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
        localStorage.setItem('token', 'Bearer {{ $token }}')
        $('.js-tilt').tilt({
            scale: 1.1
        })

        $('#btn_submit').on('click', function(event) {
            var token = localStorage.getItem('token');
            var oldEmail = $('#old_email');
            var newEmail = $('#new_email');
            $.ajax({
                url: "{{ route('change-user-email') }}",
                method: 'POST',
                dataType: 'JSON',
                headers: {
                    "Authorization": "Bearer {{ $token }}"
                },
                data: {
                    'old_email': oldEmail.val(),
                    'new_email': newEmail.val(),
                    'user_id': "{{ Auth::id() }}",
                },
                success: function(data) {
                    if (data.message) {
                        $('#alert-inner').remove();
                        $('#alert-out').append(`<div class="alert alert-success id="alert-inner" alert-dismissible fade show" role="alert">
                        <strong>${data.message}</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>`);
                    }
                    oldEmail.val('');
                    newEmail.val('');
                },
                error: function(data) {
                    console.log(data.responseJSON.message);
                    $('#alert-show').remove();
                    if (data.responseJSON.message) {
                        $('#alert-out').append(`<div class="alert alert-danger id="alert-inner" alert-dismissible fade show" role="alert">
                        <strong>${data.responseJSON.message}</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>`);
                    }
                }
            });
            event.preventDefault();
        });

        function submitForm() {
            $.ajax({
                url: "{{ route('logout',['token' => $token]) }}",
                method: 'POST',
                dataType: 'JSON',
                headers: {
                    // 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    "Authorization": "Bearer {{ $token }}"
                },
                data: {
                    'user_id': "{{ Auth::id() }}",
                },
                success: function(data) {
                    if (data.message) {
                        $('#alert-inner').remove();
                        $('#alert-out').append(`<div class="alert alert-success id="alert-inner" alert-dismissible fade show" role="alert">
                        <strong>${data.message}</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>`);
                    }
                    oldEmail.val('');
                    newEmail.val('');
                },
                error: function(data) {
                    console.log(data.responseJSON.message);
                    $('#alert-show').remove();
                    if (data.responseJSON.message) {
                        $('#alert-out').append(`<div class="alert alert-danger id="alert-inner" alert-dismissible fade show" role="alert">
                        <strong>${data.responseJSON.message}</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>`);
                    }
                }
            });
        }
    </script>
    <script src="{{ asset('login_assets/js/main.js') }}"></script>

</body>

</html>