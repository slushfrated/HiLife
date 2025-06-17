<?php

namespace App\Http\Controllers;

use App\Models\Title;
use Illuminate\Http\Request;

class TitleController extends Controller
{
    public function select(Request $request)
    {
        $user = $request->user();
        $titleId = $request->input('current_title_id');
        if (empty($titleId)) {
            $user->update(['current_title_id' => null]);
            // Unset all is_selected in pivot
            $user->titles()->update(['is_selected' => false]);
            return redirect()->back()->with('success', 'Title removed successfully!');
        }
        $title = \App\Models\Title::findOrFail($titleId);
        // Check if user has earned this title
        if (!$user->titles()->where('title_id', $title->id)->exists()) {
            return redirect()->back()->with('error', 'You have not earned this title yet!');
        }
        // Update user's current title
        $user->update(['current_title_id' => $title->id]);
        // Update is_selected in pivot table
        $user->titles()->update(['is_selected' => false]);
        $user->titles()->updateExistingPivot($title->id, ['is_selected' => true]);
        return redirect()->back()->with('success', 'Title updated successfully!');
    }
} 