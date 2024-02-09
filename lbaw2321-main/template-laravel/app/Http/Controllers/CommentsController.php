<?php

// app/Http/Controllers/CommentsController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;

class CommentsController extends Controller
{
    // ... (outros métodos existentes) ...

    public function store(Request $request, $eventId)
    {
        // Valide os dados do formulário
        $request->validate([
            'content' => 'required|string|max:255',
        ]);

        // Crie o comentário
        $comment = new Comment([
            'content' => $request->input('content'),
            'owner_id' => auth()->id(),
            'event_id' => $eventId,
            'datetime' => now(), // ou utilize Carbon para uma data/hora mais precisa
        ]);

        // Salve o comentário no banco de dados
        $comment->save();

        // Redirecione de volta para a página do evento
        return redirect()->route('event.show', ['id' => $eventId])->with('success', 'Comment added successfully.');
    }

    public function destroy($commentId)
    {
        $comment = Comment::findOrFail($commentId);

        // Verificar se o usuário atual é o proprietário do comentário
        if (auth()->id() == $comment->owner_id) {
            $comment->delete();

            return redirect()->back()->with('success', 'Comment deleted successfully.');
        }

        // Se o usuário não for o proprietário, redirecione com uma mensagem de erro
        return redirect()->back()->with('error', 'Permission denied. You are not the owner of the comment.');
    }

}
