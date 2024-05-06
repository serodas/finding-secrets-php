<?php

namespace App\Transformers;

use App\Models\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    public function transform(User $user): array
    {
        return [
            'id'    => $user->id,
            'name'  => $user->name,
            'city'  => $user->city,
        ];
    }
}
