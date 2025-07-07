@include('admin/header')
<div class="container" style="padding-top:100px;">
    <!-- Baris tombol dan tabel -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('admin.event.create') }}" class="btn btn-primary">Tambah Data</a>
        <form action="{{ route('admin.event.index') }}" method="GET">
            <div class="d-flex align-center gap-2">
                <input type="text" id="search" name="search" class="form-control">
                <button type=" submit" class="btn btn-secondary">Cari</button>
                <a href="{{ route('admin.event.index') }}" class="btn btn-secondary">Reset</a>
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
                <td class="text-center">
                    <form action="{{ route('admin.event.destroy', $event->id) }}" method="POST">
                        <a href="{{ route('admin.event.show', $event->id) }}" class="btn btn-sm btn-warning">Detail</a>
                        <a href="{{ route('admin.event.edit', $event->id) }}" class="btn btn-sm btn-primary">Ubah</a>
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger btn-delete">Hapus</button>
                    </form>
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
            text: "{{ session('success') }}",
            showConfirmButton: false,
            timer: 2000
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
        })
    });
</script>
@endif
<script>
    document.addEventListener("DOMContentLoaded", function() {

        const btnDeleted = document.querySelectorAll('.btn-delete');

        btnDeleted.forEach(button => {
            button.addEventListener("click", function(e) {
                e.preventDefault();
                const form = this.closest("form");

                Swal.fire({
                    title: "Apakah Anda yakin?",
                    text: "Data yang terhapus tidak dapat dikembalikan",
                    icon: "warning",
                    showCancelButton: true,
                    cancelButtonText: "Batal",
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Ya, hapus data ini!"
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>
</body>

</html>