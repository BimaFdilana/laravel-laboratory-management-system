@extends('layouts.app')

@section('title', 'Edit Laboratorium')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Edit Laboratorium</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="">Daftar Laboratorium</a></div>
                    <div class="breadcrumb-item">Edit Laboratorium</div>
                </div>
            </div>

            <div class="section-body">
                <div class="card">
                    {{-- Form untuk update, menggunakan metode PUT --}}
                    <form action="{{ route('labors.update', $labor->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT') {{-- Penting untuk metode HTTP PUT --}}
                        <div class="card-header">
                            <h4>Form Edit Laboratorium</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label>Nama Laboratorium</label>
                                <input type="text" name="nama_labor"
                                    class="form-control @error('nama_labor') is-invalid @enderror"
                                    value="{{ old('nama_labor', $labor->nama_labor) }}">
                                @error('nama_labor')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Kapasitas</label>
                                <input type="text" name="kapasitas"
                                    class="form-control @error('kapasitas') is-invalid @enderror"
                                    value="{{ old('kapasitas', $labor->kapasitas) }}">
                                @error('kapasitas')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Deskripsi</label>
                                <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror" style="height: 100px;">{{ old('deskripsi', $labor->deskripsi) }}</textarea>
                                @error('deskripsi')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Penanggung Jawab</label>
                                <input type="text" name="penanggung_jawab"
                                    class="form-control @error('penanggung_jawab') is-invalid @enderror"
                                    value="{{ old('penanggung_jawab', $labor->penanggung_jawab) }}">
                                @error('penanggung_jawab')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Asisten Labor</label>
                                <textarea name="asisten_labor" class="form-control @error('asisten_labor') is-invalid @enderror" style="height: 100px;">{{ old('asisten_labor', $labor->asisten_labor) }}</textarea>
                                @error('asisten_labor')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="form-label">Ketersediaan</label>
                                <div class="selectgroup w-100">
                                    <label class="selectgroup-item">
                                        <input type="radio" name="ketersediaan" value="tersedia" class="selectgroup-input"
                                            {{ old('ketersediaan', $labor->ketersediaan) == 'tersedia' ? 'checked' : '' }}>
                                        <span class="selectgroup-button">Tersedia</span>
                                    </label>
                                    <label class="selectgroup-item">
                                        <input type="radio" name="ketersediaan" value="tidak tersedia"
                                            class="selectgroup-input"
                                            {{ old('ketersediaan', $labor->ketersediaan) == 'tidak tersedia' ? 'checked' : '' }}>
                                        <span class="selectgroup-button">Tidak Tersedia</span>
                                    </label>
                                </div>
                                @error('ketersediaan')
                                    <div class="invalid-feedback d-block">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Gambar Laboratorium Saat Ini</label>
                                <div>
                                    @if ($labor->image_path)
                                        <img src="{{ asset('storage/' . $labor->image_path) }}"
                                            alt="{{ $labor->nama_labor }}" width="150" class="img-thumbnail mb-2">
                                    @else
                                        <span class="text-muted">Tidak ada gambar saat ini.</span>
                                    @endif
                                </div>
                                <label>Unggah Gambar Baru (Opsional)</label>
                                <input type="file" name="image_path"
                                    class="form-control @error('image_path') is-invalid @enderror">
                                @error('image_path')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <button class="btn btn-primary">Update</button>
                            <a href="{{ route('labors.index') }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->

    <!-- Page Specific JS File -->
@endpush
