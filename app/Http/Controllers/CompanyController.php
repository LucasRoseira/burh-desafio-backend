<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyRequest;
use App\Services\CompanyService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
     *     summary="List all companies with pagination",
     *     tags={"Companies"},
     *     @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         required=false,
     *         description="Number of results per page",
     *         @OA\Schema(type="integer", example=10)
     *     ),
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         required=false,
     *         description="Current page number",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Paginated list of companies",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/Company")
     *             ),
     *             @OA\Property(
     *                 property="links",
     *                 type="object",
     *                 @OA\Property(property="first", type="string", example="url"),
     *                 @OA\Property(property="last", type="string", example="url"),
     *                 @OA\Property(property="prev", type="string", nullable=true, example=null),
     *                 @OA\Property(property="next", type="string", example="url")
     *             ),
     *             @OA\Property(
     *                 property="meta",
     *                 type="object",
     *                 @OA\Property(property="current_page", type="integer", example=1),
     *                 @OA\Property(property="from", type="integer", example=1),
     *                 @OA\Property(property="last_page", type="integer", example=5),
     *                 @OA\Property(property="per_page", type="integer", example=10),
     *                 @OA\Property(property="to", type="integer", example=10),
     *                 @OA\Property(property="total", type="integer", example=50),
     *                 @OA\Property(property="path", type="string", example="url"),
     *                 @OA\Property(property="links", type="array", @OA\Items(type="string"))
     *             )
     *         )
     *     )
     * )
     */

    public function index(Request $request): JsonResponse
    {
        $perPage = (int) $request->query('per_page', 10);
        $page = (int) $request->query('page', 1);

        return response()->json(
            $this->service->list($perPage, $page)
        );
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
