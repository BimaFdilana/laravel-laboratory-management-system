@extends('layouts.app')

@section('title', 'Daftar Mahasiswa')

@push('style')
    <!-- CSS Libraries -->
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="">Menu</a></div>
                    <div class="breadcrumb-item">Mahasiswa</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Data Mahasiswa</h4>
                            </div>
                            <div class="card-body">
                                {{-- Pesan Sukses --}}
                                @if (session('success'))
                                    <div class="alert alert-success alert-dismissible show fade">
                                        <div class="alert-body">
                                            <button class="close" data-dismiss="alert">
                                                <span>&times;</span>
                                            </button>
                                            {{ session('success') }}
                                        </div>
                                    </div>
                                @endif

                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th class="text-center">No</th>
                                                <th>Kartu Tanda Mahasiswa</th> {{-- KOLOM BARU --}}
                                                <th>Nama</th>
                                                <th>NIM</th>
                                                <th>Email</th>
                                                <th>Jurusan</th>
                                                <th class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($mahasiswas as $index => $mahasiswa)
                                                <tr>
                                                    <td class="text-center">{{ $mahasiswas->firstItem() + $index }}</td>
                                                    {{-- SEL BARU UNTUK GAMBAR --}}
                                                    <td>
                                                        @if ($mahasiswa->ktm_path)
                                                            <a href="{{ asset('storage/' . $mahasiswa->ktm_path) }}"
                                                                target="_blank">
                                                                <img src="{{ asset('storage/' . $mahasiswa->ktm_path) }}"
                                                                    alt="KTM {{ $mahasiswa->name }}" width="100"
                                                                    class="img-thumbnail">
                                                            </a>
                                                        @else
                                                            <span class="text-muted">Tidak Ada</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $mahasiswa->name }}</td>
                                                    <td>{{ $mahasiswa->nim }}</td>
                                                    <td>{{ $mahasiswa->email }}</td>
                                                    <td>{{ $mahasiswa->jurusan }}</td>
                                                    <td class="text-center">
                                                        <a href="{{ route('mahasiswa.edit', $mahasiswa->id) }}"
                                                            class="btn btn-icon btn-info mr-1" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                        <form action="{{ route('mahasiswa.destroy', $mahasiswa->id) }}"
                                                            method="POST" class="d-inline"
                                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn btn-icon btn-danger" title="Hapus">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    {{-- Ubah colspan menjadi 7 karena ada kolom baru --}}
                                                    <td colspan="7" class="text-center">Data Mahasiswa tidak ditemukan.
                                                    </td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                                {{-- Link Paginasi --}}
                                <div class="float-right">
                                    {{ $mahasiswas->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- JS Libraies -->
    <!-- Page Specific JS File -->
@endpush
