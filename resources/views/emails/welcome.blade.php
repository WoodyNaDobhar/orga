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

@section('content', "Your account has been successfully created. Sign in to your account to customize your persona profile, check your credits, communicate with your officers, give recommendations, and much more!")

@section('action', $data['action'])