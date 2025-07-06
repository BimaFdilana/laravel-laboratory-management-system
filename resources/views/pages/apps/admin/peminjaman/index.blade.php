@extends('layouts.app')

@section('title', 'Daftar Peminjaman')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="">Laboratorium</a></div>
                    <div class="breadcrumb-item">Peminjaman</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>List Peminjaman</h4>
                            </div>
                            <div class="card-body">
                                @if (session('success'))
                                    <div class="alert alert-success alert-dismissible show fade">
                                        <div class="alert-body"><button class="close"
                                                data-dismiss="alert"><span>&times;</span></button>{{ session('success') }}
                                        </div>
                                    </div>
                                @endif
                                @if (session('error'))
                                    <div class="alert alert-danger alert-dismissible show fade">
                                        <div class="alert-body"><button class="close"
                                                data-dismiss="alert"><span>&times;</span></button>{{ session('error') }}
                                        </div>
                                    </div>
                                @endif

                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Peminjam</th>
                                                <th>NIM</th>
                                                <th>Laboratorium</th>
                                                <th>Waktu Pinjam</th>
                                                <th>Status</th>
                                                <th class="text-center">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($peminjamans as $index => $peminjaman)
                                                <tr>
                                                    <td>{{ $peminjamans->firstItem() + $index }}</td>
                                                    <td>{{ $peminjaman->user->name ?? 'N/A' }}</td>
                                                    <td>{{ $peminjaman->user->nim ?? 'N/A' }}</td>
                                                    <td>{{ $peminjaman->labor->nama_labor ?? 'N/A' }}</td>
                                                    <td>{{ $peminjaman->waktu_peminjaman->format('d M Y, H:i') }}</td>
                                                    <td>
                                                        @php
                                                            $statusClass = [
                                                                'diajukan' => 'badge-warning',
                                                                'disetujui' => 'badge-success',
                                                                'ditolak' => 'badge-danger',
                                                                'berjalan' => 'badge-info',
                                                                'selesai' => 'badge-secondary',
                                                            ];
                                                        @endphp
                                                        <span
                                                            class="badge {{ $statusClass[$peminjaman->status] ?? 'badge-light' }}">{{ $peminjaman->status }}</span>
                                                    </td>
                                                    <td class="text-center">
                                                        @if (Auth::user()->role->name == 'admin')
                                                            <div class="dropdown d-inline">
                                                                <button class="btn btn-primary dropdown-toggle btn-sm"
                                                                    type="button"
                                                                    id="dropdownMenuButton-{{ $peminjaman->id }}"
                                                                    data-toggle="dropdown" aria-haspopup="true"
                                                                    aria-expanded="false">
                                                                    Aksi
                                                                </button>
                                                                <div class="dropdown-menu"
                                                                    aria-labelledby="dropdownMenuButton-{{ $peminjaman->id }}">
                                                                    @if ($peminjaman->status == 'diajukan')
                                                                        <a class="dropdown-item" href="#"
                                                                            onclick="event.preventDefault(); document.getElementById('approve-form-{{ $peminjaman->id }}').submit();">Setujui</a>
                                                                        <a class="dropdown-item" href="#"
                                                                            onclick="event.preventDefault(); document.getElementById('reject-form-{{ $peminjaman->id }}').submit();">Tolak</a>
                                                                    @elseif ($peminjaman->status == 'disetujui')
                                                                        <a class="dropdown-item" href="#"
                                                                            onclick="event.preventDefault(); document.getElementById('start-form-{{ $peminjaman->id }}').submit();">Mulai
                                                                            Peminjaman</a>
                                                                    @elseif ($peminjaman->status == 'berjalan')
                                                                        <a class="dropdown-item" href="#"
                                                                            onclick="event.preventDefault(); document.getElementById('finish-form-{{ $peminjaman->id }}').submit();">Selesaikan</a>
                                                                    @else
                                                                        <a class="dropdown-item text-muted"
                                                                            href="#">Tidak ada aksi</a>
                                                                    @endif
                                                                </div>

                                                                <!-- Hidden Forms for Actions -->
                                                                <form id="approve-form-{{ $peminjaman->id }}"
                                                                    action="{{ route('peminjaman.updateStatus', $peminjaman->id) }}"
                                                                    method="POST" class="d-none"> @csrf @method('PATCH')
                                                                    <input type="hidden" name="status" value="disetujui">
                                                                </form>
                                                                <form id="reject-form-{{ $peminjaman->id }}"
                                                                    action="{{ route('peminjaman.updateStatus', $peminjaman->id) }}"
                                                                    method="POST" class="d-none"> @csrf @method('PATCH')
                                                                    <input type="hidden" name="status" value="ditolak">
                                                                </form>
                                                                <form id="start-form-{{ $peminjaman->id }}"
                                                                    action="{{ route('peminjaman.updateStatus', $peminjaman->id) }}"
                                                                    method="POST" class="d-none"> @csrf @method('PATCH')
                                                                    <input type="hidden" name="status" value="berjalan">
                                                                </form>
                                                                <form id="finish-form-{{ $peminjaman->id }}"
                                                                    action="{{ route('peminjaman.updateStatus', $peminjaman->id) }}"
                                                                    method="POST" class="d-none"> @csrf @method('PATCH')
                                                                    <input type="hidden" name="status" value="selesai">
                                                                </form>
                                                            </div>
                                                        @else
                                                            <a href="#" class="btn btn-sm btn-secondary">Detail</a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @empty
                                                <tr>
                                                    <td colspan="6" class="text-center">Belum ada data peminjaman.</td>
                                                </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                <div class="float-right">
                                    {{ $peminjamans->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
