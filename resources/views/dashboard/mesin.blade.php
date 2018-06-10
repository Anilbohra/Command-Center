@extends('layouts.app')
@section('content')
    <form action="mesin/add" method="post">
        @csrf
        <input type="text" name="ip" placeholder="IP Address">
        <input type="text" name="keterangan" placeholder="Keterangan">
        <select name="gedung">
            @foreach($gedung as $gedung)
            <option value="{{ $gedung->id }}">{{ $gedung->nama }}</option>
            @endforeach
        </select>
        <select name="lokasi" disabled>
        </select>
        <button type="submit">Tambah Mesin</button>
    </form>

    <form action="mesin/import" method="post">
        @csrf
        <input type="file" name="mesin">
        <button type="submit">Import Mesin</button>
    </form>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>IP</th>
                <th>Gedung</th>
                <th>Lokasi</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $mesin)
            <tr>
                <td>{{ $mesin->id }}</td>
                <td>{{ $mesin->ip }}</td>
                <td>{{ $mesin->gedung->nama }}</td>
                <td>{{ $mesin->lokasi->nama }}</td>
                <td>{{ $mesin->keterangan }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
@endsection