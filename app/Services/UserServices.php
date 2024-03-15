<?php 

namespace App\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UserServices
{
    public function getRandomUsers(int $number): Collection
    {
        return User::take(4)->get();
    }
}