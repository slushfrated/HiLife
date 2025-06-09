<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function index()
    {
        $personalQuests = auth()->user()->tasks()
            ->where('source', 'user')
            ->where('is_completed', false)
            ->orderBy('deadline')
            ->get()
            ->map(function($q) {
                return [
                    'date' => $q->deadline ? \Carbon\Carbon::parse($q->deadline)->format('Y-m-d') : null,
                    'title' => $q->title,
                    'time' => $q->deadline ? \Carbon\Carbon::parse($q->deadline)->format('H:i') : '',
                    'description' => $q->description,
                    'id' => $q->id,
                    'priority' => $q->priority,
                ];
            })
            ->filter(function($e) { return $e['date']; })
            ->values();
        return view('calendar', compact('personalQuests'));
    }
} 