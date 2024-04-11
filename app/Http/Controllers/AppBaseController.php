<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Response;

/**
 *	@OA\OpenApi(
 *		@OA\Info(
 *			title="ORK4 API",
 *			version="1.0.0",
 *			description="This page serves as both documentation of the ORK's API structure as well as a place to test it.<br>
 *	To access routes/methods that require permissions, you'll need to send a bearer_token for the User.  That token can be retrieved by either logging in or changing your password, which you will need to do the first time you use ORK4.  The various login functions can be found below under the heading 'Base'.  When you have your bearer token, you can apply it for use in these tools by hitting that Authorize button below.  Otherwise, you'll need to add it to your headers in your RESTful client: 'Authorization: Bearer asdf'.
 *	Most of the functions below work just fine on this UI, but some don't.  If you get unexpected results in a search, or if you want a better testing mechanism, I suggest a browser RESTful client.  I use the Firefox browser extension RESTclient.  The tools below, at least, will get you started, and expose everything you'll need to know to develop with the ORK4 API.",
 *			termsOfService="https://dev.ork4.org/terms",
 *			contact={
 *				"name"="ORK4 Support (Chiba)",
 *				"email"="support@ork4.org",
 *			}
 *		)
 *	),
 *	@OA\Server(url="/api"),
 *	@OA\SecurityScheme(
 *		securityScheme="bearer_token",
 *		type="http",
 *		scheme="bearer",
 *		bearerFormat="JWT",
 *	),
 *	@OA\Schema(
 *		schema="QueryParameters",
 *		@OA\Property(
 *			property="search[]",
 *			type="object",
 *			example={
 *				"id": "42"
 *			},
 *		),
 *		@OA\Property(
 *			property="columns[]",
 *			type="array",
 *			uniqueItems=true,
 *			@OA\Items(
 *				type="string",
 *				format="snake_case",
 *				example="id"
 *			)
 *		),
 *		@OA\Property(
 *			property="with[]",
 *			type="array",
 *			uniqueItems=true,
 *			@OA\Items(
 *				type="string",
 *				format="dotNotation",
 *				example="createdBy.persona"
 *			)
 *		),
 *		@OA\Property(
 *			property="limit",
 *			type="integer",
 *			format="int32",
 *			example=5
 *		),
 *		@OA\Property(
 *			property="skip",
 *			type="integer",
 *			format="int32",
 *			example=5
 *		),
 *		@OA\Property(
 *			property="sort[]",
 *			type="array",
 *			uniqueItems=true,
 *			@OA\Items(
 *				type="string",
 *				format="snake_case",
 *				example="id"
 *			)
 *		),
 *		@OA\Property(
 *			property="direction",
 *			type="string",
 *			format="enum",
 *			enum={"asc", "desc"},
 *			example="asc"
 *		)
 *	),
 *	@OA\Schema(
 *		schema="SimpleQueryParameters",
 *		@OA\Property(
 *			property="id",
 *			type="integer",
 *			format="int32",
 *			example=42
 *		),
 *		@OA\Property(
 *			property="columns[]",
 *			type="array",
 *			uniqueItems=true,
 *			@OA\Items(
 *				type="string",
 *				format="snake_case",
 *				example="id"
 *			)
 *		),
 *		@OA\Property(
 *			property="with[]",
 *			type="array",
 *			uniqueItems=true,
 *			@OA\Items(
 *				type="string",
 *				format="dotNotation",
 *				example="createdBy.persona"
 *			)
 *		)
 *	),
 *	@OA\Parameter(
 *		parameter="search",
 *		name="search",
 *		in="query",
 *		style="deepObject",
 *		@OA\Schema( 
 *			type="object",
 *			example={
 *				"id": "42"
 *			},
 *		),
 *		description="Search any column for value. Ex: search[column]=value.",
 *		required=false
 *	),
 *	@OA\Parameter(
 *		parameter="columns",
 *		name="columns[]",
 *		in="query",
 *		@OA\Schema(
 *			type="array",
 *			uniqueItems=true,
 *			@OA\Items(
 *				type="string",
 *				format="snake_case",
 *				example="id"
 *			)
 *		),
 *		description="Restrict results to given column(s). If used with 'with', you must also include the id column and related foreign key. Ex: columns[]=id",
 *		required=false
 *	),
 *	@OA\Parameter(
 *		parameter="with",
 *		name="with[]",
 *		in="query",
 *		@OA\Schema(
 *			type="array",
 *			uniqueItems=true,
 *			@OA\Items(
 *				type="string",
 *				format="dotNotation",
 *				example="createdBy.persona"
 *			)
 *		),
 *		description="Attach given related objects (nestable with dot notation ['parent.child']) to the results. Mutually exclusive of 'with'. Ex: with[]=createdBy.persona.chapter",
 *		required=false
 *	),
 *	@OA\Parameter(
 *		parameter="limit",
 *		name="limit",
 *		in="query",
 *		@OA\Schema(
 *			type="integer",
 *			format="int32",
 *		),
 *		description="Maximum number of results to return. Ex: limit=5",
 *		required=false
 *	),
 *	@OA\Parameter(
 *		parameter="skip",
 *		name="skip",
 *		in="query",
 *		@OA\Schema(
 *			type="integer",
 *			format="int32",
 *		),
 *		description="For pagination, number of results to skip.  Must be used with 'limit' or it will be ignored. Ex: skip=5&limit=5",
 *		required=false
 *	),
 *	@OA\Parameter(
 *		parameter="sort",
 *		name="sort",
 *		in="query",
 *		style="deepObject",
 *		@OA\Schema( 
 *			type="object",
 *			example={
 *				"id": "desc"
 *			},
 *		),
 *		description="Field (key, field name) and direction (value, either 'asc' or 'desc') in which the results should be sorted by column. Ex: direction[column1]=desc&direction[column2]=asc",
 *		required=false
 *	),
 *	@OA\RequestBody(
 *		request="login",
 *		description="Login data.",
 *		required=true,
 *		@OA\MediaType(
 *			mediaType="multipart/form-data",
 *			@OA\Schema(
 *				required={"email","password","password_confirm","device_name"},
 *				@OA\Property(
 *					property="email",
 *					description="Login email.",
 *					type="string",
 *					format="email",
 *					example="nobody@nowhere.net",
 *					maxLength=191
 *				),
 *				@OA\Property(
 *					property="password",
 *					description="Login password.",
 *					type="string",
 *					format="8-40 characters, at least 1 uppercase, at least 1 lowercase, both letters and numbers, not common",
 *					maxLength=8,
 *					maxLength=40
 *				),
 *				@OA\Property(
 *					property="password_confirm",
 *					description="Login password, confirmed.",
 *					type="string",
 *					format="8-40 characters, at least 1 uppercase, at least 1 lowercase, both letters and numbers, not common",
 *					maxLength=8,
 *					maxLength=40
 *				),
 *				@OA\Property(
 *					property="device_name",
 *					description="Login device information.",
 *					type="string",
 *					example="Bob'sS22"
 *				)
 *			)
 *		)
 *	),
 *	@OA\RequestBody(
 *		request="forgot",
 *		description="Forgot Password Request.",
 *		required=true,
 *		@OA\MediaType(
 *			mediaType="multipart/form-data",
 *			@OA\Schema(
 *				required={"email","device_name"},
 *				@OA\Property(
 *					property="email",
 *					description="User email.",
 *					type="string",
 *					format="email",
 *					example="nobody@nowhere.net",
 *					maxLength=191
 *				),
 *				@OA\Property(
 *					property="device_name",
 *					description="User device information.",
 *					type="string",
 *					example="Bob'sS22"
 *				)
 *			)
 *		)
 *	),
 *	@OA\RequestBody(
 *		request="reset",
 *		description="Reset Password Request.",
 *		required=true,
 *		@OA\MediaType(
 *			mediaType="multipart/form-data",
 *			@OA\Schema(
 *				required={"email","password_token","password","password_confirm","device_name"},
 *				@OA\Property(
 *					property="email",
 *					description="User email.",
 *					type="string",
 *					format="email",
 *					example="nobody@nowhere.net",
 *					maxLength=191
 *				),
 *				@OA\Property(
 *					property="password_token",
 *					description="Password reset token generated by the system and sent to the User.",
 *					type="string",
 *					example="fjwqp938rnjgp0q98rngqie3wrnfmpgq9enrgfpqi9me3rwfgpqienrgjp9qeunrgpqoeimrg0qe",
 *					maxLength=191
 *				),
 *				@OA\Property(
 *					property="password",
 *					description="New password.",
 *					type="string",
 *					format="8-40 characters, at least 1 uppercase, at least 1 lowercase, both letters and numbers, not common",
 *					maxLength=8,
 *					maxLength=40
 *				),
 *				@OA\Property(
 *					property="password_confirm",
 *					description="New password, confirmed.",
 *					type="string",
 *					format="8-40 characters, at least 1 uppercase, at least 1 lowercase, both letters and numbers, not common",
 *					maxLength=8,
 *					maxLength=40
 *				),
 *				@OA\Property(
 *					property="device_name",
 *					description="User device information.",
 *					type="string",
 *					example="Bob'sS22"
 *				)
 *			)
 *		)
 *	),
 *	@OA\RequestBody(
 *		request="sendInvite",
 *		description="Send User invitation.",
 *		required=true,
 *		@OA\MediaType(
 *			mediaType="multipart/form-data",
 *			@OA\Schema(
 *				required={"email","persona_id"},
 *				@OA\Property(
 *					property="email",
 *					description="New User's email.",
 *					type="string",
 *					format="email",
 *					example="nobody@nowhere.net",
 *					maxLength=191
 *				),
 *				@OA\Property(
 *					property="persona_id",
 *					description="Persona for the new User.",
 *					type="integer",
 *					format="int32",
 *					example=42
 *				)
 *			)
 *		)
 *	),
 *	@OA\RequestBody(
 *		request="register",
 *		description="Accept invitation to create a new User and claim a Persona.",
 *		required=true,
 *		@OA\MediaType(
 *			mediaType="multipart/form-data",
 *			@OA\Schema(
 *				required={"invite_token","email","password","password_confirm","is_agreed","device_name"},
 *				@OA\Property(
 *					property="email",
 *					description="User email.",
 *					type="string",
 *					format="email",
 *					example="nobody@nowhere.net",
 *					maxLength=191
 *				),
 *				@OA\Property(
 *					property="invite_token",
 *					description="Invitation token generated by the system and sent to the User.",
 *					type="string",
 *					example="fjwqp938rnjgp0q98rngqie3wrnfmpgq9enrgfpqi9me3rwfgpqienrgjp9qeunrgpqoeimrg0qe",
 *					maxLength=191
 *				),
 *				@OA\Property(
 *					property="password",
 *					description="User password.",
 *					type="string",
 *					format="8-40 characters, at least 1 uppercase, at least 1 lowercase, both letters and numbers, not common",
 *					maxLength=8,
 *					maxLength=40
 *				),
 *				@OA\Property(
 *					property="password_confirm",
 *					description="User password, confirmed.",
 *					type="string",
 *					format="8-40 characters, at least 1 uppercase, at least 1 lowercase, both letters and numbers, not common",
 *					maxLength=8,
 *					maxLength=40
 *				),
 *				@OA\Property(
 *					property="is_agreed",
 *					description="If the User has agreed to the Terms and Conditions and our Privacy Policy.",
 *					type="integer",
 *					format="enum",
 *					enum={0, 1},
 *					example=1
 *				),
 *				@OA\Property(
 *					property="device_name",
 *					description="User device information.",
 *					type="string",
 *					example="Bob'sS22"
 *				)
 *			)
 *		)
 *	),
 *	@OA\RequestBody(
 *		request="search",
 *		description="Search Request.",
 *		required=true,
 *		@OA\MediaType(
 *			mediaType="multipart/form-data",
 *			@OA\Schema(
 *				required={"search"},
 *				@OA\Property(
 *					property="search",
 *					description="Term being searched.",
 *					type="string",
 *					maxLength=191
 *				)
 *			)
 *		)
 *	),
 *	@OA\RequestBody(
 *		request="check",
 *		description="Active check data.",
 *		required=true,
 *		@OA\MediaType(
 *			mediaType="multipart/form-data",
 *			@OA\Schema(
 *				required={"user_id","device_name"},
 *				@OA\Property(
 *					property="user_id",
 *					description="User being checked.",
 *					type="integer",
 *					format="int32",
 *					example=42
 *				),
 *				@OA\Property(
 *					property="device_name",
 *					description="Login device information.",
 *					type="string",
 *					example="Bob'sS22"
 *				)
 *			)
 *		)
 *	)
 * Class AppBaseController
 */
class AppBaseController extends Controller
{
	public function sendResponse($result, $message)
	{
		return response()->json([
			'success' => true,
			'data'    => $result,
			'message' => $message,
		], 200);
	}
	
	public function sendError($message, $data = null, $code = 400)
	{
		if (!empty($data)) {
			$response = [
				'success' => false,
				'message' => $message,
				'data' => $data
			];
		}else{
			$response = [
				'success' => false,
				'message' => $message
			];
		}
		
		return response()->json($response, $code);
	}
	
	public function sendSuccess($message)
	{
		return Response::json([
			'success' => true,
			'message' => $message
		], 200);
	}
}
