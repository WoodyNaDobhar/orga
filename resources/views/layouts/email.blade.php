<!doctype html>
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml" xmlns:o="urn:schemas-microsoft-com:office:office">
	<head>
		<!-- NAME: 1 COLUMN - FULL WIDTH -->
		<!--[if gte mso 15]>
		<xml>
			<o:OfficeDocumentSettings>
			<o:AllowPNG/>
			<o:PixelsPerInch>96</o:PixelsPerInch>
			</o:OfficeDocumentSettings>
		</xml>
		<![endif]-->
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>@yield('subject')</title>
	</head>
	<body>
		<table align="center" border="0" cellpadding="0" cellspacing="0" id="bodyTable" style="height:100%; width:100%">
			<tbody>
				<tr>
					<td style="vertical-align:top"><!-- BEGIN TEMPLATE // -->
						<table border="0" cellpadding="0" cellspacing="0" style="width:100%">
							<tbody>
								<tr>
									<td style="vertical-align:top"><!--[if (gte mso 9)|(IE)]>
											<table align="center" border="0" cellspacing="0" cellpadding="0" width="600" style="width:600px;">
											<tr>
											<td align="center" valign="top" width="600" style="width:600px;">
											<![endif]-->
										<table align="center" border="0" cellpadding="0" cellspacing="0" class="templateContainer" style="width:100%">
											<tbody>
												<tr>
													<td style="vertical-align:top">
														<table border="0" cellpadding="0" cellspacing="0" class="mcnTextBlock" style="min-width:100%; width:100%">
															<tbody>
																<tr>
																	<td style="vertical-align:top"><!--[if mso]>
																	<table align="left" border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100%;">
																		<tr>
																		<![endif]--><!--[if mso]>
																			<td valign="top" width="600" style="width:600px;">
																				<![endif]--><!-- <table align="left" border="0" cellpadding="0" cellspacing="0" style="max-width:100%; min-width:100%;" width="100%" class="mcnTextContentContainer">
																					<tbody><tr>
																						
																						<td valign="top" class="mcnTextContent" style="padding: 0px 18px 9px; text-align: center;">
																						
																							<a href="{{config('app.url')}}/email/view/id" target="_blank">View this email in your browser</a>
																						</td>
																					</tr>
																				</tbody></table> --><!--[if mso]>
																			</td>
																		<![endif]--><!--[if mso]>
																		</tr>
																	</table>
																	<![endif]--></td>
																	</tr>
																</tbody>
															</table>
														</td>
													</tr>
												</tbody>
											</table>
								<!--[if (gte mso 9)|(IE)]>
											</td>
											</tr>
											</table>
											<![endif]--></td>
										</tr>
										<tr>
											<td style="vertical-align:top"><!--[if (gte mso 9)|(IE)]>
											<table align="center" border="0" cellspacing="0" cellpadding="0" width="600" style="width:600px;">
											<tr>
											<td align="center" valign="top" width="600" style="width:600px;">
											<![endif]-->
											<table align="center" border="0" cellpadding="0" cellspacing="0" class="templateContainer" style="width:100%">
												<tbody>
													<tr>
														<td style="vertical-align:top">
															<table border="0" cellpadding="0" cellspacing="0" class="mcnImageBlock" style="min-width:100%; width:100%">
																<tbody>
																	<tr>
																		<td style="vertical-align:top">
																			<table align="left" border="0" cellpadding="0" cellspacing="0" class="mcnImageContentContainer" style="min-width:100%; width:100%">
																				<tbody>
																					<tr>
																						<td style="text-align:center; vertical-align:top">
																						<h1>@yield('subject')</h1>
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
								<!--[if (gte mso 9)|(IE)]>
											</td>
											</tr>
											</table>
											<![endif]--></td>
										</tr>
										<tr>
											<td style="vertical-align:top"><!--[if (gte mso 9)|(IE)]>
											<table align="center" border="0" cellspacing="0" cellpadding="0" width="600" style="width:600px;">
											<tr>
											<td align="center" valign="top" width="600" style="width:600px;">
											<![endif]-->
												<table align="center" border="0" cellpadding="0" cellspacing="0" class="templateContainer" style="width:100%">
													<tbody>
														<tr>
															<td style="vertical-align:top">
																<table border="0" cellpadding="0" cellspacing="0" class="mcnTextBlock" style="min-width:100%; width:100%">
																	<tbody>
																		<tr>
																			<td style="vertical-align:top"><!--[if mso]>
																	<table align="left" border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100%;">
																	<tr>
																	<![endif]--><!--[if mso]>
																	<td valign="top" width="600" style="width:600px;">
																	<![endif]-->
																				<table align="left" border="0" cellpadding="0" cellspacing="0" class="mcnTextContentContainer" style="max-width:100%; min-width:100%; width:100%">
																					<tbody>
																						<tr>
																							<td style="vertical-align:top">@yield('content')</td>
																						</tr>
																					</tbody>
																				</table>
														<!--[if mso]>
																	</td>
																	<![endif]--><!--[if mso]>
																	</tr>
																	</table>
																	<![endif]--></td>
																			</tr>
																		</tbody>
																	</table>
																</td>
															</tr>
															<tr>
																<td style="vertical-align:top"><!--[if mso]>
																	<table align="left" border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100%;">
																	<tr>
																	<![endif]--><!--[if mso]>
																	<td valign="top" width="600" style="width:600px;">
																	<![endif]-->
																	<table align="left" border="0" cellpadding="0" cellspacing="0" class="mcnTextContentContainer" style="max-width:100%; min-width:100%; width:100%">
																		<tbody>
																			<tr>
																				<td style="vertical-align:top">@yield('action')</td>
																			</tr>
																		</tbody>
																	</table>
																	<!--[if mso]>
																	</td>
																	<![endif]--><!--[if mso]>
																	</tr>
																	</table>
																	<![endif]--></td>
																</tr>
															</tbody>
														</table>
							<!--[if (gte mso 9)|(IE)]>
										</td>
										</tr>
										</table>
										<![endif]--></td>
												</tr>
												<tr>
													<td style="vertical-align:top"><!--[if (gte mso 9)|(IE)]>
											<table align="center" border="0" cellspacing="0" cellpadding="0" width="600" style="width:600px;">
											<tr>
											<td align="center" valign="top" width="600" style="width:600px;">
											<![endif]-->
														<table align="center" border="0" cellpadding="0" cellspacing="0" class="templateContainer" style="width:100%">
															<tbody>
																<tr>
																	<td style="vertical-align:top">
																		<table border="0" cellpadding="0" cellspacing="0" class="mcnFollowBlock" style="min-width:100%; width:100%">
																			<tbody>
																				<tr>
																					<td style="vertical-align:top">
																						<table border="0" cellpadding="0" cellspacing="0" class="mcnFollowContentContainer" style="min-width:100%; width:100%">
																							<tbody>
																								<tr>
																									<td>
																										<table border="0" cellpadding="0" cellspacing="0" class="mcnFollowContent" style="min-width:100%; width:100%">
																											<tbody>
																												<tr>
																													<td style="vertical-align:top">
																														<table align="center" border="0" cellpadding="0" cellspacing="0">
																															<tbody>
																																<tr>
																																	<td style="vertical-align:top"><!--[if mso]>
															<table align="center" border="0" cellspacing="0" cellpadding="0">
															<tr>
															<![endif]--><!--[if mso]>
																<td align="center" valign="top">
																<![endif]-->
																																		<table align="left" border="0" cellpadding="0" cellspacing="0" style="display:inline">
																																			<tbody>
																																				<tr>
																																					<td style="vertical-align:top">
																																						<table border="0" cellpadding="0" cellspacing="0" class="mcnFollowContentItem" style="width:100%">
																																							<tbody>
																																								<tr>
																																									<td style="vertical-align:middle">
																																										<table align="left" border="0" cellpadding="0" cellspacing="0">
																																											<tbody>
																																												<tr>
																																													<td style="vertical-align:middle"><a href="https://twitter.com/amtgardofficial" target="_blank"><img alt="Twitter" src="https://cdn-images.mailchimp.com/icons/social-block-v2/color-twitter-48.png" style="display:block; height:24px; width:24px" /></a></td>
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
																							<!--[if mso]>
																</td>
																<![endif]--><!--[if mso]>
																<td align="center" valign="top">
																<![endif]-->
		
																																		<table align="left" border="0" cellpadding="0" cellspacing="0" style="display:inline">
																																			<tbody>
																																				<tr>
																																					<td style="vertical-align:top">
																																						<table border="0" cellpadding="0" cellspacing="0" class="mcnFollowContentItem" style="width:100%">
																																							<tbody>
																																								<tr>
																																									<td style="vertical-align:middle">
																																									<table align="left" border="0" cellpadding="0" cellspacing="0">
																																										<tbody>
																																											<tr>
																																												<td style="vertical-align:middle"><a href="https://facebook.com/AmtgardInternational" target="_blank"><img alt="Facebook" src="https://cdn-images.mailchimp.com/icons/social-block-v2/color-facebook-48.png" style="display:block; height:24px; width:24px" /></a></td>
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
																							<!--[if mso]>
																</td>
																<![endif]--><!--[if mso]>
																<td align="center" valign="top">
																<![endif]-->
		
																																		<table align="left" border="0" cellpadding="0" cellspacing="0" style="display:inline">
																																			<tbody>
																																				<tr>
																																					<td style="vertical-align:top">
																																						<table border="0" cellpadding="0" cellspacing="0" class="mcnFollowContentItem" style="width:100%">
																																							<tbody>
																																								<tr>
																																									<td style="vertical-align:middle">
																																										<table align="left" border="0" cellpadding="0" cellspacing="0">
																																											<tbody>
																																												<tr>
																																													<td style="vertical-align:middle"><a href="{{config('app.url')}}" target="_blank"><img alt="Amtgard" src="https://cdn-images.mailchimp.com/icons/social-block-v2/color-link-48.png" style="display:block; height:24px; width:24px" /></a></td>
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
																							<!--[if mso]>
																</td>
																<![endif]--><!--[if mso]>
															</tr>
															</table>
															<![endif]--></td>
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
																				</tbody>
																			</table>
		
																			<table border="0" cellpadding="0" cellspacing="0" class="mcnDividerBlock" style="min-width:100%; width:100%">
																				<tbody>
																					<tr>
																						<td>
																						<table border="0" cellpadding="0" cellspacing="0" class="mcnDividerContent" style="border-top:2px solid #eeeeee; min-width:100%; width:100%">
																							<tbody>
																								<tr>
																									<td>&nbsp;</td>
																								</tr>
																							</tbody>
																						</table>
														<!--			
						<td class="mcnDividerBlockInner" style="padding: 18px;">
						<hr class="mcnDividerContent" style="border-bottom-color:none; border-left-color:none; border-right-color:none; border-bottom-width:0; border-left-width:0; border-right-width:0; margin-top:0; margin-right:0; margin-bottom:0; margin-left:0;" />
		--></td>
																					</tr>
																				</tbody>
																			</table>
		
																			<table border="0" cellpadding="0" cellspacing="0" class="mcnTextBlock" style="min-width:100%; width:100%">
																				<tbody>
																					<tr>
																						<td style="vertical-align:top"><!--[if mso]>
														<table align="left" border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100%;">
														<tr>
														<![endif]--><!--[if mso]>
														<td valign="top" width="600" style="width:600px;">
														<![endif]-->
																							<table align="left" border="0" cellpadding="0" cellspacing="0" class="mcnTextContentContainer" style="max-width:100%; min-width:100%; width:100%">
																								<tbody>
																									<tr>
																										<td style="vertical-align:top"><em>Copyright &copy; {{date('Y')}} Amtgard INC, All rights reserved.</em><br />
																										Live the Dream!<br />
																										<br />
																										<strong>Our mailing address is:</strong><br />
																										2021 ROSEBUD DR Irving, Texas 75060, US<br />
																										<br />
																										@if($data['content']['user_id'] != null && $data['content']['user_id'] != 0)
																										Want to change how you receive these emails?<br />
																										You can <a href="{{config('app.url')}}/unsubscribe">unsubscribe</a> from communications.<br />
																										<br />
																										@endif</td>
																									</tr>
																								</tbody>
																							</table>
																						<!--[if mso]>
														</td>
														<![endif]--><!--[if mso]>
														</tr>
														</table>
														<![endif]--></td>
																					</tr>
																				</tbody>
																			</table>
																		</td>
																	</tr>
																</tbody>
															</table>
								<!--[if (gte mso 9)|(IE)]>
											</td>
											</tr>
											</table>
											<![endif]--></td>
														</tr>
													</tbody>
												</table>
					<!-- // END TEMPLATE --></td>
				</tr>
			</tbody>
		</table>
	</body>
</html>