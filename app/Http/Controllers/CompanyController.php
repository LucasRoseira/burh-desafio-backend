<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyRequest;
use App\Services\CompanyService;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Tag(
 *     name="Companies",
 *     description="API Endpoints for Companies"
 * )
 */
class CompanyController extends Controller
{
    protected $service;

    public function __construct(CompanyService $service)
    {
        $this->service = $service;
    }

    /**
     * @OA\Get(
     *     path="/companies",
     *     summary="List all companies",
     *     tags={"Companies"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Company"))
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        return response()->json($this->service->list());
    }

    /**
     * @OA\Get(
     *     path="/companies/{id}",
     *     summary="Get a specific company",
     *     tags={"Companies"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Successful operation", @OA\JsonContent(ref="#/components/schemas/Company")),
     *     @OA\Response(response=404, description="Company not found")
     * )
     */
    public function show(int $id): JsonResponse
    {
        return response()->json($this->service->get($id));
    }

    /**
     * @OA\Post(
     *     path="/companies",
     *     summary="Create a new company",
     *     tags={"Companies"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/CompanyRequest")
     *     ),
     *     @OA\Response(response=201, description="Company created successfully", @OA\JsonContent(ref="#/components/schemas/Company")),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function store(CompanyRequest $request): JsonResponse
    {
        return response()->json($this->service->create($request->validated()), 201);
    }

    /**
     * @OA\Put(
     *     path="/companies/{id}",
     *     summary="Update an existing company",
     *     tags={"Companies"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/CompanyRequest")),
     *     @OA\Response(response=200, description="Company updated successfully", @OA\JsonContent(ref="#/components/schemas/Company")),
     *     @OA\Response(response=404, description="Company not found"),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function update(CompanyRequest $request, int $id): JsonResponse
    {
        return response()->json($this->service->update($id, $request->validated()));
    }

    /**
     * @OA\Delete(
     *     path="/companies/{id}",
     *     summary="Delete a company",
     *     tags={"Companies"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=204, description="Company deleted successfully"),
     *     @OA\Response(response=404, description="Company not found")
     * )
     */
    public function destroy(int $id): JsonResponse
    {
        $this->service->delete($id);
        return response()->json(null, 204);
    }
}
