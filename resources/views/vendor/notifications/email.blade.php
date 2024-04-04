<x-mail::message>
								<tr>
									<td align="left" class="es-m-p10b es-m-p20r es-m-p20l" style="padding:0;Margin:0;padding-top:20px">
									<table cellpadding="0" cellspacing="0" role="none" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px" width="100%">
										<tbody>
											<tr>
												<td align="center" class="es-m-p0r es-m-p20b" style="padding:0;Margin:0;width:600px" valign="top">
												<table cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px" width="100%">
													<tbody>
														<tr>
															<td align="center" class="es-m-txt-c" style="padding:0;Margin:0">
															<h1 style="Margin:0;line-height:55px;mso-line-height-rule:exactly;font-family:'Barlow Condensed', Arial, sans-serif;font-size:46px;font-style:normal;font-weight:normal;color:#E2CFEA; text-align: center;">{{$subject}}</h1>
															</td>
														</tr>
														<tr>
															<td align="center" class="es-m-txt-c es-m-p10r es-m-p10l" style="Margin:0;padding-bottom:10px;padding-top:15px;padding-left:40px;padding-right:40px">
															<p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:Barlow, sans-serif;line-height:24px;color:#E2CFEA;font-size:16px; text-align: center;">&laquo;Live the Dream&raquo;</p>
															</td>
														</tr>
													</tbody>
												</table>
												</td>
											</tr>
										</tbody>
									</table>
									</td>
								</tr>
								<tr>
									<td align="left" class="es-m-p20r es-m-p20l" style="padding:0;Margin:0;padding-top:30px;padding-bottom:30px">
										<table cellpadding="0" cellspacing="0" role="none" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px" width="100%">
											<tbody>
												<tr>
													<td align="center" style="padding:0;Margin:0;width:600px" valign="top">
														<table cellpadding="0" cellspacing="0" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:separate;border-spacing:0px;border-radius:10px" width="100%">
															<tbody>
																<tr>
																	<td align="center" style="padding:0;Margin:0;padding-top:15px;padding-bottom:15px;font-size:0">
																	<table border="0" cellpadding="0" cellspacing="0" height="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px" width="100%">
																		<tbody>
																			<tr>
																				<td style="padding:0;Margin:0;border-bottom:1px solid #ffffff;background:unset;height:1px;width:100%;margin:0px">&nbsp;</td>
																			</tr>
																		</tbody>
																	</table>
																	</td>
																</tr>
																<tr>
																	<td align="left" style="padding:0;Margin:0;padding-top:20px;padding-bottom:20px">
																	<h2 style="Margin:0;line-height:34px;mso-line-height-rule:exactly;font-family:'Barlow Condensed', Arial, sans-serif;font-size:28px;font-style:normal;font-weight:normal;color:#ffffff">
																		@if (! empty($greeting))
																			{{ $greeting }}
																		@else
																			@if ($level === 'error')
																				@lang('Whoops!')
																			@else
																				@lang('Hail, and Well Met!')
																			@endif
																		@endif
																	</h2>
																	<p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:Barlow, sans-serif;line-height:24px;color:#E2CFEA;font-size:16px">&nbsp;</p>
																	<p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:Barlow, sans-serif;line-height:24px;color:#ffffff;font-size:16px">
																		@foreach ($introLines as $line)
																		{{ $line }}
																		@endforeach
																	</p>
																	</td>
																</tr>
																<tr>
																	<td align="center" style="padding:0;Margin:0;padding-bottom:20px">
																		<span class="es-button-border msohide" style="border-style:solid;border-color:#2CB543;background:#A06CD5;border-width:0px;display:inline-block;border-radius:0px;width:auto;mso-hide:all">
																			<a class="es-button" href="{{$actionUrl}}" style="mso-style-priority:100 !important;text-decoration:none;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;color:#FFFFFF;font-size:18px;padding:10px 20px 10px 20px;display:inline-block;background:#A06CD5;border-radius:0px;font-family:Barlow, sans-serif;font-weight:normal;font-style:normal;line-height:22px;width:auto;text-align:center;mso-padding-alt:0;mso-border-alt:10px solid #A06CD5" target="_blank">{{$actionText}}</a>
																		</span>
																	</td>
																</tr>
																@if (! empty($outroLines))
																<tr>
																	<td align="left" style="padding:0;Margin:0;padding-top:20px;padding-bottom:20px">
																		<p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:Barlow, sans-serif;line-height:24px;color:#ffffff;font-size:16px">
																			@foreach ($outroLines as $line)
																			{{ $line }}
																			@endforeach
																		</p>
																	</td>
																</tr>
																@endif
																<tr>
																	<td align="left" style="padding:0;Margin:0;padding-top:20px;padding-bottom:20px">
																		<p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:Barlow, sans-serif;line-height:24px;color:#ffffff;font-size:16px">
																		@if (! empty($salutation))
																			{{$salutation}}
																		@else
																			@lang('Regards'),<br>
																			{{ config('app.name') }}
																		@endif
																		</p>
																	</td>
																</tr>
																<tr>
																	<td align="center" style="padding:0;Margin:0;padding-top:15px;padding-bottom:15px;font-size:0">
																	<table border="0" cellpadding="0" cellspacing="0" height="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px" width="100%">
																		<tbody>
																			<tr>
																				<td style="padding:0;Margin:0;border-bottom:1px solid #ffffff;background:unset;height:1px;width:100%;margin:0px">&nbsp;</td>
																			</tr>
																		</tbody>
																	</table>
																	</td>
																</tr>
																<tr>
																	<td align="left" style="padding:0;Margin:0;padding-top:20px;padding-bottom:20px">
																	<table border="0" cellpadding="0" cellspacing="0" height="100%" role="presentation" style="mso-table-lspace:0pt;mso-table-rspace:0pt;border-collapse:collapse;border-spacing:0px" width="100%">
																		<tbody>
																			<tr>
																				<td style="padding:0;Margin:0;border-bottom:1px solid #ffffff;background:unset;height:1px;width:100%;margin:0px">
																					<p style="Margin:0;-webkit-text-size-adjust:none;-ms-text-size-adjust:none;mso-line-height-rule:exactly;font-family:Barlow, sans-serif;line-height:24px;color:#ffffff;font-size:16px">
																					If you're having trouble clicking the {{$actionText}} button, copy and paste the URL below into your web browser:<br>
																					<span style="font-size:10px; max-width:600px; display: block;">{{ $actionUrl }}</span>
																					</p>
																				</td>
																			</tr>
																		</tbody>
																	</table>
																	</td>
																</tr>
															</tbody>
														</table>
													</td>
												</tr>
											</tbody>
										</table>
									</td>
								</tr>
</x-mail::message>
