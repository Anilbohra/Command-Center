@extends('layouts.app')
@section('content')
    <form action="pegawai/add" method="post">
        @csrf
        <input type="number" name="npp" placeholder="NPP">
        <input type="text" name="nama" placeholder="Nama">
        <select name="divisi">
            @foreach($divisi as $divisi)
            <option value="{{ $divisi->id }}">{{ $divisi->nama }}</option>
            @endforeach
        </select>
        <input type="number" name="nomor_kartu" placeholder="Nomor Kartu RFID">
        <button type="submit">Tambah Pegawai</button>
    </form>

    <form action="pegawai/import" method="post">
        @csrf
        <input type="file" name="pegawai">
        <button type="submit">Import Pegawai</button>
    </form>

    <table>
        <thead>
            <tr>
                <th>NPP</th>
                <th>Nama</th>
                <th>Divisi</th>
                <th>Nomor Kartu RFID</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $pegawai)
            <tr>
                <td>{{ $pegawai->npp }}</td>
                <td>{{ $pegawai->nama }}</td>
                <td>{{ $pegawai->divisi->nama }}</td>
                <td>{{ $pegawai->nomor_kartu }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection