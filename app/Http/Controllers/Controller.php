<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Models\Wahana;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function dashboard()
    {
        ActivityLog::create([
            'action' => 'create',
            'user_id' => Session::get('id'), // ID pengguna yang sedang login
            'description' => 'User  Masuk Ke Dashboard.',
        ]);

        // Ambil data dengan status active (Bermain), urutkan berdasarkan durasi terpendek
        $playActive = DB::table('play')
            ->join('wahana', 'wahana.id_wahana', '=', 'play.id_wahana')
            ->whereIn('play.status', ['active', 'pending']) // Ambil yang active atau pending
            ->orderBy('play.end', 'asc') // Urutkan berdasarkan durasi terpendek
            ->select(
                'wahana.nama_wahana',
                'play.nama_anak',
                'play.nohp',
                'play.start',
                'play.end',
                'play.id_play',
                'play.durasi',
                'play.id_wahana',
                'play.status',
            )
            ->get();


        // Ambil data dengan status completed (Selesai), urutkan berdasarkan durasi terpendek
        $playCompleted = DB::table('play')
            ->join('wahana', 'wahana.id_wahana', '=', 'play.id_wahana')
            ->where('play.status', 'completed') // Hanya ambil yang completed
            ->orderBy('play.end', 'asc') // Urutkan berdasarkan durasi terpendek
            ->select(
                'wahana.nama_wahana',
                'play.nama_anak',
                'play.nohp',
                'play.start',
                'play.end',
                'play.id_play',
                'play.durasi',
                'play.id_wahana',
                'play.status',
            )
            ->get();

        // Ambil semua data wahana
        $wahana = Wahana::all();

        echo view('header');
        echo view('menu');
        echo view('dashboard', compact('wahana', 'playActive', 'playCompleted'));
        echo view('footer');
    }
}
