<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;

class ProductPolicy
{
    /**
     * Admin bisa akses semua produk.
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

    public function view(User $user, Product $product): bool
    {
        return $user->id === $product->umkm->user_id;
    }

    public function create(User $user): bool
    {
        return true;
    }

    public function update(User $user, Product $product): bool
    {
        return $user->id === $product->umkm->user_id;
    }

    public function delete(User $user, Product $product): bool
    {
        return $user->id === $product->umkm->user_id;
    }
}
