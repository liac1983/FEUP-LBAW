<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        // Perguntas frequentes relacionadas ao GetTogether
        $faqs = [
            [
                'pergunta' => 'How can I create an event?',
                'resposta' => 'To create an event, click the "Create Event" button in the header and follow the instructions.'
            ],
            // Adicione mais perguntas conforme necessário
        ];

        return view('faq.index', compact('faqs'));
    }
}
