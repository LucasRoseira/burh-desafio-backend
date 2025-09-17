<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Requests\UserSearchRequest;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Tag(
 *     name="Users",
 *     description="API Endpoints for Users"
 * )
 */
class UserController extends Controller
{
    protected $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    /**
     * @OA\Get(
     *     path="/users",
     *     summary="List all users",
     *     tags={"Users"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/User"))
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        return response()->json($this->service->list());
    }

    /**
     * @OA\Get(
     *     path="/users/{id}",
     *     summary="Get a specific user",
     *     tags={"Users"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Successful operation", @OA\JsonContent(ref="#/components/schemas/User")),
     *     @OA\Response(response=404, description="User not found")
     * )
     */
    public function show(int $id): JsonResponse
    {
        return response()->json($this->service->get($id));
    }

    /**
     * @OA\Post(
     *     path="/users",
     *     summary="Create a new user",
     *     tags={"Users"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/UserRequest")
     *     ),
     *     @OA\Response(response=201, description="User created successfully", @OA\JsonContent(ref="#/components/schemas/User")),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function store(UserRequest $request): JsonResponse
    {
        return response()->json($this->service->create($request->validated()), 201);
    }

    /**
     * @OA\Put(
     *     path="/users/{id}",
     *     summary="Update an existing user",
     *     tags={"Users"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/UserRequest")),
     *     @OA\Response(response=200, description="User updated successfully", @OA\JsonContent(ref="#/components/schemas/User")),
     *     @OA\Response(response=404, description="User not found"),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function update(UserRequest $request, int $id): JsonResponse
    {
        return response()->json($this->service->update($id, $request->validated()));
    }

    /**
     * @OA\Delete(
     *     path="/users/{id}",
     *     summary="Delete a user",
     *     tags={"Users"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=204, description="User deleted successfully"),
     *     @OA\Response(response=404, description="User not found")
     * )
     */
    public function destroy(int $id): JsonResponse
    {
        $this->service->delete($id);
        return response()->json(null, 204);
    }

    /**
     * @OA\Get(
     *     path="/users/search",
     *     tags={"Users"},
     *     summary="Search users with filters",
     *     description="Filter users by name, email, or CPF. Also returns jobs each user is registered in.",
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         required=false,
     *         description="Number of results per page",
     *         @OA\Schema(type="integer", example=10)
     *     ),
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         required=false,
     *         description="Filter users by name",
     *         @OA\Schema(type="string", example="John Doe")
     *     ),
     *     @OA\Parameter(
     *         name="email",
     *         in="query",
     *         required=false,
     *         description="Filter users by email",
     *         @OA\Schema(type="string", example="john@example.com")
     *     ),
     *     @OA\Parameter(
     *         name="cpf",
     *         in="query",
     *         required=false,
     *         description="Filter users by CPF",
     *         @OA\Schema(type="string", example="123.456.789-00")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of users with jobs",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/User")
     *             ),
     *             @OA\Property(
     *                 property="links",
     *                 type="object"
     *             ),
     *             @OA\Property(
     *                 property="meta",
     *                 type="object"
     *             )
     *         )
     *     )
     * )
     */
    public function search(UserSearchRequest $request)
    {
        return response()->json(
            $this->service->search(
                $request->get('per_page', 10),
                $request->only(['name', 'email', 'cpf'])
            )
        );
    }
}
