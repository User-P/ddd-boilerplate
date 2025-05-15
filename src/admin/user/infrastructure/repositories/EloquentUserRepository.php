<?php

namespace Src\admin\user\infrastructure\repositories;

use App\Models\User as EloquentUser;
use Src\admin\user\domain\contracts\UserRepositoryInterface;
use Src\admin\user\domain\entities\User;

class EloquentUserRepository implements UserRepositoryInterface
{
    public function findById(int $id): ?User
    {
        $user = EloquentUser::find($id);

        if (!$user) {
            return null;
        }
        return new User(
            $user->id,
            $user->name,
            $user->email
        );
    }

    public function save(User $user): void
    {

        EloquentUser::updateOrCreate(
            ['id' => $user->id()],
            [
                'name' => $user->name()->value(),
                'email' => $user->email()->value(),
            ]
        );
    }
}
