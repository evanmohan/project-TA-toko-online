<div class="row">
    <div class="col-md-4">
        <img src="{{ asset('img/user.png') }}" class="img-fluid rounded">
        <button class="btn btn-outline-success w-100 mt-3">Pilih Foto</button>
    </div>

    <div class="col-md-8">
        <h5>Ubah Biodata Diri</h5>
        <div class="mt-3">
            <p><strong>Nama</strong> : {{ Auth::user()->username }}</p>
            <a href="#" class="text-success">Ubah</a>
        </div>

        <div class="mt-3">
            <p><strong>Email</strong> : {{ Auth::user()->email }}</p>
            <span class="badge bg-success">Terverifikasi</span>
            <a href="#" class="text-success">Ubah</a>
        </div>

        <div class="mt-3">
            <p><strong>Nomor HP</strong> : {{ Auth::user()->no_hp ?? 'Belum ada' }}</p>
            <a href="#" class="text-success">Tambah Nomor HP</a>
        </div>
    </div>
</div>
