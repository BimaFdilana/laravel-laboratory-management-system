@extends('layouts.app')
@section('title', 'Dashboard')
@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>{{ Auth::user()->role_id == 1 ? 'Dashboard Admin' : 'Dashboard Mahasiswa' }}</h1>
            </div>
            <div class="section-body">
                {{-- Bagian Statistik (Tampil untuk semua role) --}}
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
                <div class="row">
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-primary"><i class="fas fa-building"></i></div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Total Laboratorium</h4>
                                </div>
                                <div class="card-body">{{ $totalLabor }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-success"><i class="fas fa-check-circle"></i></div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Lab Tersedia</h4>
                                </div>
                                <div class="card-body">{{ $labTersedia }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-danger"><i class="fas fa-exclamation-circle"></i></div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Lab Tidak Tersedia</h4>
                                </div>
                                <div class="card-body">{{ $labTidakTersedia }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                        <div class="card card-statistic-1">
                            <div class="card-icon bg-warning"><i class="far fa-user"></i></div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Total User</h4>
                                </div>
                                <div class="card-body">{{ $totalUser }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Bagian Konten Dinamis Berdasarkan Role --}}
                <div class="row">
                    <div class="col-lg-12">
                        @if (Auth::user()->role_id == 1)
                            {{-- TAMPILAN UNTUK ADMIN --}}
                            <div class="card">
                                <div class="card-header">
                                    <h4>History Peminjaman Terbaru</h4>
                                    <div class="card-header-action"><a href="{{ route('peminjaman.index') }}"
                                            class="btn btn-primary">Lihat Semua</a></div>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Peminjam</th>
                                                    <th>Laboratorium</th>
                                                    <th>Waktu Pinjam</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($historyPeminjaman as $peminjaman)
                                                    <tr>
                                                        <td>{{ $peminjaman->user->name ?? 'N/A' }}</td>
                                                        <td>{{ $peminjaman->labor->nama_labor ?? 'N/A' }}</td>
                                                        <td>{{ $peminjaman->waktu_peminjaman->format('d M Y, H:i') }}</td>
                                                        <td>
                                                            @php $statusClass = ['diajukan'=>'badge-warning', 'disetujui'=>'badge-success', 'ditolak'=>'badge-danger', 'berjalan'=>'badge-info', 'selesai'=>'badge-secondary']; @endphp
                                                            <span
                                                                class="badge {{ $statusClass[$peminjaman->status] ?? 'badge-light' }}">{{ $peminjaman->status }}</span>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="4" class="text-center">Belum ada riwayat peminjaman.
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @elseif (Auth::user()->role_id == 2)
                            {{-- TAMPILAN UNTUK USER --}}
                            <div class="card">
                                <div class="card-header">
                                    <h4>Pemberitahuan Terbaru</h4>
                                </div>
                                <div class="card-body">
                                    <ul class="list-unstyled list-unstyled-border">
                                        @php $firstUnreadShown = false; @endphp
                                        @forelse($userNotifications as $notification)
                                            <li class="media">
                                                <div class="media-icon"><i class="far fa-bell"></i></div>
                                                <div class="media-body">
                                                    <div class="float-right text-right">
                                                        <div class="text-primary">
                                                            {{ $notification->created_at->diffForHumans() }}</div>
                                                        @if (!$notification->is_read && !$firstUnreadShown)
                                                            <span class="badge badge-success">Baru</span>
                                                            @php $firstUnreadShown = true; @endphp
                                                        @endif
                                                    </div>
                                                    <div class="media-title">
                                                        Pemberitahuan
                                                    </div>
                                                    <span class="text-small text-muted">{{ $notification->message }}</span>
                                                </div>
                                            </li>
                                        @empty
                                            <li class="text-center p-3">Tidak ada pemberitahuan.</li>
                                        @endforelse

                                    </ul>
                                    <div class="text-center pt-1 pb-1">{{ $userNotifications->links() }}</div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <h4>Daftar Laboratorium</h4>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Nama Lab</th>
                                                    <th>Gambar</th>
                                                    <th>Kapasitas</th>
                                                    <th>Penanggung Jawab</th>
                                                    <th>Ketersediaan</th>
                                                    <th class="text-center">Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($labors as $labor)
                                                    <tr>
                                                        <td>{{ $labor->nama_labor }}</td>
                                                        <td><img src="{{ asset('storage/' . $labor->image_path) }}"
                                                                alt="Gambar Lab" width="100"
                                                                onerror="this.onerror=null;this.src='https://placehold.co/100x80/e2e8f0/e2e8f0?text=No+Image';">
                                                        </td>
                                                        <td>{{ $labor->kapasitas ?? 'N/A' }} Orang</td>
                                                        <td>{{ $labor->penanggung_jawab ?? 'N/A' }}</td>
                                                        <td>
                                                            @if (in_array($labor->id, $bookedLabIds))
                                                                <span class="badge badge-danger">Tidak Tersedia</span>
                                                            @else
                                                                <span class="badge badge-success">Tersedia</span>
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            @if (!in_array($labor->id, $bookedLabIds))
                                                                <a href="{{ route('peminjaman.create', ['labor_id' => $labor->id]) }}"
                                                                    class="btn btn-primary">Pinjam</a>
                                                            @else
                                                                <button class="btn btn-secondary" disabled>Pinjam</button>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="6" class="text-center">Data laboratorium tidak
                                                            ditemukan.</td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endif
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
