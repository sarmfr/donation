<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'message' => 'required|string',
        ]);

        ContactMessage::create($validated);

        if ($request->ajax()) {
            return response()->json(['success' => 'Message sent successfully!']);
        }

        return redirect()->back()->with('success', 'Message sent successfully!');
    }
}
