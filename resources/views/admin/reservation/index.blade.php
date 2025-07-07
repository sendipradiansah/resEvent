@include('admin/header')
<div class="container" style="padding-top:100px;">
    <!-- Baris tombol dan tabel -->
    <div class="d-flex justify-content-end align-items-center mb-4">
        <form action="{{ route('admin.reservation.index') }}" method="GET">
            <div class="d-flex align-center gap-2">
                <input type="text" id="search" name="search" class="form-control">
                <select name="checkin_status" class="form-control">
                    <option value="">-- Semua Status --</option>
                    <option value="1">Checked In</option>
                    <option value="0">Belum Check In</option>
                </select>
                <button type=" submit" class="btn btn-secondary">Cari</button>
                <a href="{{ route('admin.reservation.index') }}" class="btn btn-secondary">Reset</a>
            </div>
        </form>
    </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>No.</th>
                <th>Nama Event</th>
                <th>Deskripsi Event</th>
                <th>Jadwal Event</th>
                <th>Kuota Maksimal</th>
                <th>Nama Peserta</th>
                <th>Kode Unik</th>
                <th>Status</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @php $no = $reservations->firstItem(); @endphp
            @forelse($reservations as $reservation)
            <tr>
                <td>{{ $no++ }}.</td>
                <td>{{ $reservation->event->name }}</td>
                <td>{{ $reservation->event->description }}</td>
                <td>{{ date('d-M-Y H:i', strtotime($reservation->event->schedule)) }}</td>
                <td>{{ $reservation->event->max_quota }}</td>
                <td>{{ $reservation->user->name }}</td>
                <td>{{ $reservation->unique_code }}</td>
                <td>
                    @if($reservation->is_checked_in)
                    <span class="badge bg-success">Checked In</span>
                    @else
                    <span class="badge bg-secondary">Belum Check In</span>
                    @endif
                </td>
                <td class="text-center">
                    @if($reservation->is_checked_in)
                    <a href="{{ route('admin.reservation.show', $reservation->id) }}" class="btn btn-sm btn-warning mb-2" style="width: 90px;">Detail</a>
                    @else
                    <a href="{{ route('admin.checkin.form', $reservation->id) }}" class="btn btn-sm btn-success mb-2" style="width: 90px;">Check In</a>
                    @endif
                </td>
            </tr>
            @empty
            <div class="alert alert-danger">
                <span>Data event belum ada.</span>
            </div>
            @endforelse
        </tbody>
    </table>

    <!-- Pagination -->
    <div class="d-flex justify-content-center mt-4">
        {{ $reservations->links() }}
    </div>
</div>
@if(session('success'))
<script>
    window.addEventListener('DOMContentLoaded', () => {
        Swal.fire({
            icon: "success",
            title: "Berhasil",
            html: `{!! session('success') !!}`
        });
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
        });
    });
</script>
@endif
</body>

</html>