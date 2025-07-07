@include('user/header')
<div class="container" style="padding-top: 100px;">
    <div class="col-sm-12 border rounded-3 p-3">
        <div class="col-sm-12 mb-5">
            <h5>Detail Data Reservasi</h5>
        </div>
        <div class="col-sm-12">
            <div class="mb-3 row">
                <label for="name" class="col-sm-2 col-form-label">Nama Event</label>
                <div class="col-sm-10">
                    <span for="nim">{{ $reservation->event->name }}</span>
                </div>
            </div>

            <div class="mb-3 row">
                <label for="nama" class="col-sm-2 col-form-label">Deskripsi Event</label>
                <div class="col-sm-10">
                    <span for="nama">{{ $reservation->event->description }}</span>
                </div>
            </div>

            <div class="mb-3 row">
                <label for="email" class="col-sm-2 col-form-label">Jadwal Event</label>
                <div class="col-sm-10">
                    <span for="email">{{ $reservation->event->schedule }}</span>
                </div>
            </div>

            <div class="mb-3 row">
                <label for="telepon" class="col-sm-2 col-form-label">Maksimal Kuota</label>
                <div class="col-sm-10">
                    <span for="telepon">{{ $reservation->event->max_quota }}</span>
                </div>
            </div>

            <div class="mb-3 row">
                <label for="unique_code" class="col-sm-2 col-form-label">Kode Unik</label>
                <div class="col-sm-10">
                    <span for="unique_code">{{ $reservation->unique_code }}</span>
                </div>
            </div>

            <div class="mb-3 row">
                <label for="telepon" class="col-sm-2 col-form-label">Status Reservasi</label>
                <div class="col-sm-10">
                    @if($reservation->is_checked_in)
                    <span class="badge bg-success">Checked In</span>
                    @else
                    <span class="badge bg-secondary">Belum Check In</span>
                    @endif
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('reservation.index') }}" class="btn btn-primary">Kembali</a>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tanggal_lahir = flatpickr("#tanggal_lahir", {
            dateFormat: "Y-m-d",
            altFormat: "d F Y",
            altInput: true
        });
    });
</script>
</body>

</html>