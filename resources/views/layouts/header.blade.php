<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi Rencana Anggaran Biaya</title>

    <link rel="shortcut icon" href="{{asset('adminto/images/brand/logo.png')}}">

    <!-- App css -->
    <link href="{{asset('adminto/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('adminto/css/icons.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('adminto/css/style.css')}}" rel="stylesheet" type="text/css" />

    <script src="{{asset('adminto/js/modernizr.min.js')}}"></script>

    <!-- DataTables -->
    <link href="{{asset('adminto/plugins/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('adminto/plugins/datatables/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />


    <link href="{{asset('adminto/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}" rel="stylesheet">
    <!-- Notification css (Toastr) -->
    <link href="{{asset('adminto/plugins/toastr/toastr.min.css')}}" rel="stylesheet" type="text/css" />

    <script src="{{asset('adminto/js/jquery.min.js')}}"></script>
    <!-- Custom box css -->
    <link href="{{asset('adminto/plugins/custombox/dist/custombox.min.css')}}" rel="stylesheet">

    <!-- time picker -->
    <link href="{{asset('adminto/plugins/timepicker/bootstrap-timepicker.min.css')}}" rel="stylesheet">

    <!-- form Uploads -->
    <link href="{{asset('adminto/plugins/fileuploads/css/dropify.min.css')}}" rel="stylesheet" type="text/css" />
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.2/css/bootstrap-select.min.css">

    <!-- select2 -->

    <link href="{{asset('adminto/plugins/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css" />

    <link href="{{asset('adminto/plugins/bootstrap-tagsinput/dist/bootstrap-tagsinput.css')}}" rel="stylesheet" />
    <!-- @toastr_css -->

    <style>
        .p1 {
            font-size: 32px;
            font-family: "Times New Roman", Times, serif;
        }
        .home {
            text-align: justify;
        }

        .select2-dropdown {
            z-index: 99999 !important;
        }

        .select2-container--default .select2-selection--single{
            background-color: #fff;
            border: 1px solid #E3E3E3;
            border-radius: 4px;
        }

        .select2-container .select2-selection--single {
            height: 34px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered{
            line-height: 32px !important;
        }

        .select2-close-mask {
            z-index: 99999 !important;
        }
    </style>

</head>

<body class="fixed-left">


    <!-- Begin page -->
    <div id="wrapper">