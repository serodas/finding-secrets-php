<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\ServerException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $userCache = [
        1 => [
            'name' => 'John',
            'city' => 'Barcelona'
        ],
        2 => [
            'name' => 'Joe',
            'city' => 'Paris'
        ]
    ];
    public function index(): JsonResponse
    {
        return response()->json(['method' => 'index']);
    }

    public function get($id): JsonResponse
    {
        return response()->json(
            $this->userCache[$id]
        );
    }

    public function create(Request $request): JsonResponse
    {
        return response()->json(['method' => 'create']);
    }

    public function update(Request $request, $id): JsonResponse
    {
        return response()->json(['method' => 'update', 'id' => $id]);
    }

    public function delete($id): JsonResponse
    {
        return response()->json(['method' => 'delete', 'id' => $id]);
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

        return response()->json(
            [
                'data'       => json_decode($remoteCall->getBody()),
            ]
        );
    }
}
