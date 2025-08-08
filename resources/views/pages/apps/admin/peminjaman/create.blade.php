@extends('layouts.app')

@section('title', 'Form Peminjaman Laboratorium')

@push('style')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <style>
        .flatpickr-day.booked-day {
            background-color: #f8d7da !important;
            border-color: #f5c6cb !important;
            color: #721c24 !important;
            font-weight: bold;
        }

        .flatpickr-day.booked-day:hover {
            background-color: #f1b0b7 !important;
        }
    </style>
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
                                <input type="text" id="waktu_peminjaman" name="waktu_peminjaman"
                                    class="form-control @error('waktu_peminjaman') is-invalid @enderror"
                                    value="{{ old('waktu_peminjaman') }}" required readonly
                                    placeholder="Pilih laboratorium terlebih dahulu">
                                @error('waktu_peminjaman')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="penanggung_jawab">Nama Penanggung Jawab</label>
                                <input type="text" id="penanggung_jawab" name="penanggung_jawab"
                                    class="form-control @error('penanggung_jawab') is-invalid @enderror"
                                    value="{{ old('penanggung_jawab', auth()->user()->name) }}" required>
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
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let datepickerInstance = null;
            const dateInput = document.getElementById('waktu_peminjaman');
            const laborSelect = document.getElementById('labor_id');

            function setupDatepicker(bookedDates = []) {
                if (datepickerInstance) {
                    datepickerInstance.destroy();
                }

                datepickerInstance = flatpickr(dateInput, {
                    enableTime: true,
                    dateFormat: "Y-m-d H:i",
                    minDate: "today",
                    disable: bookedDates,

                    onDayCreate: function(dObj, dStr, fp, dayElem) {
                        const y = dayElem.dateObj.getFullYear();
                        const m = String(dayElem.dateObj.getMonth() + 1).padStart(2, '0');
                        const d = String(dayElem.dateObj.getDate()).padStart(2, '0');
                        const localDateString = `${y}-${m}-${d}`;
                        if (bookedDates.includes(localDateString)) {
                            dayElem.classList.add("booked-day");
                        }
                    },
                    locale: {
                        "firstDayOfWeek": 1
                    },
                });
                dateInput.placeholder = "Silakan pilih tanggal dan waktu";
            }

            function fetchBookedDates() {
                const laborId = laborSelect.value;
                if (!laborId) return;

                const url = `/peminjaman/booked-dates/${laborId}`;
                dateInput.value = '';
                dateInput.placeholder = 'Memuat jadwal...';
                dateInput.removeAttribute('disabled');

                fetch(url)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(bookedDates => {
                        setupDatepicker(bookedDates);
                    })
                    .catch(error => {
                        console.error('Error fetching booked dates:', error);
                        dateInput.placeholder = 'Gagal memuat jadwal. Coba lagi.';
                    });
            }

            // Tambahkan event listener ke dropdown laboratorium
            laborSelect.addEventListener('change', fetchBookedDates);

            // Inisialisasi awal
            if (laborSelect.value) {
                fetchBookedDates(); // Jika ada nilai (misal dari old input), langsung muat jadwal
            } else {
                dateInput.setAttribute('disabled',
                    'disabled'); // Nonaktifkan input tanggal jika belum ada lab dipilih
            }
        });
    </script>
@endpush
