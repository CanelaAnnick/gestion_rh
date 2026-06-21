<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    // Admin : Envoyer un message à un employé
    public function send(Request $request, $userId)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        Message::create([
            'user_id' => $userId,
            'subject' => $request->subject,
            'content' => $request->content,
        ]);

        return back()->with('success', 'Message envoyé à l\'employé avec succès !');
    }

    // Employé : Marquer un message comme lu
    public function markAsRead($id)
    {
        $message = Message::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $message->update(['is_read' => true]);
        
        return response()->json(['status' => 'success']);
    }
}