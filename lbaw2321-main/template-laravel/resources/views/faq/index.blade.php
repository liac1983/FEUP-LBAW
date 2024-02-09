<!-- resources/views/faq.blade.php -->

@extends('layouts.app')

@section('content')
    <h1>FAQs</h1>
    
    @foreach ($faqs as $faq)
        <h3>{{ $faq['pergunta'] }}</h3>
        <p>{{ $faq['resposta'] }}</p>
    @endforeach
@endsection
