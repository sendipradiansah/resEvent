@include('admin/header')
<div class="container" style="padding-top:100px;">
    <div class="row">
        <div class="col-sm-12 border rounded-3 p-3">
            <div class="col-sm-12 mb-5">
                <h5>Tambah Data Event</h5>
            </div>
            <div class="col-sm-12">
                <form action="{{ route('admin.event.store') }}" method="POST">
                    @csrf

                    <div class="mb-3 row">
                        <label for="name" class="col-sm-2 col-form-label">Nama Event</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" autocomplete="off">
                            @error('name')
                            <label class="text-danger mt-2">
                                {{ $message }}
                            </label>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="description" class="col-sm-2 col-form-label">Deskripsi Event</label>
                        <div class="col-sm-10">
                            <textarea class="form-control" name="description" id="description" rows="5" autocomplete="off">{{ old('description') }}</textarea>
                            @error('description')
                            <label class=" text-danger mt-2">
                                {{ $message }}
                            </label>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="schedule" class="col-sm-2 col-form-label">Jadwal Event</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="schedule" name="schedule" value="{{ old('schedule') }}">
                            @error('schedule')
                            <label class="text-danger mt-2">
                                {{ $message }}
                            </label>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label for="max_quota" class="col-sm-2 col-form-label">Maksimal Kuota</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" id="max_quota" name="max_quota" value="{{ old('max_quota') }}" autocomplete="off">
                            @error('max_quota')
                            <label class="text-danger mt-2">
                                {{ $message }}
                            </label>
                            @enderror
                        </div>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {

        const schedule = flatpickr("#schedule", {
            dateFormat: "Y-m-d H:i",
            altInput: true,
            altFormat: "d-M-Y H:i",
            enableTime: true,
            time_24hr: true
        });
    });
</script>
</body>

</html>