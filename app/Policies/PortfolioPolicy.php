<?php

namespace App\Policies;

use App\Models\Portfolio;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PortfolioPolicy
{
    use HandlesAuthorization;

    private function inSameProdi(User $user, Portfolio $portfolio): bool
    {
        return $user->prodi_id !== null
            && $portfolio->user
            && $portfolio->user->prodi_id === $user->prodi_id;
    }

    public function viewAny(User $user): bool
    {
        return in_array($user->role, ['mahasiswa', 'verifikator', 'admin'], true);
    }

    public function view(User $user, Portfolio $portfolio): bool
    {
        if ($user->role === 'admin') {
            return true;
        }

        if ($user->role === 'verifikator') {
            return $this->inSameProdi($user, $portfolio);
        }

        return $user->id === $portfolio->user_id;
    }

    public function create(User $user): bool
    {
        return $user->role === 'mahasiswa';
    }

    public function update(User $user, Portfolio $portfolio): bool
    {
        if ($user->role === 'admin') {
            return true;
        }

        if ($user->role === 'verifikator') {
            return $this->inSameProdi($user, $portfolio);
        }

        return $user->id === $portfolio->user_id && $portfolio->status !== 'verified';
    }

    public function delete(User $user, Portfolio $portfolio): bool
    {
        if ($user->role === 'admin') {
            return true;
        }

        if ($user->role === 'verifikator') {
            return $this->inSameProdi($user, $portfolio);
        }

        return $user->id === $portfolio->user_id;
    }
}
