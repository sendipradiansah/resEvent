@include('user/header')
<div class="container" style="padding-top: 100px;">
    <div class="col-sm-12 border rounded-3 p-3">
        <div class="col-sm-12 mb-5">
            <h5>Detail Data Event</h5>
        </div>
        <form action="{{ route('event.reservation', $event->id) }}" method="POST">
            @csrf
            <!-- <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
            <input type="hidden" name="event_id" value="{{ $event->id }}"> -->
            <div class="col-sm-12">
                <div class="mb-3 row">
                    <label for="name" class="col-sm-2 col-form-label">Nama Event</label>
                    <div class="col-sm-10">
                        <span for="nim">{{ $event->name }}</span>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="nama" class="col-sm-2 col-form-label">Deskripsi Event</label>
                    <div class="col-sm-10">
                        <span for="nama">{{ $event->description }}</span>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="email" class="col-sm-2 col-form-label">Jadwal Event</label>
                    <div class="col-sm-10">
                        <span for="email">{{ $event->schedule }}</span>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="telepon" class="col-sm-2 col-form-label">Maksimal Kuota</label>
                    <div class="col-sm-10">
                        <span for="telepon">{{ $event->max_quota }}</span>
                    </div>
                </div>

                <div class="mb-3 row">
                    <label for="telepon" class="col-sm-2 col-form-label">Total Pendaftar</label>
                    <div class="col-sm-10">
                        <span for="telepon">{{ $totalQuotaReserved }}</span>
                    </div>
                </div>
                @if(!$hasReserved)
                <div class="col-sm-5 mb-3">
                    <button type="submit" class="btn btn-success">Reservasi Sekarang!</a>
                </div>
                @else
                <div class="col-sm-5 mb-3">
                    <button type="submit" class="btn btn-secondary" disabled>Sudah Reservasi</a>
                </div>
                @endif

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('event.index') }}" class="btn btn-primary">Kembali</a>
                </div>
            </div>
        </form>
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