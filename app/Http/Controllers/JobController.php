<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobRequest;
use App\Http\Requests\JobUpdateRequest;
use App\Services\JobService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *     name="Jobs",
 *     description="API Endpoints for Jobs"
 * )
 */
class JobController extends Controller
{
    protected $service;

    public function __construct(JobService $service)
    {
        $this->service = $service;
    }

    /**
     * @OA\Get(
     *     path="/jobs",
     *     summary="List all jobs with pagination",
     *     tags={"Jobs"},
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
     *         description="Paginated list of jobs",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="data",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/Job")
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
     *     path="/jobs/{id}",
     *     summary="Get a specific job",
     *     tags={"Jobs"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Successful operation", @OA\JsonContent(ref="#/components/schemas/Job")),
     *     @OA\Response(response=404, description="Job not found")
     * )
     */
    public function show(int $id): JsonResponse
    {
        return response()->json($this->service->get($id));
    }

    /**
     * @OA\Post(
     *     path="/jobs",
     *     summary="Create a new job",
     *     tags={"Jobs"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/JobRequest")
     *     ),
     *     @OA\Response(response=201, description="Job created successfully", @OA\JsonContent(ref="#/components/schemas/Job")),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function store(JobRequest $request)
    {
        try {
            $job = $this->service->create($request->validated());
            return response()->json($job, 201);
        } catch (\Exception $e) {
            if ($e->getMessage() === 'This company has reached the maximum number of jobs for its plan.') {
                return response()->json([
                    'message' => $e->getMessage(),
                ], 422);
            }
            throw $e;
        }
    }


    /**
     * @OA\Put(
     *     path="/jobs/{id}",
     *     summary="Update an existing job",
     *     tags={"Jobs"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/JobRequest")),
     *     @OA\Response(response=200, description="Job updated successfully", @OA\JsonContent(ref="#/components/schemas/Job")),
     *     @OA\Response(response=404, description="Job not found"),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function update(JobUpdateRequest $request, int $id): JsonResponse
    {
        return response()->json($this->service->update($id, $request->validated()));
    }

    /**
     * @OA\Delete(
     *     path="/jobs/{id}",
     *     summary="Delete a job",
     *     tags={"Jobs"},
     *     @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     *     @OA\Response(response=204, description="Job deleted successfully"),
     *     @OA\Response(response=404, description="Job not found")
     * )
     */
    public function destroy(int $id): JsonResponse
    {
        $this->service->delete($id);
        return response()->json(null, 204);
    }
}
