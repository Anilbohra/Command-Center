<form action="/clone" method="post">
    @csrf
    <label for="mesin_sumber">Mesin Sumber</label>
    <select name="mesin_sumber" id="mesin_sumber">
        @foreach($mesin as $data)
        <option value="{{ $data->ipv4 }}">{{ $data->nama }}</option>
        @endforeach
    </select>
    
    <label for="mesin_tujuan">Mesin Tujuan</label>
    <select name="mesin_tujuan" id="mesin_tujuan">
        @foreach($mesin as $data)
        <option value="{{ $data->ipv4 }}">{{ $data->nama }}</option>
        @endforeach
    </select>

    <button type="submit">Clone Data Mesin!</button>
</form>