<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="shortcut icon" href="{{ asset('icon.svg') }}">
    {{-- css --}}
    <script src="jquery/jquery.js"></script>
    <script src="sweetalert/sweetalert.js"></script>
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="datatable/css/dataTable.min.css" rel="stylesheet">
    <link rel="stylesheet" href="">
    <link href="css/app.css" rel="stylesheet">
    {{-- js --}}
    <script src="bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="datatable/js/dataTable.js"></script>
    <script src="datatable/js/dataTable.bootstrap.js"></script>

</head>

<body>
    @yield('content')
    <script>
        new DataTable('#table');
    </script>
</body>

</html>
