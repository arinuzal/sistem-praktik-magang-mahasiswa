<?php

namespace App\Mail;

use App\Models\Penilaian;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NilaiPraktikMail extends Mailable
{
    use Queueable, SerializesModels;

    public $penilaian;

    public function __construct(Penilaian $penilaian)
    {
        $this->penilaian = $penilaian;
    }

    public function build()
    {
        return $this->subject('Penilaian Mahasiswa Magang')
                    ->markdown('emails.nilai_praktik');
    }
}
