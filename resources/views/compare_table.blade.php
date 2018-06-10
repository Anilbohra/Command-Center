<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @yield('meta')

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/jquery-3.3.1.min.js') }}" defer></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/bootstrap.min.js') }}" defer></script>
    <script src="{{ asset('js/fontawesome-all.min.js') }}" defer></script>
    @yield('script')

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/fa-svg-with-js.css') }}" rel="stylesheet">
    @yield('style')
</head>
<body>
    Ada pada mesin 1, Tidak ada pada mesin 2
    <table border="1">
        <thead>
            <tr>
                <th>NPP</th>
                <th>Nama</th>
                <th>Nomor Kartu</th>
            </tr>
        </thead>
        <tbody>
        @foreach($dari as $data)
            <tr>
                <td>
                    @foreach($pegawai as $key => $personil)
<?php 
    $match = array_search($data,$personil);
    if($match){
        echo $pegawai[$key]['npp'];
    }
?>
                    @endforeach
                </td>
                <td>
                    @foreach($pegawai as $key => $personil)
<?php 
    $match = array_search($data,$personil);
    if($match){
        echo $pegawai[$key]['nama'];
    }
?>
                    @endforeach
                </td>
                <td>{{ $data }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    Ada pada mesin 2, Tidak ada pada mesin 1
    <table border="1">
        <thead>
            <tr>
                <th>NPP</th>
                <th>Nama</th>
                <th>Nomor Kartu</th>
            </tr>
        </thead>
        <tbody>
        @foreach($tujuan as $data)
            <tr>
                <td>
                    @foreach($pegawai as $key => $personil)
<?php 
    $match = array_search($data,$personil);
    if($match){
        echo $pegawai[$key]['npp'];
    }
?>
                    @endforeach
                </td>
                <td>
                    @foreach($pegawai as $key => $personil)
<?php 
    $match = array_search($data,$personil);
    if($match){
        echo $pegawai[$key]['nama'];
    }
?>
                    @endforeach
                </td>
                <td>{{ $data }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    @yield('footer-script')
</body>
</html>