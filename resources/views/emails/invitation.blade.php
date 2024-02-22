@php
	if (php_sapi_name() === 'cli' or defined('STDIN')) {
		$url = 'https://ork.amtgard.com';
	}else{
		$url = 'https://' . $_SERVER['SERVER_NAME'];
	}
	$urlBits = explode(".", parse_url($url, PHP_URL_HOST));
	$tld = end($urlBits);
@endphp

@extends('layouts.email')

@section('subject', $data['subject'])

@section('content')
You have an invitation to join ORK4!<br>
Click the button below or copy the following into your browser:
<blockquote>
{{ $url . '/register?invitation=' . $data['content']['invite_token'] }}
</blockquote>
@endsection

@section('action')
												<table border="0" cellpadding="0" cellspacing="0" width="100%" class="mcnButtonBlock" style="min-width:100%;">
													<tbody class="mcnButtonBlockOuter">
														<tr>
															<td style="padding-top:0; padding-right:18px; padding-bottom:18px; padding-left:18px;" valign="top" align="center" class="mcnButtonBlockInner">
																<table border="0" cellpadding="0" cellspacing="0" class="mcnButtonContentContainer" style="border-collapse: separate !important;border-radius: 4px;background-color: #2BAADF;">
																	<tbody>
																		<tr>
																			<td align="center" valign="middle" class="mcnButtonContent" style="font-family: Arial; font-size: 16px; padding: 18px;">
																				<a class="mcnButton " title="Action" href="{{ $url . '/register?invitation=' . $data['content']['invite_token'] }}" target="_blank" style="font-weight: bold;letter-spacing: normal;line-height: 100%;text-align: center;text-decoration: none;color: #FFFFFF;">Register</a>
																			</td>
																		</tr>
																	</tbody>
																</table>
															</td>
														</tr>
													</tbody>
												</table>
@endsection