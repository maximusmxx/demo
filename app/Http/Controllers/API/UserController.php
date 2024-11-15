<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\User\IndexRequest;
use App\Http\Requests\API\User\StoreRequest;
use App\Http\Requests\API\User\UpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(IndexRequest $request): AnonymousResourceCollection
    {
        $data = $request->validated();
        $users = User::paginate($data['per_page'] ?? 10);

        return UserResource::collection($users);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): JsonResponse
    {
        return response()->json([
            'message' => 'Method Not Allowed'
        ], 405);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request): UserResource
    {
        $data = $request->validated();
        $data['email'] = Str::lower($data['email']);
        if (!$request->has('ip_address')) {
            $data['ip_address'] = request()->ip();
        }
        $user = User::create($data);

        return UserResource::make($user);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): UserResource
    {
        return UserResource::make($user);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user): JsonResponse
    {
        return response()->json([
            'message' => 'Method Not Allowed'
        ], 405);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, User $user): UserResource
    {
        $data = $request->validated();
        if ($request->has('email')) {
            $data['email'] = Str::lower($data['email']);
        }
        $user->update($data);
        $user->fresh();

        return UserResource::make($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): Application|Response|ResponseFactory
    {
        $user->delete();

        return response(null, 204);
//        return response()->json([
//            'message' => 'User deleted successfully'
//        ]);
    }
}
