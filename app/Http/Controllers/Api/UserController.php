<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\Skill;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $users = User::with('skills')->get();
        return response()->json($users);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param UserRequest $request
     * @return JsonResponse
     */
    public function store(UserRequest $request): JsonResponse
    {
        $validated = $request->validated();
        try {
            DB::beginTransaction();
            $validated['password'] = bcrypt($validated['password']);
            $user = User::create($validated);
            $skills = $validated['skills'];
            $this->attachSkills($user, $skills);
            DB::commit();
            return response()->json($user);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }

    private function attachSkills($user, mixed $skills)
    {
        foreach ($skills as $skill) {
            $skill = Skill::create(['skills' => $skill]);
            $user->skills()->attach($skill->id);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return JsonResponse
     */
    public function show(User $user): JsonResponse
    {
        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UserRequest $request
     * @param User $user
     * @return JsonResponse
     */
    public function update(UserRequest $request, User $user)
    {
        try {
            DB::beginTransaction();
            $validated = $request->validated();
            $skills = $validated['skills'];
            $this->detachSkills($user);
            $this->attachSkills($user, $skills);
            $user->update($validated);
            DB::commit();
            return response()->json($user);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    private function detachSkills(User $user)
    {
        $user->skills()->delete();
//        $user->skills()->detach();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return JsonResponse
     */
    public function destroy(User $user): JsonResponse
    {
        $user->delete();
        return response()->json(null, 204);
    }

}
