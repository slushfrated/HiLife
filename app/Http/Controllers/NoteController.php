<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;

class NoteController extends Controller
{
    public function update(Request $request)
    {
        $note = $request->user()->note()->firstOrCreate([], ['content' => $request->content]);
        $note->content = $request->content;
        $note->save();

        return response()->json(['success' => true]);
    }
} 