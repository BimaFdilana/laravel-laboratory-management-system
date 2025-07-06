@extends('layouts.app')

@section('title', 'Profil Saya')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-body">
                <div class="card">
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <div class="card-header">
                            <h4>Edit Profil</h4>
                        </div>
                        <div class="card-body">
                            {{-- Tampilkan Pesan Sukses atau Peringatan --}}
                            @if (session('success'))
                                <div class="alert alert-success">{{ session('success') }}</div>
                            @endif
                            @if (session('warning'))
                                <div class="alert alert-warning">{{ session('warning') }}</div>
                            @endif

                            {{-- Form Fields --}}
                            <div class="form-group">
                                <label>Nama</label>
                                <input type="text" name="name"
                                    class="form-control @error('name') is-invalid @enderror"
                                    value="{{ old('name', $user->name) }}">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    value="{{ old('email', $user->email) }}">
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>NIM</label>
                                <input type="text" name="nim" class="form-control @error('nim') is-invalid @enderror"
                                    value="{{ old('nim', $user->nim) }}">
                                @error('nim')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>No. Handphone</label>
                                <input type="text" name="no_hp"
                                    class="form-control @error('no_hp') is-invalid @enderror"
                                    value="{{ old('no_hp', $user->no_hp) }}">
                                @error('no_hp')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Jurusan</label>
                                <input type="text" name="jurusan"
                                    class="form-control @error('jurusan') is-invalid @enderror"
                                    value="{{ old('jurusan', $user->jurusan) }}">
                                @error('jurusan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Program Studi</label>
                                <input type="text" name="prodi"
                                    class="form-control @error('prodi') is-invalid @enderror"
                                    value="{{ old('prodi', $user->prodi) }}">
                                @error('prodi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Upload KTM (Opsional)</label>
                                <input type="file" name="ktm_path"
                                    class="form-control @error('ktm_path') is-invalid @enderror">
                                @if ($user->ktm_path)
                                    <small class="form-text text-muted">KTM saat ini: <a
                                            href="{{ asset('storage/' . $user->ktm_path) }}" target="_blank">Lihat
                                            KTM</a></small>
                                @endif
                                @error('ktm_path')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <hr>
                            <p>Ubah Password (kosongkan jika tidak ingin diubah)</p>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Password Baru</label>
                                    <input type="password" name="password"
                                        class="form-control @error('password') is-invalid @enderror">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Konfirmasi Password Baru</label>
                                    <input type="password" name="password_confirmation" class="form-control">
                                </div>
                            </div>

                        </div>
                        <div class="card-footer text-right">
                            <button class="btn btn-primary">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection
