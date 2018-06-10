@extends('layouts.app')
@section('content')
    <form action="lokasi/add" method="post">
        @csrf
        <input type="text" name="nama" placeholder="Nama Lokasi">
        <select name="gedung">
            @foreach($gedung as $gedung)
            <option value="{{ $gedung->id }}">{{ $gedung->nama }}</option>
            @endforeach
        </select>
        <button type="submit">Tambah Lokasi</button>
    </form>

    <form action="lokasi/import" method="post">
        @csrf
        <input type="file" name="lokasi">
        <button type="submit">Import Lokasi</button>
    </form>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Gedung</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $lokasi)
            <tr>
                <td>{{ $lokasi->id }}</td>
                <td>{{ $lokasi->nama }}</td>
                <td>{{ $lokasi->gedung('asd')->nama }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection