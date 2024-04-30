<?php

namespace App\Transformers;

use App\Models\Secret;
use League\Fractal\TransformerAbstract;

class SecretTransformer extends TransformerAbstract
{
    public function transform(Secret $secret): array
    {
        return [
            'id' => $secret->id,
            'name' => $secret->name,
            'location' => [
                'latitude' => $secret->latitude,
                'longitude' => $secret->longitude,
                'name' => $secret->location_name
            ]
        ];
    }
}
