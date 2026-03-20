<form action="{{ route('pelaku-usaha.update', $item->id) }}" method="POST">
    @csrf
    @method('PUT') 
    
    <div class="form-group">
        <label>Nama Perusahaan</label>
        <input type="text" name="nama_perusahaan" class="form-control" value="{{ $item->nama_perusahaan }}">
    </div>
    
    <button type="submit" class="btn btn-primary">Perbarui Data</button>
</form>