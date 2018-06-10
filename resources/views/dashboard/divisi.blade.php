@extends('layouts.app')
@section('content')
    <form action="divisi/add" method="post">
        @csrf
        <input type="text" name="nama" placeholder="Nama Divisi">
        <select name="gedung">
            @foreach($gedung as $gedung)
            <option value="{{ $gedung->id }}">{{ $gedung->nama }}</option>
            @endforeach
        </select>
        <button type="submit">Tambah Divisi</button>
    </form>

    <form action="divisi/import" method="post">
        @csrf
        <input type="file" name="divisi">
        <button type="submit">Import Divisi</button>
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
            @foreach($data as $divisi)
            <tr>
                <td>{{ $divisi->id }}</td>
                <td>{{ $divisi->nama }}</td>
                <td>{{ $divisi->gedung->nama }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection