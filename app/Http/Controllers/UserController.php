<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\StoreRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    protected User $user;

    /**
     * Constructor for the class
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRequest $request
     * @return JsonResponse
     */
    public function store(StoreRequest $request): JsonResponse
    {
        $user = $this->user->create($request->validated());

        $token = $user->createToken($user->name . '-AuthToken')->plainTextToken;

        return response()->json([
            'access_token' => $token,
        ]);
    }
}
