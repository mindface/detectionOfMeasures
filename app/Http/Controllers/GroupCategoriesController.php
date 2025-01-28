<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GroupCategory;

class GroupCategoriesController extends Controller
{

    public function index()
    {
        $groupCategories = GroupCategory::where('make_user_id', auth()->id())->with('caseStudies')->get();

        return response()->json([
            'message' => 'Group categories retrieved successfully',
            'groupCategories' => $groupCategories,
        ], 200);
    }

    public function getCaseStudiesByTag($groupId)
    {
        $userId = auth()->user()->id;
        // 指定したgroup_idのグループカテゴリを取得
        $groupCategory = GroupCategory::where('group_id', $groupId)
            ->where('make_user_id', $userId)
            ->with('caseStudies')
            ->first();

        if (!$groupCategory) {
            return response()->json(['message' => 'Group category not found.'], 404);
        }

        return response()->json([
            'group_category' => $groupCategory,
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'detail' => 'required|string',
            'count_user_ids' => 'required|json',
            'count_task_ids' => 'required|json',
            'group_id' => 'required|string|unique:group_categories,group_id',
        ]);
        $validatedData['make_user_id'] = auth()->user()->id;

        $groupCategory = GroupCategory::create($validatedData);

        return response()->json(['message' => 'Group category created successfully!', 'data' => $groupCategory], 201);
    }

    public function update(Request $request, $groupId)
    {
        $userId = auth()->user()->id;

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'detail' => 'required|string',
            'count_user_ids' => 'required|json',
            'count_task_ids' => 'required|json',
            'group_id' => 'required|string',
        ]);

        $groupCategory = GroupCategory::where('group_id', $groupId)
            ->where('make_user_id', $userId)
            ->first();

        if (!$groupCategory) {
            return response()->json(['message' => 'Group category not found or you do not have permission to update.'], 404);
        }

        $groupCategory->update($validatedData);

        return response()->json(['message' => 'Group category updated successfully!', 'data' => $groupCategory], 200);
    }

    public function delete($groupId)
    {
        $userId = auth()->user()->id;
    
        $groupCategory = GroupCategory::where('group_id', $groupId)
            ->where('make_user_id', $userId)
            ->first();
    
        if (!$groupCategory) {
            return response()->json(['message' => 'Group category not found or you do not have permission to delete.'], 404);
        }
    
        $groupCategory->delete();
    
        return response()->json(['message' => 'Group category deleted successfully.'], 200);
    }

}
