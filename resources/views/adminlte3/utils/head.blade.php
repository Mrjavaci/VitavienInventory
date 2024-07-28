<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>@yield('title', 'Yönetim Paneli')</title>

<!-- Font Awesome -->
<link rel="stylesheet" href="{{asset('vendor/adminlte3/plugins/fontawesome-free/css/all.min.css')}}">
<!-- Theme style -->
<link rel="stylesheet" href="{{asset('vendor/adminlte3/dist/css/adminlte.min.css')}}">

<link rel="stylesheet" href="{{asset('vendor/adminlte3/plugins/summernote/summernote.min.css')}}">
<link rel="stylesheet" href="{{asset('vendor/adminlte3/plugins/sweetalert2/sweetalert2.min.css')}}">
<link rel="stylesheet" href="{{asset('vendor/adminlte3/plugins/select2/css/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('vendor/adminlte3/plugins/datatables-select/css/select.bootstrap4.min.css')}}">

<!-- DataTables -->
<link rel="stylesheet" href="{{asset('vendor/adminlte3/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('vendor/adminlte3/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('vendor/adminlte3/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
<!-- Custom style -->
@stack('css')
