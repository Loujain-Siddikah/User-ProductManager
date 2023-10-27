<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login V2</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="{{ URL::asset('assets2/images/icons/favicon.ico')}}"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/vendor/bootstrap/css/bootstrap.min.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/fonts/font-awesome-4.7.0/css/font-awesome.min.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/fonts/iconic/css/material-design-iconic-font.min.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/vendor/animate/animate.css')}}">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/vendor/css-hamburgers/hamburgers.min.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/vendor/animsition/css/animsition.min.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/vendor/select2/select2.min.css')}}">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/vendor/daterangepicker/daterangepicker.css')}}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/util.css')}}">
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('assets/css/main.css')}}">
<!--===============================================================================================-->

{{-- <script src="{{ URL::asset('assets/js/redirectRegister.js') }}"></script> --}}
{{-- <script>
    $.ajax({
    url: $('#registerForm').attr('action'), // Use the form's action attribute
    method: $('#registerForm').attr('method'),
    data: {
        data: $('#registerForm').serialize(),
    },
    success: function(response) {
        console.log('Success function executed');
        if (response.script) {
        // Execute the JavaScript snippet for redirection
        eval(response.script);
    } else {
        // Handle other responses as needed
        console.log(response.message);
    }
    },
    error: function(xhr, status, error) {
        // Handle errors if necessary
        console.error(error);
    }
});
</script> --}}

</head>
<body>
    @yield('content')

    <!--===============================================================================================-->
	<script src="{{ URL::asset('assets/vendor/jquery/jquery-3.2.1.min.js')}}"></script>
    <!--===============================================================================================-->
        <script src="{{ URL::asset('assets/vendor/animsition/js/animsition.min.js')}}"></script>
    <!--===============================================================================================-->
        <script src="{{ URL::asset('assets/vendor/bootstrap/js/popper.js')}}"></script>
        <script src="{{ URL::asset('assets/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
    <!--===============================================================================================-->
        <script src="{{ URL::asset('assets/vendor/select2/select2.min.js')}}"></script>
    <!--===============================================================================================-->
        <script src="{{ URL::asset('assets/vendor/daterangepicker/moment.min.js')}}"></script>
        <script src="{{ URL::asset('assets/vendor/daterangepicker/daterangepicker.js')}}"></script>
    <!--===============================================================================================-->
        <script src="{{ URL::asset('assets/vendor/countdowntime/countdowntime.js')}}"></script>
    <!--===============================================================================================-->
        <script src="{{ URL::asset('assets/js/main.js')}}"></script>
</body>
</html>