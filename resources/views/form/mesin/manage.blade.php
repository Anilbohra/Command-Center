<form action="/mesin/manage" method="post">
    <input type="text" name="ip">
    <input type="text" name="nama">
    <select name="lokasi">
        @foreach($lokasi as $data_lokasi)
        <option value="{{ $data_lokasi->id }}">{{ $data_lokasi->nama }}</option>
        @endforeach
    </select>
    <button type="submit"><i class="fas fa-plus"></i></button>
</form>
<table class="table">
    <thead>
        <tr>
            <th></th>
            <th>IPv4</th>
            <th>Nama Mesin</th>
            <th>Lokasi Mesin</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @foreach($mesin as $data)
        <tr>
            <td><input type="checkbox" name="selected"></td>
            <td><input type="text" value="{{ $data->ipv4 }}"></td>
            <td><input type="text" value="{{ $data->nama }}"></td>
            <td>
                <select name="lokasi">
                    @foreach($lokasi as $data_lokasi)
                    @if($data_lokasi->id == $data->lokasi)
                    <option value="{{ $data_lokasi->id }}" selected>{{ $data_lokasi->nama }}</option>
                    @endif
                    <option value="{{ $data_lokasi->id }}">{{ $data_lokasi->nama }}</option>
                    @endforeach
                </select>
            </td>
            <td>
                <a href="#"><i class="far fa-save"></i></a>
                <a href="#"><i class="far fa-trash-alt"></i></a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>