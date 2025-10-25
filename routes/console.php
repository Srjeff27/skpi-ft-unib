<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Purge legacy profile photos and set default avatars
Artisan::command('avatars:migrate', function () {
    $this->info('Migrating avatars: deleting legacy profile photos and setting defaults...');

    $count = 0;
    \App\Models\User::chunk(200, function ($users) use (&$count) {
        foreach ($users as $u) {
            // Delete file if exists
            if ($u->profile_photo_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($u->profile_photo_path)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($u->profile_photo_path);
            }

            // Ensure DB column cleared
            $u->profile_photo_path = null;

            // Set default avatar by role if not set
            if (empty($u->avatar)) {
                if ($u->role === 'admin') $u->avatar = 'admin';
                elseif ($u->role === 'verifikator') $u->avatar = 'verifikator';
                else $u->avatar = 'mahasiswa_male';
            }

            $u->save();
            $count++;
        }
    });

    $this->info("Processed {$count} users.");
})->purpose('Remove uploaded profile photos and assign default avatars');
