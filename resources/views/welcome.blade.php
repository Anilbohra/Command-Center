<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Access Control Management</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }

            .dropdown{
                display: inline;
            }
        </style>

        <!-- Scripts -->
        <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
        <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/all.js" integrity="sha384-xymdQtn1n3lH2wcu0qhcdaOpQwyoarkgLVxC/wZ5q7h9gHtxICrpcaSUfygqZGOe" crossorigin="anonymous"></script>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="content">
                <div class="title m-b-md">
                    Manajemen Akses Kontrol<br/>PT. PINDAD (Persero)
                </div>

                <div class="links">
                    <div class="dropdown">
                        <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Mesin
                        </a>

                        <div class="dropdown-menu">
                            <a href="#" data-toggle="modal" data-target="#form-modal" class="form-link dropdown-item" data-remote="/mesin/manage" id="manage">Manage Mesin</a>
                            <a href="#" data-toggle="modal" data-target="#form-modal" class="form-link dropdown-item" data-remote="/mesin/manage-lokasi-mesin" id="manage-lokasi-mesin">Manage Lokasi Mesin</a>
                            <a href="#" data-toggle="modal" data-target="#form-modal" class="form-link dropdown-item" data-remote="/mesin/log" id="log">Lihat Log Kehadiran Pada Mesin</a>
                            <a href="#" data-toggle="modal" data-target="#form-modal" class="form-link dropdown-item" data-remote="/mesin/clear-log" id="clear-log">Bersihkan Log Kehadiran Pada Mesin</a>
                            <a href="#" data-toggle="modal" data-target="#form-modal" class="form-link dropdown-item" data-remote="/mesin/clone" id="clone">Clone Data Mesin</a>
                            <a href="#" data-toggle="modal" data-target="#form-modal" class="form-link dropdown-item" data-remote="/mesin/compare" id="compare">Compare Data Mesin</a>
                            <a href="#" data-toggle="modal" data-target="#form-modal" class="form-link dropdown-item" data-remote="/mesin/tambah-manual" id="tambah-manual">Tambah Orang Pada Mesin</a>
                            <a href="#" data-toggle="modal" data-target="#form-modal" class="form-link dropdown-item" data-remote="/mesin/hapus-manual" id="hapus-manual">Hapus Orang Pada Mesin</a>
                            <a href="#" data-toggle="modal" data-target="#form-modal" class="form-link dropdown-item" data-remote="/mesin/clear-personil" id="clear-personil">Hapus Data Personil Pada Mesin</a>
                        </div>
                    </div>

                    <div class="dropdown">
                        <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Pegawai
                        </a>

                        <div class="dropdown-menu">
                            <a href="#" data-toggle="modal" data-target="#form-modal" data-remote="/mesin/clone" class="form-link dropdown-item" id="manage-mesin">Manage Pegawai</a>
                        </div>
                    </div>

                    <div class="dropdown">
                        <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Tamu
                        </a>

                        <div class="dropdown-menu">
                            <a href="#" data-toggle="modal" data-target="#form-modal" data-remote="/mesin/clone" class="form-link dropdown-item" id="manage-mesin">Manage Tamu</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="form-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="form-title">Form</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    
                    <div class="modal-body">
                        
                    </div>
                </div>
            </div>
        </div>
        <script>
            $('.form-link').click(function(){
                $($(this).data("target")+' .modal-body').load($(this).data("remote"));
            });
        </script>
    </body>
</html>
