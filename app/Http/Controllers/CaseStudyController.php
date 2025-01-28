<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GroupCategory;
use App\Models\CaseStudy;
use Illuminate\Support\Facades\Log;

class CaseStudyController extends Controller
{

    public function getCaseStudiesByTag(Request $request, $groupId)
    {

        $userId = auth()->user()->id;

        $groupCategory = GroupCategory::where('group_id', $groupId)
            ->where('make_user_id', $userId)
            ->with('caseStudies')
            ->first();

        if (!$groupCategory) {
            return response()->json(['message' => 'Group category not found or you do not have access.'], 404);
        }

        return response()->json([
            'group_category' => $groupCategory,
        ]);
    }

    public function store(Request $request) {
        // $validatedData = $request->validate([
        //     'user_id' => 'required|integer',
        //     'title' => 'required|string|max:255',
        //     'detail' => 'required|string',
        //     'group_id' => 'required|string',
        // ]);
        $caseStudy = CaseStudy::create([
            'user_id' => auth()->id(),
            'title' => $request->title,
            'detail' => $request->detail,
            'group_id' => $request->group_id,
            'case_number' => $request->case_number,
        ]);
        // $caseStudy = CaseStudy::create($validatedData);
    
        return response()->json(['message' => 'Case study created successfully!', 'data' => $caseStudy], 201);
    }

    public function update(Request $request, $caseNumber)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'detail' => 'required|string',
            'group_id' => 'required|string',
        ]);

        $userId = auth()->user()->id;
        $caseStudy = CaseStudy::where('case_number', $caseNumber)
            ->where('user_id', $userId)
            ->first();

        if (!$caseStudy) {
            return response()->json(['message' => 'Case study not found or you do not have permission to update.'], 404);
        }

        $caseStudy->update($validatedData);

        return response()->json(['message' => 'Case study updated successfully!', 'data' => $caseStudy], 200);
    }

    public function delete($caseNumber)
    {
        $userId = auth()->user()->id;

        $caseStudy = CaseStudy::where('case_number', $caseNumber)
            ->where('user_id', $userId)
            ->first();

        if (!$caseStudy) {
            return response()->json(['message' => 'Case study not found or you do not have permission to delete.'], 404);
        }

        $caseStudy->delete();

        return response()->json(['message' => 'Case study deleted successfully.'], 200);
    }
}
