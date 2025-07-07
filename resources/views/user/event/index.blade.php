@include('user/header')
<div class="container" style="padding-top:100px;">
    <!-- Baris tombol dan tabel -->
    <div class="d-flex justify-content-end align-items-center mb-4">
        <form action="{{ route('event.index') }}" method="GET">
            <div class="d-flex align-center gap-2">
                <input type="text" id="search" name="search" class="form-control">
                <button type=" submit" class="btn btn-secondary">Cari</button>
                <a href="{{ route('event.index') }}" class="btn btn-secondary">Reset</a>
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
                <th class="w-10">Kuota Maksimal</th>
                <th class="w-10">Total Pendaftar</th>
                <th class="text-center">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @php $no = $events->firstItem(); @endphp
            @forelse($events as $event)
            <tr>
                <td>{{ $no++ }}.</td>
                <td>{{ $event->name }}</td>
                <td class="w-25">{{ $event->description }}</td>
                <td>{{ date('d-M-Y H:i', strtotime($event->schedule)) }}</td>
                <td>{{ $event->max_quota }}</td>
                <td>{{ $event->reservations_count }}</td>
                <td class="text-center">
                    <a href="{{ route('event.show', $event->id) }}" class="btn btn-sm btn-warning">Detail</a>
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
        {{ $events->links() }}
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