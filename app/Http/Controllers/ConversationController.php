<?php
// app/Http/Controllers/ConversationController.php

namespace App\Http\Controllers;

use App\Models\Conversation;
use Illuminate\Http\Request;

class ConversationController extends Controller
{
    public function index()
    {
        $conversations = auth()->user()->conversations()->latest()->get();
        return view('conversations.index', compact('conversations'));
    }

    public function create()
    {
        return view('conversations.create');
    }

    public function store(Request $request)
    {
        $request->validate(['title' => 'nullable|string|max:255']);
        $conversation = auth()->user()->conversations()->create(['title' => $request->title]);
        return redirect()->route('conversations.show', $conversation);
    }

    public function show(Conversation $conversation)
    {
        $this->authorize('view', $conversation);
        $conversation->load('messages');
        return view('conversations.show', compact('conversation'));
    }
}
