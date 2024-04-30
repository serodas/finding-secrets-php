<?php

namespace App\Http\Controllers;

use App\Models\Secret;
use App\Transformers\SecretTransformer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;

class SecretController extends Controller
{
    public function __construct(
        private Manager $fractal,
        private SecretTransformer $secretTransformer
    ) {
    }

    public function index(Request $request): JsonResponse
    {
        $records = Secret::all();
        $collection = new Collection(
            $records,
            $this->secretTransformer
        );
        $data = $this->fractal->createData($collection)->toArray();
        return response()->json($data);
    }

    public function create(Request $request): void
    {
        $this->validate(
            $request,
            [
                'name' => 'required|string|unique:secrets,name',
                'latitude' => 'required|numeric',
                'longitude' => 'required|numeric',
                'location_name' => 'required|string'
            ]
        );

        $secret = Secret::create($request->all());
        $secret->save();
    }
}
