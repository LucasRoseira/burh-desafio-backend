<?php

namespace App\Http\Controllers;

use App\Http\Requests\JobRequest;
use App\Services\JobService;
use Illuminate\Http\JsonResponse;

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
     *     summary="List all jobs",
     *     tags={"Jobs"},
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Job"))
     *     )
     * )
     */
    public function index(): JsonResponse
    {
        return response()->json($this->service->list());
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
    public function store(JobRequest $request): JsonResponse
    {
        return response()->json($this->service->create($request->validated()), 201);
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
    public function update(JobRequest $request, int $id): JsonResponse
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
