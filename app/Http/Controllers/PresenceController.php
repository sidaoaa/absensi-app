<?php

namespace App\Http\Controllers;

use App\Models\Presence;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon as SupportCarbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PresenceController extends Controller
{
    // Display the list of presences
    public function index()
    {
        // Fetch all presence records for the logged-in user, ordered by 'in_time'
        $presences = Presence::where('user_id', Auth::user()->id)
            ->orderBy('in_time', 'asc')
            ->get();

        return view('presence.index', compact('presences'));
    }

    // Show the sign-in form
    public function signIn()
    {
        // Check if the user has already signed in today
        $hasSignedIn = Presence::where('user_id', Auth::user()->id)
            ->whereDate('in_time', Carbon::today())
            ->exists();

        if ($hasSignedIn) {
            return redirect()->route('presence.index')->with('danger', 'Kamu Sudah Absen Masuk Hari Ini');
        }

        return view('presence.sign_in');
    }

    // Store sign-in information
    public function storeSignIn(Request $request)
    {
        // Validate the request
        $request->validate([
            'image' => 'required|string',
            'in_location' => 'nullable|string',
        ]);

        if ($request->image) {
            // Set time bounds for on-time sign-in
            $now = Carbon::now();
            $start = Carbon::createFromTimeString('07:00');
            $end = Carbon::createFromTimeString('18:00');

            $status = $now->between($start, $end) ? "tepat" : "telat";

            // Handle image upload
            $base64string = $request->input('image');
            $image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64string));
            $image_name = uniqid() . '.jpeg';

            $upload = Storage::disk('local')->put("public/absensi/masuk/$image_name", $image);

            if ($upload) {
                // Store the presence record
                $presence = Presence::create([
                    'user_id' => Auth::user()->id,
                    'in_image' => $image_name,
                    'in_time' => now(),
                    'in_info' => $status,
                    'in_location' => $request->input('in_location', null),
                ]);

                return $presence
                    ? redirect()->route('presence.index')->with('success', 'Absensi Masuk Berhasil')
                    : redirect()->route('presence.sign_in')->with('danger', 'Absensi Masuk Gagal');
            } else {
                return redirect()->route('presence.sign_in')->with('danger', 'Upload Gagal');
            }
        } else {
            return redirect()->route('presence.sign_in')->with('danger', 'Gambar tidak ada');
        }
    }

    // Show the sign-out form
    public function signOut()
    {
        // Check if the user has already signed out today
        $hasSignedOut = Presence::where('user_id', Auth::user()->id)
            ->whereDate('out_time', Carbon::today())
            ->exists();

        // Check if the user has signed in today
        $hasSignedIn = Presence::where('user_id', Auth::user()->id)
            ->whereDate('in_time', Carbon::today())
            ->exists();

        if ($hasSignedOut) {
            return redirect()->route('presence.index')->with('danger', 'Kamu Sudah Absen Keluar Hari Ini');
        }

        if (!$hasSignedIn) {
            return redirect()->route('presence.index')->with('danger', 'Kamu Belum Absen Masuk Hari Ini');
        }

        return view('presence.sign_out');
    }

    // Store sign-out information
    public function storeSignOut(Request $request)
    {
        // Validate the request
        $request->validate([
            'image' => 'required|string',
            'out_location' => 'nullable|string',
        ]);

        if ($request->image) {
            // Set time bounds for on-time sign-out
            $now = Carbon::now();
            $start = Carbon::createFromTimeString('16:00');
            $end = Carbon::createFromTimeString('18:00');

            $status = $now->between($start, $end) ? "tepat" : "bolos";

            // Handle image upload
            $base64string = $request->input('image');
            $image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $base64string));
            $image_name = uniqid() . '.jpeg';

            $upload = Storage::disk('local')->put("public/absensi/keluar/$image_name", $image);

            if ($upload) {
                // Update the presence record
                $updated = Presence::where('user_id', Auth::user()->id)
                    ->whereDate('in_time', Carbon::today())
                    ->update([
                        'out_image' => $image_name,
                        'out_time' => now(),
                        'out_info' => $status,
                        'out_location' => $request->input('out_location', null),
                    ]);

                return $updated
                    ? redirect()->route('presence.index')->with('success', 'Absensi Keluar Berhasil')
                    : redirect()->route('presence.sign_out')->with('danger', 'Absensi Keluar Gagal');
            } else {
                return redirect()->route('presence.sign_out')->with('danger', 'Upload Gagal');
            }
        } else {
            return redirect()->route('presence.sign_out')->with('danger', 'Gambar tidak ada');
        }
    }
    

    // Generate and display the report
    public function report(Request $request)
{
    // Mendapatkan tanggal dari request atau menggunakan tanggal hari ini jika tidak ada
    $date = $request->input('date', Carbon::today()->format('Y-m-d'));

    // Mengambil data absensi untuk tanggal tertentu
    $attendances = Presence::whereDate('in_time', $date)
        ->with('user') // Memuat relasi user jika ada
        ->get();

    // Menghitung total absensi
    $totalInPresent = $attendances->count();

    // Menyiapkan data untuk dikirim ke view
    return view('admin.report', [
        'attendances' => $attendances,
        'summary' => [
            'total_inpresent' => $totalInPresent,
        ],
        'date' => $date,
    ]);
}

}
