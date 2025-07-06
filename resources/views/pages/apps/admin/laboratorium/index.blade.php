@extends('layouts.app')

@section('title', 'Daftar Laboratorium')

@push('style')
    <!-- CSS Libraries -->
    <!-- Jika Anda menggunakan DataTables atau library CSS lainnya, tambahkan di sini -->
    <link rel="stylesheet" href="{{ asset('library/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('library/datatables.net-select-bs4/css/select.bootstrap4.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="">Laboratorium</a></div>
                    <div class="breadcrumb-item">Daftar Laboratorium</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>List Laboratorium</h4>
                                <div class="card-header-action">
                                    {{-- Tombol untuk menambah laboratorium baru --}}
                                    <a href="{{ route('labors.create') }}" class="btn btn-primary">Tambah Laboratorium</a>
                                </div>
                            </div>
                            <div class="card-body">
                                {{-- Notifikasi sukses atau error --}}
                                @if (session('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        {{ session('success') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif
                                @if (session('error'))
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        {{ session('error') }}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif

                                <div class="table-responsive">
                                    <table class="table table-striped" id="table-1">
                                        <thead>
                                            <tr>
                                                <th class="text-center">No</th>
                                                <th>Nama Lab</th>
                                                <th>Kapasitas</th>
                                                <th>Deskripsi</th>
                                                <th>Penanggung Jawab</th>
                                                <th>Asisten Labor</th>
                                                <th>Ketersediaan</th>
                                                <th>Gambar</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($labors as $index => $labor)
                                                <tr>
                                                    <td class="text-center">{{ $labors->firstItem() + $index }}</td>
                                                    <td>{{ $labor->nama_labor }}</td>
                                                    <td>{{ $labor->kapasitas }}</td>
                                                    <td>{{ Str::limit($labor->deskripsi, 50) }}</td> {{-- Batasi deskripsi --}}
                                                    <td>{{ $labor->penanggung_jawab }}</td>
                                                    <td>{{ Str::limit($labor->asisten_labor, 50) }}</td>
                                                    {{-- Batasi asisten --}}
                                                    <td>
                                                        {{-- Menampilkan status dengan badge Bootstrap --}}
                                                        @if ($labor->ketersediaan == 'tersedia')
                                                            <div class="badge badge-success">Tersedia</div>
                                                        @else
                                                            <div class="badge badge-danger">Tidak Tersedia</div>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($labor->image_path)
                                                            <img src="{{ asset('storage/' . $labor->image_path) }}"
                                                                alt="{{ $labor->nama_labor }}" width="80"
                                                                class="img-thumbnail">
                                                        @else
                                                            <span class="text-muted">Tidak ada gambar</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        {{-- Tombol Edit --}}
                                                        <a href="{{ route('labors.edit', $labor->id) }}"
                                                            class="btn btn-primary btn-action mr-1" data-toggle="tooltip"
                                                            title="Edit">
                                                            <i class="fas fa-pencil-alt"></i>
                                                        </a>

                                                        {{-- Tombol Hapus --}}
                                                        <a href="#" class="btn btn-danger btn-action"
                                                            data-toggle="tooltip" title="Hapus"
                                                            data-confirm="Apakah Anda Yakin?|Tindakan ini tidak dapat dibatalkan. Menghapus lab {{ $labor->nama_labor }}?"
                                                            data-confirm-yes="document.getElementById('delete-labor-{{ $labor->id }}').submit();">
                                                            <i class="fas fa-trash"></i>
                                                        </a>
                                                        <form id="delete-labor-{{ $labor->id }}"
                                                            action="{{ route('labors.destroy', $labor->id) }}"
                                                            method="POST" style="display: none;">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="9" class="text-center">Tidak ada data laboratorium.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                <div class="card-footer text-right">
                                    {{ $labors->links('pagination::bootstrap-4') }} {{-- Menampilkan link pagination --}}
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
    <!-- JS Libraries -->
    {{-- Jika Anda menggunakan DataTables, aktifkan script ini --}}
    <script src="{{ asset('library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('library/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('library/datatables.net-select-bs4/js/select.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('library/jquery-ui-dist/jquery-ui.min.js') }}"></script>

    <!-- Page Specific JS File -->
    {{-- <script src="{{ asset('js/page/modules-datatables.js') }}"></script> --}} {{-- Jika Anda ingin mengaktifkan DataTables --}}
@endpush
