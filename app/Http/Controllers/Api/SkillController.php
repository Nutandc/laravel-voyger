<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\SkillRequest;
use App\Models\Skill;
use Illuminate\Http\JsonResponse;

class SkillController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $skills = Skill::get();
        return response()->json($skills);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param SkillRequest $request
     * @return JsonResponse
     */
    public function store(SkillRequest $request): JsonResponse
    {
        $skill = Skill::create($request->validated());
        return response()->json($skill);
    }

    /**
     * Display the specified resource.
     *
     * @param Skill $skill
     * @return JsonResponse
     */
    public function show(Skill $skill): JsonResponse
    {
        return response()->json($skill);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param SkillRequest $request
     * @param Skill $skill
     * @return JsonResponse
     */
    public function update(SkillRequest $request, Skill $skill): JsonResponse
    {
        $skill->update($request->validated());
        return response()->json($skill);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Skill $skill
     * @return JsonResponse
     */
    public function destroy(Skill $skill): JsonResponse
    {
        $skill->delete();
        return response()->json(null, 204);
    }

}
