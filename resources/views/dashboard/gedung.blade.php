@extends('layouts.app')
@section('content')
    <form action="gedung/add" method="post">
        @csrf
        <input type="text" name="nama" placeholder="Nama Gedung">
        <button type="submit">Tambah Gedung</button>
    </form>

    <form action="gedung/import" method="post">
        @csrf
        <input type="file" name="gedung">
        <button type="submit">Import Gedung</button>
    </form>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $gedung)
            <tr>
                <td>{{ $gedung->id }}</td>
                <td>{{ $gedung->nama }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection