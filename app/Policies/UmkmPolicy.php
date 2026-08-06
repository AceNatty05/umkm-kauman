<?php

namespace App\Policies;

use App\Models\Umkm;
use App\Models\User;

class UmkmPolicy
{
    /**
     * Admin bisa akses semua UMKM.
     */
    public function before(User $user, string $ability): ?bool
    {
        if ($user->isAdmin()) {
            return true;
        }
        return null;
    }

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Umkm $umkm): bool
    {
        return $user->id === $umkm->user_id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Umkm $umkm): bool
    {
        return $user->id === $umkm->user_id;
    }

    public function delete(User $user, Umkm $umkm): bool
    {
        return $user->id === $umkm->user_id;
    }
}
