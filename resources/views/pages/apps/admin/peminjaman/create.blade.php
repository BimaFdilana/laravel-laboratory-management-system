@extends('layouts.app')

@section('title', 'Form Peminjaman Laboratorium')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Formulir Peminjaman</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="">Dashboard</a></div>
                    <div class="breadcrumb-item">Formulir</div>
                </div>
            </div>

            <div class="section-body">
                <div class="card">
                    <form action="{{ route('peminjaman.store') }}" method="POST">
                        @csrf
                        <div class="card-header">
                            <h4>Ajukan Peminjaman Laboratorium</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label for="labor_id">Pilih Laboratorium</label>
                                <select id="labor_id" name="labor_id"
                                    class="form-control @error('labor_id') is-invalid @enderror" required>
                                    <option value="" disabled selected>-- Pilih salah satu --</option>
                                    @foreach ($labors as $labor)
                                        <option value="{{ $labor->id }}"
                                            {{ old('labor_id') == $labor->id ? 'selected' : '' }}>
                                            {{ $labor->nama_labor }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('labor_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="waktu_peminjaman">Waktu Peminjaman</label>
                                <input type="datetime-local" id="waktu_peminjaman" name="waktu_peminjaman"
                                    class="form-control @error('waktu_peminjaman') is-invalid @enderror"
                                    value="{{ old('waktu_peminjaman') }}" required>
                                @error('waktu_peminjaman')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="penanggung_jawab">Nama Penanggung Jawab</label>
                                <input type="text" id="penanggung_jawab" name="penanggung_jawab"
                                    class="form-control @error('penanggung_jawab') is-invalid @enderror"
                                    value="{{ old('penanggung_jawab') }}" required>
                                @error('penanggung_jawab')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="alasan">Alasan dan Keperluan</label>
                                <textarea id="alasan" name="alasan" class="form-control @error('alasan') is-invalid @enderror"
                                    style="height: 100px;" required>{{ old('alasan') }}</textarea>
                                @error('alasan')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <button type="submit" class="btn btn-primary">Kirim Pengajuan</button>
                            <a href="{{ route('home') }}" class="btn btn-secondary">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
@endpush
