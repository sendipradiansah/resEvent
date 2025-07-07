<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
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
        $checkinStatus = $request->checkin_status;

        if (!empty($textSearch)) {

            $textSearchLower = strtolower($textSearch);
            //search status checkin

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
        }

        $reservations = Reservation::with(['user', 'event'])
            ->when($textSearch, function ($query) use ($textSearch) {
                $query->where(function ($query) use ($textSearch) {
                    $query->where('unique_code', 'like', '%' . $textSearch . '%')
                        ->orWhere('created_at', 'like', '%' . $textSearch . '%')
                        ->orWhereHas('user', function ($q) use ($textSearch) {
                            $q->where('name', 'like', '%' . $textSearch . '%');
                        })
                        ->orWhereHas('event', function ($q) use ($textSearch) {
                            $q->where('name', 'like', '%' . $textSearch . '%')
                                ->orWhere('description', 'like', '%' . $textSearch . '%')
                                ->orWhere('schedule', 'like', '%' . $textSearch . '%')
                                ->orWhere('max_quota', 'like', '%' . $textSearch . '%')
                                ->orWhereRaw('MONTHNAME(schedule) LIKE ?', ['%' . $textSearch . '%']);
                        });
                });
            })
            ->when($checkinStatus !== null && $checkinStatus !== '', function ($query) use ($checkinStatus) {
                if ($checkinStatus  == '1') {
                    $query->where('is_checked_in', true);
                } elseif ($checkinStatus  == '0') {
                    $query->where('is_checked_in', false);
                }
            })
            ->when($this->user->role !== 'admin', function ($query) {
                $query->where('user_id', $this->user->id);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // @dd($reservations);

        // $reservations = $query->latest()->paginate(3);

        $reservations->appends(['search' => $textSearch]);

        if ($this->user->role == 'admin') {
            return view('admin.reservation.index', compact('reservations'));
        }

        return view('user.reservation.index', compact('reservations'));
    }

    public function show(string $id)
    {
        $reservation = Reservation::with(['user', 'event'])->findOrFail($id);
        if ($this->user->role == 'admin') {
            return view('admin.reservation.show', compact('reservation'));
        }
        return view('user.reservation.show', compact('reservation'));
    }
    public function store(Event $event)
    {

        $user = $this->user;

        $exists = Reservation::where('user_id', $this->user->id)
            ->where('event_id', $event->id)
            ->exists();

        if ($exists) {
            return redirect()->route('event.index')->with(['error' => 'Maaf, Anda sudah terdaftar pada event ini.']);
        }


        $totalReservations = Reservation::where('event_id', $event->id)->count();

        // Cek kuota penuh?
        if ($totalReservations >= $event->max_quota) {
            return redirect()->route('event.index')->with(['error' => 'Maaf, kuota event sudah penuh.']);
        }

        $unique_code = $this->generateUniqueCode();

        // dd($request->all());

        Reservation::create([
            'user_id'       => $user->id,
            'event_id'      => $event->id,
            'unique_code'   => $unique_code
        ]);


        return redirect()->route('event.index')->with(['success' => 'Kode Unik Anda: <strong>' . $unique_code . '</strong>']);
    }

    public function showCheckin(string $id)
    {
        $reservation = Reservation::with(['user', 'event'])->findOrFail($id);

        return view('admin.checkin', compact('reservation'));
    }

    public function processCheckin(Request $request, string $id)
    {
        $request->validate([
            'unique_code' => 'required|string',
        ], [
            'unique_code.required'  => 'Kode Unik wajib diisi.',
            'unique_code.string'    => 'Kode Unik harus berupa teks.'
        ]);

        // Cari reservasi berdasarkan ID dulu
        $reservation = Reservation::find($id);

        if (!$reservation) {
            return redirect()->route('admin.checkin.form', $id)->with(['error' => 'Reservasi tidak ditemukan.']);
        }

        // Cek apakah unique_code yang diinput cocok dengan unique_code reservasi
        if ($reservation->unique_code !== $request->unique_code) {
            return redirect()->route('admin.checkin.form', $id)->with(['error' => 'Kode unik tidak cocok.']);
        }

        // Update status check-in
        $reservation->is_checked_in = true;
        $reservation->updated_at = date('Y-m-d H:i:s');
        $reservation->save();

        return redirect()->route('admin.reservation.index')->with(['success' => 'Selamat Anda berhasil checkin.']);
    }

    private function generateUniqueCode($length = 5)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);

        do {
            $randomCode = '';
            for ($i = 0; $i < $length; $i++) {
                $randomCode .= $characters[rand(0, $charactersLength - 1)];
            }

            $exists = Reservation::where('unique_code', $randomCode)->exists();
        } while ($exists);

        return $randomCode;
    }
}
