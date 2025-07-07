@include('admin/header')
<div class="container" style="padding-top: 100px;">
    <div class="col-sm-12 border rounded-3 p-3">
        <div class="col-sm-12 mb-5">
            <h5>Detail Data Reservasi</h5>
        </div>
        <form action="{{ route('admin.checkin.process', $reservation->id) }}" method="POST">
            @csrf
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
                    <label for="telepon" class="col-sm-2 col-form-label">Status Reservasi</label>
                    <div class="col-sm-10">
                        @if($reservation->is_checked_in)
                        <span class="badge bg-success">Checked In</span>
                        @else
                        <span class="badge bg-secondary">Belum Check In</span>
                        @endif
                    </div>
                </div>

                @if(!$reservation->is_checked_in)
                <div class="mb-3 row">
                    <label for="unique_code" class="col-sm-2 col-form-label">Kode Unik</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="unique_code" autocomplete="off">
                        @error('unique_code')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                @endif

                @if(!$reservation->is_checked_in)
                <div class="col-sm-5 mb-3">
                    <button type="submit" class="btn btn-success">Check In!</button>
                </div>
                @endif

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.reservation.index') }}" class="btn btn-primary">Kembali</a>
                </div>
            </div>
        </form>
    </div>
</div>

@if(session('success'))
<script>
    window.addEventListener('DOMContentLoaded', () => {
        Swal.fire({
            icon: "success",
            title: "Berhasil",
            text: "{{ session('success') }}",
            showConfirmButton: false,
            timer: 2000
        })
    });
</script>
@elseif(session('error'))
<script>
    window.addEventListener('DOMContentLoaded', () => {
        Swal.fire({
            icon: "error",
            title: "Gagal!",
            text: "{{ session('error') }}",
            showConfirmButton: false,
            timer: 2000
        })
    });
</script>
@endif
</body>

</html>