<?php

return [
    'types' => [
        'full_time'  => 'Karyawan Tetap',
        'contract'   => 'Kontrak',
        'internship' => 'Magang',
    ],

    'benefit' => [
        'title'       => 'Benefit Karyawan',
        'subtitle'    => 'Kami peduli pada kesejahteraan dan perkembangan setiap anggota tim.',
        'intro_title' => 'Tumbuh Bersama Mirota',
        'intro_text'  => 'Bergabung dengan Mirota berarti menjadi bagian dari perusahaan yang berkarya sejak 1972 dengan lingkungan kerja yang saling mendukung.',
        'items' => [
            ['icon' => '🏥', 'title' => 'Jaminan Kesehatan',      'text' => '[Contoh] Perlindungan BPJS Kesehatan dan BPJS Ketenagakerjaan.'],
            ['icon' => '💰', 'title' => 'Tunjangan Hari Raya',    'text' => '[Contoh] THR sesuai ketentuan yang berlaku.'],
            ['icon' => '📚', 'title' => 'Pelatihan & Pengembangan', 'text' => '[Contoh] Program pelatihan untuk meningkatkan kompetensi.'],
            ['icon' => '📈', 'title' => 'Jenjang Karir',          'text' => '[Contoh] Kesempatan berkembang sesuai kinerja dan potensi.'],
            ['icon' => '🤝', 'title' => 'Lingkungan Kerja Positif', 'text' => '[Contoh] Budaya kerja yang kekeluargaan dan saling menghargai.'],
            ['icon' => '🥛', 'title' => 'Produk Karyawan',        'text' => '[Contoh] Potongan harga atau jatah produk Mirota.'],
        ],
        'cta_title'  => 'Tertarik Bergabung?',
        'cta_text'   => 'Lihat lowongan yang sedang dibuka dan kirim lamaran Anda.',
        'cta_button' => 'Lihat Lowongan',
    ],

    'team' => [
        'title'    => 'Tim Kami',
        'subtitle' => 'Orang-orang di balik produk dan layanan Mirota.',
        'empty'    => 'Data tim belum tersedia.',
        'intro' => 'Berikut orang-orang di balik produk, mutu, dan layanan PT Mirota KSM.',
    ],

    'jobs' => [
        'title'      => 'Lowongan Kerja',
        'subtitle'   => 'Temukan peluang karir bersama PT Mirota KSM.',
        'all'        => 'Semua',
        'view'       => 'Lihat detail',
        'deadline'   => 'Batas pendaftaran',
        'empty'      => 'Belum ada lowongan yang dibuka saat ini.',
        'empty_hint' => 'Pantau halaman ini secara berkala, atau hubungi kami melalui halaman kontak.',
        'closes_in'       => 'ditutup :days hari lagi',
        'closes_tomorrow' => 'ditutup besok',
        'closes_today'    => 'ditutup hari ini',
    ],

    
    'job' => [
        'description'  => 'Deskripsi Pekerjaan',
        'requirements' => 'Persyaratan',
        'back'         => 'Kembali ke daftar lowongan',
        'apply_title'  => 'Lamar Posisi Ini',

        'form_title' => 'Formulir Kerja',
        'position'   => 'Posisi yang dilamar',
        'full_name'  => 'Nama Lengkap',
        'address'    => 'Alamat domisili sekarang',
        'email'      => 'Alamat Email',
        'whatsapp'   => 'Nomor yang bisa dihubungi (WhatsApp)',

        'cv'         => 'CV (PDF)',
        'diploma'    => 'Ijazah (PDF)',
        'attachment' => 'Lampiran pendukung (PDF) (opsional)',

        'cv_name'         => 'CV',
        'diploma_name'    => 'Ijazah',
        'attachment_name' => 'Lampiran pendukung',

        'file_hint' => 'Format PDF, maks. 2 MB.',

        'file_too_big' => 'Ukuran :name terlalu besar (:size MB). Maksimal 2 MB. Silakan pilih berkas yang lebih kecil.',
        'file_bad_type' => 'Format :name tidak sesuai. Gunakan berkas PDF.',

        'error_files_hint' => 'Catatan: berkas (CV, Ijazah, Lampiran) perlu dipilih ulang, karena tidak tersimpan saat halaman dimuat ulang.',

        'err_required' => ':name wajib dilampirkan.',
        'err_max'      => 'Ukuran :name melebihi batas. Maksimal 2 MB.',
        'err_upload'   => 'Gagal mengunggah :name. Kemungkinan ukuran berkas melebihi batas 2 MB. Silakan pilih berkas yang lebih kecil.',
        'err_type'     => 'Format :name tidak sesuai. Gunakan berkas PDF.',

        'privacy' => 'Data dan CV Anda hanya digunakan untuk proses rekrutmen. Selengkapnya di',
        'submit'  => 'Kirim Lamaran',
        'sending' => 'Mengirim...',
        'error_summary' => 'Lamaran belum bisa dikirim. Mohon periksa isian berikut:',
    ],


    'apply_success' => 'Terima kasih! Lamaran Anda sudah kami terima. Tim kami akan menghubungi Anda bila profil Anda sesuai.',
];