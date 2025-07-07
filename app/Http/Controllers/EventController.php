<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

use Illuminate\Support\Facades\Auth;

use App\Models\Event;
use Illuminate\Support\Facades\Redirect;

class EventController extends Controller
{
    //
    protected $user;

    public function __construct()
    {
        $this->user = Auth::user();
    }
    public function index(Request $request)
    {
        $textSearch = $request->search;

        $query = Event::query();

        if (!empty($textSearch)) {

            // search bulan berdasarkan nama
            $bulanIndoToEng = [
                'januari' => 'January',
                'februari' => 'February',
                'maret' => 'March',
                'april' => 'April',
                'mei' => 'May',
                'juni' => 'June',
                'juli' => 'July',
                'agustus' => 'August',
                'september' => 'September',
                'oktober' => 'October',
                'november' => 'November',
                'desember' => 'December',
            ];

            $textSearchLower = strtolower($textSearch);
            $foundMonth = null;

            // Coba cari kemiripan dari awal kata bulan
            foreach ($bulanIndoToEng as $indo => $eng) {
                if (strpos($indo, $textSearchLower) !== false) {
                    $foundMonth = $eng;
                    break;
                }
            }

            // Jika ditemukan match bulan, ubah $textSearch ke nama bulan Inggris
            if ($foundMonth) {
                $textSearch = $foundMonth;
            }


            $query->where('name', 'like', '%' . $textSearch . '%')
                ->orWhere('description', 'like', '%' . $textSearch . '%')
                ->orWhere('schedule', 'like', '%' . $textSearch . '%')
                ->orWhere('max_quota', 'like', '%' . $textSearch . '%')
                ->orWhereRaw('MONTHNAME(schedule) LIKE ?', ['%' . $textSearch . '%']);
        }

        $events = $query->latest()->paginate(10);

        // dd($events);

        $events->appends(['search' => $textSearch]);

        if ($this->user->role == 'admin') {
            return view('admin.event.index', compact('events'));
        }
        return view('user.event.index', compact('events'));
    }

    public function create()
    {
        return view('admin.event.create');
    }

    public function store(Request $request): RedirectResponse
    {

        $request->validate([
            'name'          => 'required',
            'description'   => 'required|max:255',
            'schedule'      => 'required|date',
            'max_quota'     => 'required|numeric'
        ], [
            'name.required'         => 'Nama Event wajib diisi.',
            'description.required'  => 'Deskripsi Event wajib diisi.',
            'description.max'       => 'Maksimal 255 karakter.',
            'schedule.required'     => 'Jadwal Event wajib diisi.',
            'schedule.date'         => 'Format Jadwal tidak valid.',
            'max_quota.required'    => 'Kuota Maksimal wajib diisi.',
            'max_quota.numeric'     => 'Kuota Maksimal wajib berisi angka.'
        ]);

        Event::create([
            'name'          => $request->name,
            'description'   => $request->description,
            'schedule'      => $request->schedule,
            'max_quota'     => $request->max_quota
        ]);

        return redirect()->route('admin.event.index')->with(['success' => 'Data berhasil ditambah!']);
    }

    public function show(string $id)
    {
        $event = Event::findOrFail($id);

        $totalQuotaReserved = $event->reservations()->count();

        $hasReserved = $event->reservations()->where('user_id', $this->user->id)->exists();

        if ($this->user->role == 'admin') {
            return view('admin.event.show', compact('event', 'totalQuotaReserved'));
        }

        return view('user.event.show', compact('event', 'totalQuotaReserved', 'hasReserved'));
    }

    public function edit(string $id)
    {
        $event = Event::findOrFail($id);

        return view('admin.event.edit', compact('event'));
    }

    public function update(Request $request, string $id): RedirectResponse
    {

        // dd($request->all());
        $event = Event::findOrFail($id);

        $request->validate([
            'name'          => 'required',
            'description'   => 'required|max:255',
            'schedule'      => 'required|date',
            'max_quota'     => 'required|numeric'
        ], [
            'name.required'         => 'Nama Event wajib diisi.',
            'description.required'  => 'Deskripsi Event wajib diisi.',
            'description.max'       => 'Maksimal 255 karakter.',
            'schedule.required'     => 'Jadwal Event wajib diisi.',
            'schedule.date'         => 'Format Jadwal tidak valid.',
            'max_quota.required'    => 'Kuota Maksimal wajib diisi.',
            'max_quota.numeric'     => 'Kuota Maksimal wajib berisi angka.'
        ]);

        $event->update([
            'name'          => $request->name,
            'description'   => $request->description,
            'schedule'      => $request->schedule,
            'max_quota'     => $request->max_quota
        ]);

        return redirect()->route('admin.event.index')->with(['success' => 'Data berhasil diubah!']);
    }

    public function destroy(string $id): RedirectResponse
    {
        $event = Event::findOrFail($id);
        $event->delete();

        return redirect()->route('admin.event.index')->with(['success' => 'Data berhasil dihapus!']);
    }
}
