<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class JobApplicationController extends Controller
{
    /**
     * @OA\Post(
     *     path="/jobs/{job_id}/apply",
     *     summary="Apply a user to a job",
     *     tags={"Jobs"},
     *     @OA\Parameter(
     *         name="job_id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="user_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(response=200, description="User applied successfully"),
     *     @OA\Response(response=404, description="Job or user not found")
     * )
     */
    public function apply(Request $request, int $job_id): JsonResponse
    {
        $job = Job::findOrFail($job_id);
        $userId = $request->input('user_id');

        if ($job->users()->where('user_id', $userId)->exists()) {
            return response()->json(['message' => 'User already applied to this job.'], 400);
        }

        $job->users()->attach($userId);

        return response()->json(['message' => 'User applied successfully.']);
    }
}
