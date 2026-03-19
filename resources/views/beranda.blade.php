<!DOCTYPE html>
<html>
<head>
    <title>Inovasi IKM Juara</title>
    <style>
        body { font-family: sans-serif; text-align: center; padding: 50px; }
        .card { border: 1px solid #ddd; padding: 20px; display: inline-block; margin: 10px; border-radius: 8px; }
    </style>
</head>
<body>
    <h1>Selamat Datang di {{ $nama_aplikasi }}</h1>
    <p>Mendorong IKM naik kelas melalui digitalisasi.</p>
    
    <h3>Layanan Kami:</h3>
    @foreach($layanan as $item)
        <div class="card">{{ $item }}</div>
    @endforeach

    <hr>
<h3>Daftar Konsultasi Gratis</h3>
<form action="/simpan-konsultasi" method="POST">
    @csrf <input type="text" name="nama_ikm" placeholder="Nama IKM Anda" required><br><br>
    <input type="text" name="jenis_usaha" placeholder="Bidang Usaha (Contoh: Kuliner)" required><br><br>
    <textarea name="keluhan" placeholder="Apa kendala legalitas Anda?"></textarea><br><br>
    <button type="submit">Kirim Pendaftaran</button>
</form>

@if(session('sukses'))
    <p style="color: green;">{{ session('sukses') }}</p>
@endif

<hr>
<h3>Daftar Antrean Konsultasi</h3>
<table border="1" cellpadding="10" style="width: 100%; border-collapse: collapse; text-align: left;">
    <thead style="background-color: #f2f2f2;">
        <tr>
            <th>No</th>
            <th>Nama IKM</th>
            <th>Jenis Usaha</th>
            <th>Keluhan/Kendala</th>
            <th>Waktu Daftar</th>
        </tr>
    </thead>
    <tbody>
        @forelse($pendaftar as $key => $data)
            <tr>
                <td>{{ $key + 1 }}</td>
                <td>{{ $data->nama_ikm }}</td>
                <td>{{ $data->jenis_usaha }}</td>
                <td>{{ $data->keluhan }}</td>
                <td>{{ $data->created_at->format('d M Y, H:i') }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="5" style="text-align: center;">Belum ada antrean konsultasi.</td>
            </tr>
        @endforelse
    </tbody>
</table>
</body>
</html>