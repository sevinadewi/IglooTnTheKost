<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Tenant;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class KirimPengingatTagihan extends Command
{
   
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pengingat:tagihan';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mengirim pengingat tagihan ke tenant';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $today = Carbon::now();
        $tenants = Tenant::all();

        foreach ($tenants as $tenant) {
            if(!$tenant->email) continue;

            $tanggalMasuk = Carbon::parse($tenant->tanggal);
            $jatuhTempoBulanIni = $tanggalMasuk->copy()->day($tanggalMasuk->day)->month($today->month)->year($today->year);

            // Jika sudah lewat, ambil bulan depan
            if ($jatuhTempoBulanIni->lt($today)) {
                $jatuhTempoBulanIni->addMonth();
            }

            // Kirim jika 7 hari lagi jatuh tempo
            // if ($today->diffInDays($jatuhTempoBulanIni) === 7) {
            //     Mail::to($tenant->email)->send(new \App\Mail\PengingatTagihanMail($tenant));
            //     $this->info('Email dikirim ke: ' . $tenant->nama . ' (' . $tenant->email . ')');
            // }

            Mail::to($tenant->email)->send(new \App\Mail\PengingatTagihanMail($tenant));


        }
       $this->info('Pengingat tagihan dikirim!');
    }
}
