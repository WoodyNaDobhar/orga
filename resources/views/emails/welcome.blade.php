@php
	if (php_sapi_name() === 'cli' or defined('STDIN')) {
		$url = 'http://www.evenpulse.com';
	}else{
		$url = 'http://' . $_SERVER['SERVER_NAME'];
	}
	$urlBits = explode(".", parse_url($url, PHP_URL_HOST));
	$tld = end($urlBits);
@endphp

@extends('layouts.email')

@section('subject', $data['subject'])

@section('content')
Welcome to ORK4!
@if(array_key_exists('faq', $data))
@foreach($data['faq'] as $group => $faqs)
	<h4>{{$group}}</h4>
	<ol>
		@foreach($faqs as $faq)
		<li>
			<h5>{{$faq->question}}</h5>
			{{$faq->answer}}
		</li>
		@endforeach
	</ol>
@endforeach
@endif
@endsection

@section('action')
@endsection