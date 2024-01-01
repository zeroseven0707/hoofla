@extends('layouts.admin.navfootbar')
@section('content')
<div class="container">
    <div class="heading heading-page">
        Pertanyaan Umum
    </div>
    <div class="faq-layout">
        @foreach ($faq as $faqs)
        <button class="faq-accordion">{{ $faqs['question'] }}</button>
        <div class="faq-panel">
            <p>{{ $faqs['answer'] }}</p>
        </div>
        @endforeach
    </div>
</div>
@endsection
