<?php

namespace App\Http\Controllers;

use App\Jobs\GiftJob;
use App\Models\User;
use App\Transformers\UserTransformer;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\ServerException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;

class UserController extends Controller
{
    public function __construct(
        private Manager $fractal,
        private UserTransformer $userTransformer
    ) {
    }

    public function index(): JsonResponse
    {
        $records = User::all();
        $collection = new Collection(
            $records,
            $this->userTransformer
        );
        $data = $this->fractal->createData($collection)->toArray();
        return response()->json($data);
    }

    public function get($id): JsonResponse
    {
        $record = User::query()->find($id);

        if ($record) {
            return response()->json($record);
        }

        return response()->json(['error' => 'Record not found'], 404);
    }

    public function create(Request $request): JsonResponse
    {
        $this->validate(
            $request,
            [
                'name'  => 'required|string',
                'email' => 'required|email|unique:users',
                'city'  => 'required|string',
                'password' => 'required|string'
            ]
        );

        $user = new User($request->all());
        $user->password = Hash::make($request->password);
        $user->save();
        $this->dispatch(new GiftJob());
        return response()->json([], Response::HTTP_CREATED);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $this->validate(
            $request,
            [
                'name'  => 'required|string',
                'email' => 'required|email|unique:users,email,' . $id . ',id',
                'city'  => 'required|string',
                'password' => 'required|string'
            ]
        );

        $user = User::query()->find($id);
        if ($user) {
            $user->fill($request->all());
            $user->password = Hash::make($request->password);
            $user->save();
            return response()->json($user, Response::HTTP_ACCEPTED);
        }

        return response()->json(['error' => 'Record not found'], Response::HTTP_NOT_FOUND);
    }

    public function delete($id): JsonResponse
    {
        $user = User::query()->find($id);
        if ($user) {
            $user->delete();
            return response()->json([], Response::HTTP_NO_CONTENT);
        }

        return response()->json(['error' => 'Record not found'], Response::HTTP_NOT_FOUND);
    }

    public function getCurrentLocation($id): JsonResponse
    {
        return response()->json([
            'method' => 'getCurrentLocation',
            'id' => $id
        ]);
    }

    public function setCurrentLocation(
        Request $request,
        $id,
        $latitude,
        $longitude
    ): JsonResponse {
        return response()->json([
            'method'    => 'setCurrentLocation',
            'id'        => $id,
            'latitude'  => $latitude,
            'longitude' => $longitude
        ]);
    }

    public function getWallet(int $id): JsonResponse
    {
        $client = new Client(['verify' => false]);
        try {
            $remoteCall = $client->get(
                'http://microservice_secret_nginx/api/v1/secrets/' . $id
            );
        } catch (ConnectException $e) {
            throw $e;
        } catch (ServerException $e) {
            throw $e;
        } catch (\Exception $e) {
            throw $e;
        }

        return response()->json(json_decode($remoteCall->getBody()));
    }
}
