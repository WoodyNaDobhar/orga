<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('accounts', function (Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->bigIncrements('id')->comment('Model ID');
			$table->unsignedBigInteger('parent_id')->nullable()->index('parent_id')->comment('The superior Account ID, if any');
			$table->enum('accountable_type', ['Chapter', 'Realm', 'Unit'])->comment('Who owns the account; Chapter, Realm, or Unit');
			$table->unsignedBigInteger('accountable_id')->index('accountable_id')->comment('The ID of the owner of this account');
			$table->string('name', 50)->comment('Account label');
			$table->enum('type', ['Asset', 'Equity', 'Expense', 'Imbalance', 'Income', 'Liability'])->comment('Asset, Equity, Expense, Imbalance, Income, or Liability');
			$table->unsignedBigInteger('created_by')->default(1)->index('created_by');
			$table->timestamp('created_at')->useCurrent();
			$table->unsignedBigInteger('updated_by')->nullable()->index('updated_by');
			$table->timestamp('updated_at')->nullable();
			$table->unsignedBigInteger('deleted_by')->nullable()->index('deleted_by');
			$table->softDeletes();
		});

		Schema::create('archetypes', function (Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->bigIncrements('id')->comment('Model ID');
			$table->string('name', 50)->comment('Archetype label');
			$table->boolean('is_active')->default(true)->comment('Is it (default true) a current option?');
			$table->unsignedBigInteger('created_by')->default(1)->index('created_by');
			$table->timestamp('created_at')->useCurrent();
			$table->unsignedBigInteger('updated_by')->nullable()->index('updated_by');
			$table->timestamp('updated_at')->nullable();
			$table->unsignedBigInteger('deleted_by')->nullable()->index('deleted_by');
			$table->softDeletes();
		});

		Schema::create('attendances', function (Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->bigIncrements('id')->comment('Model ID');
			$table->unsignedBigInteger('archetype_id')->index('archetype_id')->comment('Selected Archetype for Attendance');
			$table->enum('attendable_type', ['Event', 'Meetup'])->comment('Where the Attendance occured; Event or Meetup');
			$table->unsignedBigInteger('attendable_id')->index('attendable_id')->comment('The ID of where the Attendance occured');
			$table->unsignedBigInteger('persona_id')->index('persona_id')->comment('Attendee Persona ID');
			$table->date('attended_at')->comment('The date of the Attendance');
			$table->double('credits', 4, 2)->default(1)->comment('Credits (default 1) awarded for the Attendance');
			$table->unsignedBigInteger('created_by')->default(1)->index('created_by');
			$table->timestamp('created_at')->useCurrent();
			$table->unsignedBigInteger('updated_by')->nullable()->index('updated_by');
			$table->timestamp('updated_at')->nullable();
			$table->unsignedBigInteger('deleted_by')->nullable()->index('deleted_by');
			$table->softDeletes();
		});

		Schema::create('awards', function (Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->bigIncrements('id')->comment('Model ID');
			$table->enum('awarder_type', ['Chapter', 'Realm', 'Unit'])->comment('Who issues the Award; Chapter, Realm, or Unit');
			$table->unsignedBigInteger('awarder_id')->nullable()->index('awarder_id')->comment('The ID of the award issuer, null for everybody');
			$table->string('name', 100)->comment('The Award label, with options for the label seperated with |');
			$table->boolean('is_ladder')->default(false)->comment('Is this (default false) a ranked/ladder award?');
			$table->unsignedBigInteger('created_by')->default(1)->index('created_by');
			$table->timestamp('created_at')->useCurrent();
			$table->unsignedBigInteger('updated_by')->nullable()->index('updated_by');
			$table->timestamp('updated_at')->nullable();
			$table->unsignedBigInteger('deleted_by')->nullable()->index('deleted_by');
			$table->softDeletes();
		});
			
		Schema::create('chapters', function (Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->bigIncrements('id')->comment('Model ID');
			$table->unsignedBigInteger('realm_id')->index('realm_id')->comment('The ID of the Realm sponsoring the Chapter');
			$table->unsignedBigInteger('chaptertype_id')->index('chaptertype_id')->comment('The ID of the Chaptertype earned by the Chapter');
			$table->unsignedBigInteger('location_id')->index('location_id')->comment('The ID of the Location that best describes where the Chapter is');
			$table->string('name', 100)->comment('The Chapter name');
			$table->string('abbreviation', 3)->comment('A short abbreviation of the Chapter name, unique for the Realm');
			$table->string('heraldry')->nullable()->comment('An internal link to an image of the Chapter heraldry, if any');
			$table->boolean('is_active')->default(true)->comment('Is (default true) the Chapter still active?');
			$table->unsignedBigInteger('created_by')->default(1)->index('created_by');
			$table->timestamp('created_at')->useCurrent();
			$table->unsignedBigInteger('updated_by')->nullable()->index('updated_by');
			$table->timestamp('updated_at')->nullable();
			$table->unsignedBigInteger('deleted_by')->nullable()->index('deleted_by');
			$table->softDeletes();
		});
			
		Schema::create('chaptertypes', function (Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->bigIncrements('id')->comment('Model ID');
			$table->unsignedBigInteger('realm_id')->index('realm_id')->comment('The ID of the Realm that has this Chaptertype');
			$table->string('name', 50)->comment('The name of the Chaptertype');
			$table->integer('rank')->nullable()->comment('The rank of the Chaptertype expressed in multiples of 10 where Shire is 20');
			$table->integer('minimumattendance')->default(5)->comment('Minimum average Attendance required by the Realm to achieve the Chaptertype');
			$table->integer('minimumcutoff')->default(1)->comment('Minimum average Attendance required by the Realm to maintain the Chaptertype');
			$table->unsignedBigInteger('created_by')->default(1)->index('created_by');
			$table->timestamp('created_at')->useCurrent();
			$table->unsignedBigInteger('updated_by')->nullable()->index('updated_by');
			$table->timestamp('updated_at')->nullable();
			$table->unsignedBigInteger('deleted_by')->nullable()->index('deleted_by');
			$table->softDeletes();
		});
			
		Schema::create('crats', function (Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->bigIncrements('id')->comment('Model ID');
			$table->unsignedBigInteger('event_id')->index('event_id')->comment('Event the Persona cratted for');
			$table->unsignedBigInteger('persona_id')->index('persona_id')->comment('The Persona cratting the Event');
			$table->string('role', 50)->comment('The role of the Crat');
			$table->boolean('is_autocrat')->default(false)->comment('Are they (default false) the person in charge?');
			$table->unsignedBigInteger('created_by')->default(1)->index('created_by');
			$table->timestamp('created_at')->useCurrent();
			$table->unsignedBigInteger('updated_by')->nullable()->index('updated_by');
			$table->timestamp('updated_at')->nullable();
			$table->unsignedBigInteger('deleted_by')->nullable()->index('deleted_by');
			$table->softDeletes();
		});

		Schema::create('dues', function (Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->bigIncrements('id')->comment('Model ID');
			$table->unsignedBigInteger('persona_id')->index('persona_id')->comment('Persona paying Dues');
			$table->unsignedBigInteger('transaction_id')->index('transaction_id')->comment('Transaction recording the payment');
			$table->date('dues_on')->comment('The date the dues period begins, not the date paid');
			$table->double('intervals', 7, 4)->nullable()->comment('Number of six month periods the payment covers, null for forever');
			$table->unsignedBigInteger('created_by')->default(1)->index('created_by');
			$table->timestamp('created_at')->useCurrent();
			$table->unsignedBigInteger('updated_by')->nullable()->index('updated_by');
			$table->timestamp('updated_at')->nullable();
			$table->unsignedBigInteger('deleted_by')->nullable()->index('deleted_by');
			$table->softDeletes();
		});

		Schema::create('events', function (Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->bigIncrements('id')->comment('Model ID');
			$table->enum('eventable_type', ['Chapter', 'Persona', 'Realm', 'Unit'])->comment('Who made and runs the Event; Chapter, Persona, Realm, or Unit');
			$table->unsignedBigInteger('eventable_id')->index('eventable_id')->comment('The ID of who made and runs the Event');
			$table->enum('sponsorable_type', ['Chapter', 'Realm'])->nullable()->comment('Who is agreeing to accept Attendances for the Event in the case of Persona or Unit types, if any; Chapter or Realm');
			$table->unsignedBigInteger('sponsorable_id')->nullable()->index('sponsorable_id')->comment('ID of the Realm or Chapter agreeing to accept Attendances for the Event in the case of Persona or Unit types, if any.');
			$table->unsignedBigInteger('location_id')->nullable()->index('at_chapter_id')->comment('ID of the Location the Event takes place at, if any');
			$table->string('name')->comment('The name of the Event');
			$table->mediumText('description')->nullable()->comment('A description of the Event, if any');
			$table->string('image', 255)->nullable()->comment('A promotional image for the Event, if any');
			$table->boolean('is_active')->default(true)->comment('Is this (default true) something people should be seeing yet?');
			$table->boolean('is_demo')->default(false)->comment('Is this (default false) a demo?');
			$table->timestamp('event_started_at')->useCurrent()->comment('When the Event begins');
			$table->timestamp('event_ended_at')->useCurrent()->comment('When the Event ends');
			$table->float('price', 6)->nullable()->comment('The cost of the Event, if any');
			$table->unsignedBigInteger('created_by')->default(1)->index('created_by');
			$table->timestamp('created_at')->useCurrent();
			$table->unsignedBigInteger('updated_by')->nullable()->index('updated_by');
			$table->timestamp('updated_at')->nullable();
			$table->unsignedBigInteger('deleted_by')->nullable()->index('deleted_by');
			$table->softDeletes();
		});
			
		Schema::create('guests', function (Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->bigIncrements('id')->comment('Model ID');
			$table->unsignedBigInteger('event_id')->index('event_id')->comment('ID of the Demo Event they were Guests for');
			$table->unsignedBigInteger('chapter_id')->index('chapter_id')->nullable()->comment('ID of the closest Chapter to the Guest, if known');
			$table->boolean('is_followedup')->default(false)->comment('Has this Guest (default false) been followed up with?');
			$table->string('notes')->nullable()->comment('Notes about the Guest, if any');
			$table->unsignedBigInteger('created_by')->default(1)->index('created_by');
			$table->timestamp('created_at')->useCurrent();
			$table->unsignedBigInteger('updated_by')->nullable()->index('updated_by');
			$table->timestamp('updated_at')->nullable();
			$table->unsignedBigInteger('deleted_by')->nullable()->index('deleted_by');
			$table->softDeletes();
		});

		Schema::create('issuances', function (Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->bigIncrements('id')->comment('Model ID');
			$table->enum('issuable_type', ['Award', 'Title'])->comment('The Issuance type; Award or Title');
			$table->unsignedBigInteger('issuable_id')->index('issuable_id')->comment('The ID of the Issuance');
			$table->enum('whereable_type', ['Event','Location','Meetup'])->nullable()->comment('Where it was Issued, if known; Event, Location, or Meetup');
			$table->unsignedBigInteger('whereable_id')->index('whereable_id')->nullable()->comment('The ID of where it was Issued');
			$table->enum('issuer_type', ['Chapter', 'Persona', 'Realm', 'Unit'])->comment('Issuing authority; Chapter, Persona, Realm, or Unit');
			$table->unsignedBigInteger('issuer_id')->index('issuer_id')->comment('The ID of the Issuing authority');
			$table->enum('recipient_type', ['Persona', 'Unit'])->comment('Who recieved the Issuance; Persona or Unit');
			$table->unsignedBigInteger('recipient_id')->index('recipient_id')->comment('The ID of the Issuance recipient');
			$table->unsignedBigInteger('signator_id')->nullable()->index('signator_id')->comment('Persona signing the Issuance, if any');
			$table->string('custom_name', 64)->nullable()->comment('Where label options are avaiable, or customization allowed, the chosen label, else null');
			$table->unsignedInteger('rank')->nullable()->comment('For laddered Issuances, the order number, else null');
			$table->date('issued_on')->comment('When the Issuance was made or is to be made public (if in the future)');
			$table->string('reason', 400)->nullable()->comment('A historical record of what the Issuance was for');
			$table->string('image', 255)->nullable()->comment('An internal link to an image of the Issuance phyrep, if any');
			$table->unsignedBigInteger('revoked_by')->nullable()->index('revoked_by')->comment('ID of the Persona that revoked the Issuance, if any');
			$table->date('revoked_on')->nullable()->comment("Date the revocation is effective, if any");
			$table->string('revocation', 50)->nullable()->comment("Cause for the revocation, if any");
			$table->unsignedBigInteger('created_by')->default(1)->index('created_by');
			$table->timestamp('created_at')->useCurrent();
			$table->unsignedBigInteger('updated_by')->nullable()->index('updated_by');
			$table->timestamp('updated_at')->nullable();
			$table->unsignedBigInteger('deleted_by')->nullable()->index('deleted_by');
			$table->softDeletes();
		});

		Schema::create('locations', function (Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->bigIncrements('id')->comment('Model ID');
			$table->string('label', 50)->nullable()->comment('The Location label, as it might appear on a map');
			$table->string('address')->nullable()->comment('The street address of the Location, if any');
			$table->string('city', 50)->nullable()->comment('The city of the Location, if any');
			$table->string('province', 35)->nullable()->comment('The state or provice of the Location, if any');
			$table->string('postal_code', 10)->nullable()->comment('The zip or postal code of the Location, if any');
			$table->string('country', 2)->nullable()->default('US')->comment('The two letter country code of the Location (default US), if any');
			$table->mediumText('google_geocode')->nullable()->comment('JSON encoded Google Geocode data of the Location, if any');
			$table->double('latitude')->nullable()->comment('Latitude of the Location, if any');
			$table->double('longitude')->nullable()->comment('Longitude of the Location, if any');
			$table->mediumText('location')->nullable()->comment('JSON encoded Google location services data of the Location, if any');
			$table->mediumText('map_url')->nullable()->comment('An external map link of the Location, if any');
			$table->mediumText('directions')->nullable()->comment('Directions required to properly navigate the last part of the journey to, or park at, the Location, if any');
			$table->unsignedBigInteger('created_by')->default(1)->index('created_by');
			$table->timestamp('created_at')->useCurrent();
			$table->unsignedBigInteger('updated_by')->nullable()->index('updated_by');
			$table->timestamp('updated_at')->nullable();
			$table->unsignedBigInteger('deleted_by')->nullable()->index('deleted_by');
			$table->softDeletes();
		});

		Schema::create('meetups', function (Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->bigIncrements('id')->comment('Model ID');
			$table->unsignedBigInteger('chapter_id')->index('chapter_id')->comment('The ID of the Chapter hosting the Meetup');
			$table->unsignedBigInteger('location_id')->nullable()->index('location_id')->comment('The ID of the Location the Meetup occurs at');
			$table->boolean('is_active')->default(true)->comment('Is (default true) the Meetup still occuring?');
			$table->enum('purpose', ['Park Day', 'Fighter Practice', 'A&S Gathering', 'Other'])->comment('The nature of the Meetup; Park Day, Fighter Practice, A&S Gathering, or Other');
			$table->enum('recurrence', ['Weekly', 'Monthly', 'Week-of-Month'])->comment('The frequency with which this Meetup occurs');
			$table->smallInteger('week_of_month')->nullable()->comment('The week of the month the Meetup occurs, if recurrence is Week-of-Month');
			$table->enum('week_day', ['None', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'])->comment('They day of the week the Meetup occurs, if recurrence is Weekly');
			$table->smallInteger('month_day')->nullable()->comment('The day of the month the Meetup occurs, if recurrence is Monthly');
			$table->time('occurs_at')->comment('The time of day the Meetup takes place');
			$table->string('description')->nullable()->comment('A description of the Meetup, if any');
			$table->unsignedBigInteger('created_by')->default(1)->index('created_by');
			$table->timestamp('created_at')->useCurrent();
			$table->unsignedBigInteger('updated_by')->nullable()->index('updated_by');
			$table->timestamp('updated_at')->nullable();
			$table->unsignedBigInteger('deleted_by')->nullable()->index('deleted_by');
			$table->softDeletes();
		});

		Schema::create('members', function (Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->bigIncrements('id')->comment('Model ID');
			$table->unsignedBigInteger('persona_id')->index('persona_id')->comment('The ID of the Persona that has Membership in the given Unit');
			$table->unsignedBigInteger('unit_id')->index('unit_id')->comment('The ID of the Unit of which they are Members');
			$table->boolean('is_head')->default(false)->comment('Is (default false) this Persona the single point of contact for the Unit?');
			$table->boolean('is_voting')->default(false)->comment('Is this Persona (default false) a full voting Member?');
			$table->date('joined_at')->nullable()->comment('The date this Persona joined the Unit, if known');
			$table->date('left_at')->nullable()->comment('The date this Persona left the Unit, if they have');
			$table->string('notes')->nullable()->comment('Notes on the Membership, if any');
			$table->unsignedBigInteger('created_by')->default(1)->index('created_by');
			$table->timestamp('created_at')->useCurrent();
			$table->unsignedBigInteger('updated_by')->nullable()->index('updated_by');
			$table->timestamp('updated_at')->nullable();
			$table->unsignedBigInteger('deleted_by')->nullable()->index('deleted_by');
			$table->softDeletes();
		});

		Schema::create('officers', function (Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->bigIncrements('id')->comment('Model ID');
			$table->enum('officerable_type', ['Reign', 'Unit'])->comment('Type of that which the Persona is Officer of; Reign or Unit');
			$table->unsignedBigInteger('officerable_id')->index('officerable_id')->comment('The ID of the Reign or Unit they are Officer of');
			$table->unsignedBigInteger('office_id')->index('office_id')->comment('The ID of the Office this Persona held');
			$table->unsignedBigInteger('persona_id')->index('persona_id')->comment('The ID of the Persona holding this Office');
			$table->string('label', 50)->nullable()->comment('If the Office name has options, or allows customization, the selected label, if any');
			$table->date('starts_on')->nullable()->comment('If the Officer is pro-tem, or is for a Unit, when the Office began, otherwise null to use Reign data');
			$table->date('ends_on')->nullable()->comment('If the Officer ends their term early, or is for a Unit, when the Office was exited, otherwise null to use Reign data');
			$table->string('notes')->nullable()->comment('Notes about the Officer or their time in office, or explaining pro-tem, if any');
			$table->unsignedBigInteger('created_by')->default(1)->index('created_by');
			$table->timestamp('created_at')->useCurrent();
			$table->unsignedBigInteger('updated_by')->nullable()->index('updated_by');
			$table->timestamp('updated_at')->nullable();
			$table->unsignedBigInteger('deleted_by')->nullable()->index('deleted_by');
			$table->softDeletes();
		});

		Schema::create('offices', function (Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->bigIncrements('id')->comment('Model ID');
			$table->enum('officeable_type', ['Chaptertype', 'Realm', 'Unit'])->comment('Type for what the Office is for; Chaptertype, Realm, or Unit');
			$table->unsignedBigInteger('officeable_id')->index('officeable_id')->comment('The ID of what the Office is for');
			$table->string('name', 100)->comment('The name of the Office, options delineated with a single |');
			$table->integer('duration')->nullable()->default(6)->comment('Duration, in months, of the office (default 6)');
			$table->integer('order')->nullable()->comment('If the Realm has an order of prescidence, the office level where Monarch = 1, else null');
			$table->unsignedBigInteger('created_by')->default(1)->index('created_by');
			$table->timestamp('created_at')->useCurrent();
			$table->unsignedBigInteger('updated_by')->nullable()->index('updated_by');
			$table->timestamp('updated_at')->nullable();
			$table->unsignedBigInteger('deleted_by')->nullable()->index('deleted_by');
			$table->softDeletes();
		});

		Schema::create('personas', function (Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->bigIncrements('id')->comment('Model ID');
			$table->unsignedBigInteger('chapter_id')->index('chapter_id')->comment('The ID of the Chapter the Persona is Waivered at');
			$table->unsignedBigInteger('pronoun_id')->nullable()->index('pronoun_id')->comment('The ID of the pronouns associated with this Persona, if known');
			$table->string('mundane')->nullable()->comment('What the Persona typically enters into the Mundane field of the sign-in');
			$table->string('name')->comment('The Persona name, without titles or honors, but otherwise in full');
			$table->string('heraldry')->nullable()->comment('An internal link to an image of the Persona heraldry');
			$table->string('image')->nullable()->comment('An internal link to an image of the Persona');
			$table->boolean('is_active')->default(true)->comment('Is (default true) the Persona still active?');
			$table->date('reeve_qualified_expires_at')->nullable()->comment('If they are Reeve Qualified, when it expires');
			$table->date('corpora_qualified_expires_at')->nullable()->comment('If they are Corpora Qualified, when it expires');
			$table->date('joined_chapter_at')->nullable()->comment('The date the Persona joined the Chapter, either as a newb or a transfer');
			$table->unsignedBigInteger('created_by')->default(1)->index('created_by');
			$table->timestamp('created_at')->useCurrent();
			$table->unsignedBigInteger('updated_by')->nullable()->index('updated_by');
			$table->timestamp('updated_at')->nullable();
			$table->unsignedBigInteger('deleted_by')->nullable()->index('deleted_by');
			$table->softDeletes();
		});

		Schema::create('pronouns', function (Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->bigIncrements('id')->comment('Model ID');
			$table->string('subject', 30)->comment('Pronoun Subject');
			$table->string('object', 30)->comment('Pronoun Object');
			$table->string('possessive', 30)->comment('Pronoun Possessive');
			$table->string('possessivepronoun', 30)->comment('Pronoun Possessive Pronoun');
			$table->string('reflexive', 30)->comment('Pronoun Reflexive');
			$table->unsignedBigInteger('created_by')->default(1)->index('created_by');
			$table->timestamp('created_at')->useCurrent();
			$table->unsignedBigInteger('updated_by')->nullable()->index('updated_by');
			$table->timestamp('updated_at')->nullable();
			$table->unsignedBigInteger('deleted_by')->nullable()->index('deleted_by');
			$table->softDeletes();
		});
			
		Schema::create('realms', function (Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->bigIncrements('id')->comment('Model ID');
			$table->unsignedBigInteger('parent_id')->nullable()->index('parent_id')->comment('If sponsored by another Realm, that Realm ID');
			$table->string('name', 100)->comment('The label for the Realm');
			$table->string('abbreviation', 4)->comment('A simple, unique, usually two letter abbreviation commonly used for the Realm');
			$table->string('color', 6)->default('FACADE')->comment('The hexidecimal code (default FACADE) for the color used for the Realm on various UIs');
			$table->string('heraldry')->nullable()->comment('An internal link to the Realm heraldry image');
			$table->boolean('is_active')->default(true)->comment('Is (default true) the Realm active?');
			$table->unsignedSmallInteger('credit_minimum')->nullable()->comment('Realm Credit Minimum setting, if any');
			$table->unsignedSmallInteger('credit_maximum')->nullable()->comment('Realm Credit Maximum setting, if any');
			$table->unsignedSmallInteger('daily_minimum')->nullable()->comment('Realm Daily Minimum setting, if any');
			$table->unsignedSmallInteger('weekly_minimum')->nullable()->comment('Realm Weekly Minimum setting, if any');
			$table->enum('average_period_type', ['Week','Month'])->nullable()->comment('Realm Average Period Type setting, if any');
			$table->unsignedSmallInteger('average_period')->nullable()->comment('Realm Average Period setting, if any');
			$table->unsignedSmallInteger('dues_amount')->nullable()->comment('Dues cost per interval for the Realm, if any');
			$table->enum('dues_intervals_type', ['Week','Month'])->nullable()->comment('Dues intervals type for the Realm, if any');
			$table->unsignedSmallInteger('dues_intervals')->nullable()->comment('Dues intervals count for the Realm, if any');
			$table->unsignedSmallInteger('dues_take')->nullable()->comment('Realm take of Dues paid to Chapters, if any');
			$table->unsignedBigInteger('created_by')->default(1)->index('created_by');
			$table->timestamp('created_at')->useCurrent();
			$table->unsignedBigInteger('updated_by')->nullable()->index('updated_by');
			$table->timestamp('updated_at')->nullable();
			$table->unsignedBigInteger('deleted_by')->nullable()->index('deleted_by');
			$table->softDeletes();
		});

		Schema::create('recommendations', function (Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->bigIncrements('id')->comment('Model ID');
			$table->unsignedBigInteger('persona_id')->index('mundane_id')->comment('The ID of the Persona the Recommendation is for');
			$table->enum('recommendable_type', ['Award', 'Title'])->comment('The type of Issuances being Recommended; Award or Title');
			$table->unsignedBigInteger('recommendable_id')->index('recommendable_id')->comment('The ID of the Title or Award being Recommended');
			$table->integer('rank')->nullable()->comment('If a ranked or ladder award, Recommended level');
			$table->boolean('is_anonymous')->default(false)->comment('Does (default false) the Recommendation creator wish to be anonymous?');
			$table->string('reason', 400)->comment('What the Recommendation is for');
			$table->unsignedBigInteger('created_by')->default(1)->index('created_by');
			$table->timestamp('created_at')->useCurrent();
			$table->unsignedBigInteger('updated_by')->nullable()->index('updated_by');
			$table->timestamp('updated_at')->nullable();
			$table->unsignedBigInteger('deleted_by')->nullable()->index('deleted_by');
			$table->softDeletes();
		});
			
		Schema::create('reconciliations', function (Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->bigIncrements('id')->comment('Model ID');
			$table->unsignedBigInteger('archetype_id')->index('archetype_id')->comment('The ID of the Archetype the Reconcilliation credits are for');
			$table->unsignedBigInteger('persona_id')->index('persona_id')->comment('The ID of the Persona getting Reconciled');
			$table->double('credits', 6, 2)->default(1)->comment('The number of credits to be given or removed (with negative value) from the Persona for the Archetype');
			$table->string('notes')->nullable()->comment('Why the Reconciliation was required, and how they might be removed');
			$table->unsignedBigInteger('created_by')->default(1)->index('created_by');
			$table->timestamp('created_at')->useCurrent();
			$table->unsignedBigInteger('updated_by')->nullable()->index('updated_by');
			$table->timestamp('updated_at')->nullable();
			$table->unsignedBigInteger('deleted_by')->nullable()->index('deleted_by');
			$table->softDeletes();
		});
			
		Schema::create('reigns', function (Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->bigIncrements('id')->comment('Model ID');
			$table->enum('reignable_type', ['Chapter', 'Realm'])->comment('The Reign type; Chapter or Realm');
			$table->unsignedBigInteger('reignable_id')->index('reignable_id')->comment('The ID of the Realm or Chapter this Reign is for');
			$table->string('name', 100)->nullable()->comment('The name of the Reign, if any');
			$table->date('starts_on')->comment('Date the Reign begins (coronation)');
			$table->date('midreign_on')->comment('Date of the Reign Midreign');
			$table->date('ends_on')->comment('Date the next Reign begins, and this one ends');
			$table->unsignedBigInteger('created_by')->default(1)->index('created_by');
			$table->timestamp('created_at')->useCurrent();
			$table->unsignedBigInteger('updated_by')->nullable()->index('updated_by');
			$table->timestamp('updated_at')->nullable();
			$table->unsignedBigInteger('deleted_by')->nullable()->index('deleted_by');
			$table->softDeletes();
		});
			
		Schema::create('socials', function (Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->bigIncrements('id')->comment('Model ID');
			$table->enum('sociable_type', ['Chapter', 'Event', 'Persona', 'Realm', 'Unit'])->comment('The Model for which the Social is for; Chapter, Event, Persona, Realm, or Unit');
			$table->unsignedBigInteger('sociable_id')->index('sociable_id')->comment('The ID of the entry with this Social');
			$table->enum('media', ['Discord', 'Facebook', 'Instagram', 'TikTok', 'YouTube', 'Web'])->comment('The type of Social; Discord, Facebook, Instagram, TikTok, YouTube, or Web');
			$table->string('value', 255)->comment('The link, username, or other identifier for the given media');
			$table->unsignedBigInteger('created_by')->default(1)->index('created_by');
			$table->timestamp('created_at')->useCurrent();
			$table->unsignedBigInteger('updated_by')->nullable()->index('updated_by');
			$table->timestamp('updated_at')->nullable();
			$table->unsignedBigInteger('deleted_by')->nullable()->index('deleted_by');
			$table->softDeletes();
		});

		Schema::create('splits', function (Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->bigIncrements('id')->comment('Model ID');
			$table->unsignedBigInteger('account_id')->index('account_id')->comment('The ID of the Account this Split is for');
			$table->unsignedBigInteger('persona_id')->index('persona_id')->comment('The ID of the Persona performing the Transaction');
			$table->unsignedBigInteger('transaction_id')->index('transaction_id')->comment('The ID of the Transaction being Split');
			$table->double('amount', 10, 4)->comment('How much the Split is for');
			$table->unsignedBigInteger('created_by')->default(1)->index('created_by');
			$table->timestamp('created_at')->useCurrent();
			$table->unsignedBigInteger('updated_by')->nullable()->index('updated_by');
			$table->timestamp('updated_at')->nullable();
			$table->unsignedBigInteger('deleted_by')->nullable()->index('deleted_by');
			$table->softDeletes();
		});

		Schema::create('suspensions', function (Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->bigIncrements('id')->comment('Model ID');
			$table->unsignedBigInteger('persona_id')->index('persona_id')->comment('The ID of the Persona that has been Suspended');
			$table->enum('suspendable_type', ['Chapter', 'Realm'])->comment('The Model that levied the Suspension; Chapter or Realm');
			$table->unsignedBigInteger('suspendable_id')->index('suspendable_id')->comment('The ID of the entry that levied the Suspension');
			$table->unsignedBigInteger('suspended_by')->index('suspended_by')->comment('The ID of the Persona issuing the Suspension');
			$table->date('suspended_at')->comment('The date the Suspension begins');
			$table->date('expires_at')->nullable()->comment('The date the Suspension ends, if any, null for forever');
			$table->string('cause')->comment('Why the suspension was issued');
			$table->boolean('is_propogating')->default(false)->comment('Does (default false) the Suspension propogate to all Realms?');
			$table->unsignedBigInteger('created_by')->default(1)->index('created_by');
			$table->timestamp('created_at')->useCurrent();
			$table->unsignedBigInteger('updated_by')->nullable()->index('updated_by');
			$table->timestamp('updated_at')->nullable();
			$table->unsignedBigInteger('deleted_by')->nullable()->index('deleted_by');
			$table->softDeletes();
		});

		Schema::create('titles', function (Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->bigIncrements('id')->comment('Model ID');
			$table->enum('titleable_type', ['Chapter', 'Persona', 'Realm', 'Unit'])->comment('The Model of who can issue the Title; Chapter, Persona, Realm, or Unit');
			$table->unsignedBigInteger('titleable_id')->nullable()->index('titleable_id')->comment('The ID of the Title issuer');
			$table->string('name', 100)->comment('The Title name with options seperated by a single |');
			$table->unsignedSmallInteger('rank')->nullable()->comment('For Realm Titles or where appropriate, their order of prescidence in that Realm expressed (usually) in multiples of 10, where Lord|Lady are typically 30');
			$table->enum('peerage', ['Gentry', 'Knight', 'Squire', 'Master', 'Nobility', 'None', 'Paragon', 'Retainer'])->default('None')->comment('The peerage (default None) of the Title; Gentry, Knight, Squire, Master, Nobility, None, Paragon, or Retainer');
			$table->boolean('is_roaming')->default(false)->comment('Is (default false) the Title roaming, such as Dragonmaster?');
			$table->boolean('is_active')->default(true)->comment('Is (default true) this Title still being given out?');
			$table->unsignedBigInteger('created_by')->default(1)->index('created_by');
			$table->timestamp('created_at')->useCurrent();
			$table->unsignedBigInteger('updated_by')->nullable()->index('updated_by');
			$table->timestamp('updated_at')->nullable();
			$table->unsignedBigInteger('deleted_by')->nullable()->index('deleted_by');
			$table->softDeletes();
		});

		Schema::create('tournaments', function (Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->bigIncrements('id')->comment('Model ID');
			$table->enum('tournamentable_type', ['Chapter', 'Event', 'Realm'])->comment('The Tournament sponsor type; Chapter, Event, or Realm');
			$table->unsignedBigInteger('tournamentable_id')->index('tournamentable_id')->comment('The ID of the Tournament sponsor');
			$table->string('name', 50)->comment('The name of the Tournament');
			$table->mediumText('description')->nullable()->comment('A description of the Tournament');
			$table->dateTime('occured_at')->comment('Date and time the Tournament occured');
			$table->unsignedBigInteger('created_by')->default(1)->index('created_by');
			$table->timestamp('created_at')->useCurrent();
			$table->unsignedBigInteger('updated_by')->nullable()->index('updated_by');
			$table->timestamp('updated_at')->nullable();
			$table->unsignedBigInteger('deleted_by')->nullable()->index('deleted_by');
			$table->softDeletes();
		});

		Schema::create('transactions', function (Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->bigIncrements('id')->comment('Model ID');
			$table->string('description')->comment('A description of the Transaction');
			$table->mediumText('memo')->nullable()->comment('A memo for the Transaction, if any');
			$table->date('transaction_at')->comment('Date the Transaction occured');
			$table->unsignedBigInteger('created_by')->default(1)->index('created_by');
			$table->timestamp('created_at')->useCurrent();
			$table->unsignedBigInteger('updated_by')->nullable()->index('updated_by');
			$table->timestamp('updated_at')->nullable();
			$table->unsignedBigInteger('deleted_by')->nullable()->index('deleted_by');
			$table->softDeletes();
		});

		Schema::create('units', function (Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->bigIncrements('id')->comment('Model ID');
			$table->enum('type', ['Company', 'Event', 'Household'])->default('Household')->comment('Unit type; Company, Event, or Household');
			$table->string('name', 100)->comment('Name of the Unit');
			$table->string('heraldry')->nullable()->comment('An internal link to an image of the Unit heraldry, if any');
			$table->mediumText('description')->nullable()->comment('A public facing description of the Unit');
			$table->mediumText('history')->nullable()->comment('For use as the Unit requires, history of the Unit, if any');
			$table->unsignedBigInteger('created_by')->default(1)->index('created_by');
			$table->timestamp('created_at')->useCurrent();
			$table->unsignedBigInteger('updated_by')->nullable()->index('updated_by');
			$table->timestamp('updated_at')->nullable();
			$table->unsignedBigInteger('deleted_by')->nullable()->index('deleted_by');
			$table->softDeletes();
		});

		Schema::create('users', function (Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->bigIncrements('id')->comment('Model ID');
			$table->unsignedBigInteger('persona_id')->index('persona_id')->comment('The ID of the Persona associated with this User');
			$table->string('email')->unique()->comment('Unique email used to identify and communicate with the User');
			$table->timestamp('email_verified_at')->nullable()->comment('When the User email was verified, if at all');
			$table->string('password')->comment('Encoded password string');
			$table->rememberToken()->comment('Encoded string used to maintain login');
			$table->string('api_token', 80)->unique()->nullable()->default(null);
			$table->boolean('is_restricted')->default(false)->comment('Is (default false) the User restricted from using the site?');
			$table->unsignedBigInteger('created_by')->default(1)->index('created_by');
			$table->timestamp('created_at')->useCurrent();
			$table->unsignedBigInteger('updated_by')->nullable()->index('updated_by');
			$table->timestamp('updated_at')->nullable();
			$table->unsignedBigInteger('deleted_by')->nullable()->index('deleted_by');
			$table->softDeletes();
		});

		Schema::create('waivers', function (Blueprint $table) {
			$table->engine = 'InnoDB';
			$table->bigIncrements('id')->comment('Model ID');
			$table->unsignedBigInteger('guest_id')->nullable()->index('guest_id')->comment('The ID of the Guest this Waiver is for, if any');
			$table->unsignedBigInteger('location_id')->nullable()->index('location_id')->comment('The Waiver address fields values');
			$table->unsignedBigInteger('pronoun_id')->nullable()->index('pronoun_id')->comment('The ID of the Pronoun for the individual being Waivered, if known');
			$table->unsignedBigInteger('persona_id')->nullable()->index('persona_id')->comment('The ID of the Persona this Waiver is for, if any');
			$table->enum('waiverable_type', ['Realm', 'Event'])->comment('The type of entity accepting the Waiver; Realm or Event');
			$table->unsignedBigInteger('waiverable_id')->index('waiverable_id')->comment('The ID of the entity accepting the Waiver');
			$table->string('file')->nullable()->comment('An internal link to an image of the original physical Waiver');
			$table->string('player', 150)->comment('The Waiver Mundane name field value');
			$table->string('email', 255)->nullable()->comment('The Waiver email field value, if any');
			$table->string('phone', 25)->nullable()->comment('The Waiver phone field value, if any');
			$table->date('dob')->nullable()->comment('The Waiver date of birth field value');
			$table->date('age_verified_at')->nullable()->comment('The date the Waiver signer age is verified, if it has been');
			$table->unsignedBigInteger('age_verified_by')->nullable()->index('age_verified_by')->comment('The ID of the Persona that verified the Waiver signer age, if it has been');
			$table->string('guardian', 150)->nullable()->comment('The Waiver guardian name, if any');
			$table->string('emergency_name', 150)->nullable()->comment('The Waiver emergency contact field, if any');
			$table->string('emergency_relationship', 150)->nullable()->comment('The Waiver emergency contact relationship field, if any');
			$table->string('emergency_phone', 25)->nullable()->comment('The Waiver emergency contact phone field, if any');
			$table->date('signed_at')->comment('Date the Waiver was signed');
			$table->unsignedBigInteger('created_by')->default(1)->index('created_by');
			$table->timestamp('created_at')->useCurrent();
			$table->unsignedBigInteger('updated_by')->nullable()->index('updated_by');
			$table->timestamp('updated_at')->nullable();
			$table->unsignedBigInteger('deleted_by')->nullable()->index('deleted_by');
			$table->softDeletes();
		});

		Schema::table('accounts', function (Blueprint $table) {
			$table->foreign(['created_by'], 'accounts_created_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign(['deleted_by'], 'accounts_deleted_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign(['parent_id'], 'accounts_parent_id')->references(['id'])->on('accounts')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign(['updated_by'], 'accounts_updated_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});

		Schema::table('archetypes', function (Blueprint $table) {
			$table->foreign(['created_by'], 'archetypes_created_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign(['deleted_by'], 'archetypes_deleted_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign(['updated_by'], 'archetypes_updated_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});

		Schema::table('attendances', function (Blueprint $table) {
			$table->foreign(['archetype_id'], 'attendances_archetype_id')->references(['id'])->on('archetypes')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign(['created_by'], 'attendances_created_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign(['deleted_by'], 'attendances_deleted_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign(['updated_by'], 'attendances_updated_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign(['persona_id'], 'attendances_persona_id')->references(['id'])->on('personas')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});

		Schema::table('awards', function (Blueprint $table) {
			$table->foreign(['created_by'], 'awards_created_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign(['deleted_by'], 'awards_deleted_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign(['updated_by'], 'awards_updated_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
			
		Schema::table('crats', function (Blueprint $table) {
			$table->foreign(['event_id'], 'crats_event_id')->references(['id'])->on('events')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign(['persona_id'], 'crats_persona_id')->references(['id'])->on('personas')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign(['created_by'], 'crats_created_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign(['deleted_by'], 'crats_deleted_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign(['updated_by'], 'crats_updated_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});

		Schema::table('dues', function (Blueprint $table) {
			$table->foreign(['created_by'], 'dues_created_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign(['deleted_by'], 'dues_deleted_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign(['transaction_id'], 'dues_transaction_id')->references(['id'])->on('transactions')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign(['updated_by'], 'dues_updated_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign(['persona_id'], 'dues_persona_id')->references(['id'])->on('personas')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});

		Schema::table('events', function (Blueprint $table) {
			$table->foreign(['created_by'], 'events_created_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign(['deleted_by'], 'events_deleted_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign(['location_id'], 'events_location_id')->references(['id'])->on('locations')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign(['updated_by'], 'events_updated_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
			
		Schema::table('guests', function (Blueprint $table) {
			$table->foreign(['event_id'], 'guests_event_id')->references(['id'])->on('events')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign(['chapter_id'], 'guests_chapter_id')->references(['id'])->on('chapters')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign(['created_by'], 'guests_created_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign(['deleted_by'], 'guests_deleted_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign(['updated_by'], 'guests_updated_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});

		Schema::table('issuances', function (Blueprint $table) {
			$table->foreign(['created_by'], 'issuances_created_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign(['deleted_by'], 'issuances_deleted_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign(['signator_id'], 'issuances_signator_id')->references(['id'])->on('personas')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign(['revoked_by'], 'issuances_revoked_by')->references(['id'])->on('personas')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign(['updated_by'], 'issuances_updated_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});

		Schema::table('realms', function (Blueprint $table) {
			$table->foreign(['created_by'], 'realms_created_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign(['deleted_by'], 'realms_deleted_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign(['parent_id'], 'realms_parent_id')->references(['id'])->on('realms')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign(['updated_by'], 'realms_updated_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});

		Schema::table('locations', function (Blueprint $table) {
			$table->foreign(['created_by'], 'locations_created_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign(['deleted_by'], 'locations_deleted_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign(['updated_by'], 'locations_updated_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});

		Schema::table('meetups', function (Blueprint $table) {
			$table->foreign(['created_by'], 'meetups_created_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign(['deleted_by'], 'meetups_deleted_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign(['location_id'], 'meetups_location_id')->references(['id'])->on('locations')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign(['chapter_id'], 'meetups_chapter_id')->references(['id'])->on('chapters')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign(['updated_by'], 'meetups_updated_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});

		Schema::table('members', function (Blueprint $table) {
			$table->foreign(['created_by'], 'members_created_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign(['deleted_by'], 'members_deleted_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign(['unit_id'], 'members_unit_id')->references(['id'])->on('units')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign(['updated_by'], 'members_updated_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign(['persona_id'], 'members_persona_id')->references(['id'])->on('personas')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});

		Schema::table('officers', function (Blueprint $table) {
			$table->foreign(['created_by'], 'officers_created_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign(['deleted_by'], 'officers_deleted_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign(['office_id'], 'officers_office_id')->references(['id'])->on('offices')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign(['updated_by'], 'officers_updated_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign(['persona_id'], 'officers_persona_id')->references(['id'])->on('personas')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});

		Schema::table('offices', function (Blueprint $table) {
			$table->foreign(['created_by'], 'offices_created_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign(['deleted_by'], 'offices_deleted_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign(['updated_by'], 'offices_updated_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});

		Schema::table('chaptertypes', function (Blueprint $table) {
			$table->foreign(['created_by'], 'chaptertypes_created_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign(['deleted_by'], 'chaptertypes_deleted_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign(['realm_id'], 'chaptertypes_realm_id')->references(['id'])->on('realms')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign(['updated_by'], 'chaptertypes_updated_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});

		Schema::table('chapters', function (Blueprint $table) {
			$table->foreign(['created_by'], 'chapters_created_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign(['deleted_by'], 'chapters_deleted_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign(['updated_by'], 'chapters_updated_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign(['realm_id'], 'chapters_realm_id')->references(['id'])->on('realms')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign(['chaptertype_id'], 'chapters_chaptertype_id')->references(['id'])->on('chaptertypes')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign(['location_id'], 'chapters_location_id')->references(['id'])->on('locations')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});

		Schema::table('personas', function (Blueprint $table) {
			$table->foreign(['chapter_id'], 'personas_chapter_id')->references(['id'])->on('chapters')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign(['pronoun_id'], 'personas_pronoun_id')->references(['id'])->on('pronouns')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign(['created_by'], 'personas_created_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign(['deleted_by'], 'personas_deleted_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign(['updated_by'], 'personas_updated_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});

		Schema::table('pronouns', function (Blueprint $table) {
			$table->foreign(['created_by'], 'pronouns_created_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign(['deleted_by'], 'pronouns_deleted_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign(['updated_by'], 'pronouns_updated_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});

		Schema::table('recommendations', function (Blueprint $table) {
			$table->foreign(['created_by'], 'recommendations_created_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign(['deleted_by'], 'recommendations_deleted_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign(['updated_by'], 'recommendations_updated_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign(['persona_id'], 'recommendations_persona_id')->references(['id'])->on('personas')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
			
		Schema::table('reigns', function (Blueprint $table) {
			$table->foreign(['created_by'], 'reigns_created_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign(['deleted_by'], 'reigns_deleted_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign(['updated_by'], 'reigns_updated_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});

		Schema::table('reconciliations', function (Blueprint $table) {
			$table->foreign(['archetype_id'], 'reconciliations_archetype_id')->references(['id'])->on('archetypes')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign(['created_by'], 'reconciliations_created_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign(['deleted_by'], 'reconciliations_deleted_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign(['updated_by'], 'reconciliations_updated_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign(['persona_id'], 'reconciliations_persona_id')->references(['id'])->on('personas')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
			
		Schema::table('socials', function (Blueprint $table) {
			$table->foreign(['created_by'], 'socials_created_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign(['deleted_by'], 'socials_deleted_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign(['updated_by'], 'socials_updated_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});

		Schema::table('splits', function (Blueprint $table) {
			$table->foreign(['account_id'], 'splits_account_id')->references(['id'])->on('accounts')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign(['created_by'], 'splits_created_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign(['deleted_by'], 'splits_deleted_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign(['transaction_id'], 'splits_transaction_id')->references(['id'])->on('transactions')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign(['updated_by'], 'splits_updated_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign(['persona_id'], 'splits_persona_id')->references(['id'])->on('personas')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});

		Schema::table('suspensions', function (Blueprint $table) {
			$table->foreign(['created_by'], 'suspensions_created_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign(['deleted_by'], 'suspensions_deleted_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign(['suspended_by'], 'suspensions_suspended_by')->references(['id'])->on('personas')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign(['updated_by'], 'suspensions_updated_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign(['persona_id'], 'suspensions_persona_id')->references(['id'])->on('personas')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});

		Schema::table('titles', function (Blueprint $table) {
			$table->foreign(['created_by'], 'titles_created_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign(['deleted_by'], 'titles_deleted_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign(['updated_by'], 'titles_updated_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});

		Schema::table('tournaments', function (Blueprint $table) {
			$table->foreign(['created_by'], 'tournaments_created_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign(['deleted_by'], 'tournaments_deleted_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign(['updated_by'], 'tournaments_updated_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});

		Schema::table('transactions', function (Blueprint $table) {
			$table->foreign(['created_by'], 'transactions_created_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign(['deleted_by'], 'transactions_deleted_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign(['updated_by'], 'transactions_updated_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});

		Schema::table('units', function (Blueprint $table) {
			$table->foreign(['created_by'], 'units_created_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign(['deleted_by'], 'units_deleted_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign(['updated_by'], 'units_updated_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});

		Schema::table('users', function (Blueprint $table) {
			$table->foreign(['persona_id'], 'users_persona_id')->references(['id'])->on('personas')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign(['created_by'], 'users_created_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign(['deleted_by'], 'users_deleted_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign(['updated_by'], 'users_updated_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});

		Schema::table('waivers', function (Blueprint $table) {
			$table->foreign(['age_verified_by'], 'waivers_age_verified_by')->references(['id'])->on('personas')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign(['guest_id'], 'waivers_guest_id')->references(['id'])->on('guests')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign(['location_id'], 'waivers_location_id')->references(['id'])->on('locations')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign(['persona_id'], 'waivers_persona_id')->references(['id'])->on('personas')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign(['pronoun_id'], 'waivers_pronoun_id')->references(['id'])->on('pronouns')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign(['created_by'], 'waivers_created_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign(['deleted_by'], 'waivers_deleted_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign(['updated_by'], 'waivers_updated_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{

		Schema::table('waivers', function (Blueprint $table) {
			$table->dropForeign('age_verified_by');
			$table->dropForeign('location_id');
			$table->dropForeign('persona_id');
			$table->dropForeign('guest_id');
			$table->dropForeign('pronoun_id');
			$table->dropForeign('created_by');
			$table->dropForeign('deleted_by');
			$table->dropForeign('updated_by');
		});
		
		Schema::table('users', function (Blueprint $table) {
			$table->dropForeign('users_persona_id');
			$table->dropForeign('users_created_by');
			$table->dropForeign('users_deleted_by');
			$table->dropForeign('users_updated_by');
		});

		Schema::table('units', function (Blueprint $table) {
			$table->dropForeign('units_created_by');
			$table->dropForeign('units_deleted_by');
			$table->dropForeign('units_updated_by');
		});

		Schema::table('transactions', function (Blueprint $table) {
			$table->dropForeign('transactions_created_by');
			$table->dropForeign('transactions_deleted_by');
			$table->dropForeign('transactions_updated_by');
		});

		Schema::table('tournaments', function (Blueprint $table) {
			$table->dropForeign('tournaments_created_by');
			$table->dropForeign('tournaments_deleted_by');
			$table->dropForeign('tournaments_updated_by');
		});

		Schema::table('titles', function (Blueprint $table) {
			$table->dropForeign('titles_created_by');
			$table->dropForeign('titles_deleted_by');
			$table->dropForeign('titles_updated_by');
		});

		Schema::table('suspensions', function (Blueprint $table) {
			$table->dropForeign('suspensions_created_by');
			$table->dropForeign('suspensions_deleted_by');
			$table->dropForeign('suspensions_suspended_by');
			$table->dropForeign('suspensions_updated_by');
			$table->dropForeign('suspensions_persona_id');
		});

		Schema::table('splits', function (Blueprint $table) {
			$table->dropForeign('splits_account_id');
			$table->dropForeign('splits_created_by');
			$table->dropForeign('splits_deleted_by');
			$table->dropForeign('splits_transaction_id');
			$table->dropForeign('splits_updated_by');
			$table->dropForeign('splits_persona_id');
		});
			
		Schema::table('socials', function (Blueprint $table) {
			$table->dropForeign('socials_created_by');
			$table->dropForeign('socials_deleted_by');
			$table->dropForeign('socials_updated_by');
		});

		Schema::table('reconciliations', function (Blueprint $table) {
			$table->dropForeign('reconciliations_archetype_id');
			$table->dropForeign('reconciliations_created_by');
			$table->dropForeign('reconciliations_deleted_by');
			$table->dropForeign('reconciliations_updated_by');
			$table->dropForeign('reconciliations_persona_id');
		});

		Schema::table('recommendations', function (Blueprint $table) {
			$table->dropForeign('recommendations_created_by');
			$table->dropForeign('recommendations_deleted_by');
			$table->dropForeign('recommendations_updated_by');
			$table->dropForeign('recommendations_persona_id');
		});
			
		Schema::table('reigns', function (Blueprint $table) {
			$table->dropForeign('reigns_created_by');
			$table->dropForeign('reigns_deleted_by');
			$table->dropForeign('reigns_updated_by');
		});

		Schema::table('pronouns', function (Blueprint $table) {
			$table->dropForeign('pronouns_created_by');
			$table->dropForeign('pronouns_deleted_by');
			$table->dropForeign('pronouns_updated_by');
		});
		
		Schema::table('personas', function (Blueprint $table) {
			$table->dropForeign('personas_created_by');
			$table->dropForeign('personas_deleted_by');
			$table->dropForeign('personas_updated_by');
			$table->dropForeign('personas_chapter_id');
			$table->dropForeign('personas_pronoun_id');
		});

		Schema::table('chapters', function (Blueprint $table) {
			$table->dropForeign('chapters_created_by');
			$table->dropForeign('chapters_deleted_by');
			$table->dropForeign('chapters_updated_by');
			$table->dropForeign('chapters_realm_id');
			$table->dropForeign('chapters_chaptertype_id');
			$table->dropForeign('chapters_location_id');
		});

		Schema::table('chaptertypes', function (Blueprint $table) {
			$table->dropForeign('chaptertypes_created_by');
			$table->dropForeign('chaptertypes_deleted_by');
			$table->dropForeign('chaptertypes_realm_id');
			$table->dropForeign('chaptertypes_updated_by');
		});

		Schema::table('offices', function (Blueprint $table) {
			$table->dropForeign('offices_created_by');
			$table->dropForeign('offices_deleted_by');
			$table->dropForeign('offices_updated_by');
		});

		Schema::table('officers', function (Blueprint $table) {
			$table->dropForeign('officers_created_by');
			$table->dropForeign('officers_deleted_by');
			$table->dropForeign('officers_office_id');
			$table->dropForeign('officers_updated_by');
			$table->dropForeign('officers_persona_id');
		});

		Schema::table('members', function (Blueprint $table) {
			$table->dropForeign('members_created_by');
			$table->dropForeign('members_deleted_by');
			$table->dropForeign('members_unit_id');
			$table->dropForeign('members_updated_by');
			$table->dropForeign('members_persona_id');
		});

		Schema::table('meetups', function (Blueprint $table) {
			$table->dropForeign('meetups_created_by');
			$table->dropForeign('meetups_deleted_by');
			$table->dropForeign('meetups_location_id');
			$table->dropForeign('meetups_chapter_id');
			$table->dropForeign('meetups_updated_by');
		});

		Schema::table('locations', function (Blueprint $table) {
			$table->dropForeign('locations_created_by');
			$table->dropForeign('locations_deleted_by');
			$table->dropForeign('locations_updated_by');
		});

		Schema::table('realms', function (Blueprint $table) {
			$table->dropForeign('realms_created_by');
			$table->dropForeign('realms_deleted_by');
			$table->dropForeign('realms_parent_id');
			$table->dropForeign('realms_updated_by');
		});

		Schema::table('issuances', function (Blueprint $table) {
			$table->dropForeign('issuances_created_by');
			$table->dropForeign('issuances_deleted_by');
			$table->dropForeign('issuances_signator_id');
			$table->dropForeign('issuances_revoked_by');
			$table->dropForeign('issuances_updated_by');
		});
			
		Schema::table('guests', function (Blueprint $table) {
			$table->dropForeign('guests_event_id');
			$table->dropForeign('guests_chapter_id');
			$table->dropForeign('guests_created_by');
			$table->dropForeign('guests_deleted_by');
			$table->dropForeign('guests_updated_by');
		});

		Schema::table('events', function (Blueprint $table) {
			$table->dropForeign('events_created_by');
			$table->dropForeign('events_deleted_by');
			$table->dropForeign('events_location_id');
			$table->dropForeign('events_updated_by');
		});

		Schema::table('dues', function (Blueprint $table) {
			$table->dropForeign('dues_created_by');
			$table->dropForeign('dues_deleted_by');
			$table->dropForeign('dues_transaction_id');
			$table->dropForeign('dues_updated_by');
			$table->dropForeign('dues_persona_id');
		});
			
		Schema::table('crats', function (Blueprint $table) {
			$table->dropForeign('crats_event_id');
			$table->dropForeign('crats_created_by');
			$table->dropForeign('crats_deleted_by');
			$table->dropForeign('crats_updated_by');
			$table->dropForeign('crats_persona_id');
		});

		Schema::table('awards', function (Blueprint $table) {
			$table->dropForeign('awards_created_by');
			$table->dropForeign('awards_deleted_by');
			$table->dropForeign('awards_updated_by');
		});

		Schema::table('attendances', function (Blueprint $table) {
			$table->dropForeign('attendances_archetype_id');
			$table->dropForeign('attendances_created_by');
			$table->dropForeign('attendances_deleted_by');
			$table->dropForeign('attendances_updated_by');
			$table->dropForeign('attendances_persona_id');
		});

		Schema::table('archetypes', function (Blueprint $table) {
			$table->dropForeign('archetypes_created_by');
			$table->dropForeign('archetypes_deleted_by');
			$table->dropForeign('archetypes_updated_by');
		});

		Schema::table('accounts', function (Blueprint $table) {
			$table->dropForeign('accounts_created_by');
			$table->dropForeign('accounts_deleted_by');
			$table->dropForeign('accounts_parent_id');
			$table->dropForeign('accounts_updated_by');
		});

		Schema::dropIfExists('waivers');

		Schema::dropIfExists('users');

		Schema::dropIfExists('units');

		Schema::dropIfExists('transactions');

		Schema::dropIfExists('tournaments');

		Schema::dropIfExists('titles');

		Schema::dropIfExists('suspensions');

		Schema::dropIfExists('splits');
		
		Schema::dropIfExists('socials');
		
		Schema::dropIfExists('reconciliations');

		Schema::dropIfExists('recommendations');
		
		Schema::dropIfExists('reigns');
		
		Schema::dropIfExists('pronouns');

		Schema::dropIfExists('personas');

		Schema::dropIfExists('chapters');

		Schema::dropIfExists('chaptertypes');

		Schema::dropIfExists('offices');

		Schema::dropIfExists('officers');

		Schema::dropIfExists('members');

		Schema::dropIfExists('meetups');

		Schema::dropIfExists('locations');

		Schema::dropIfExists('realms');

		Schema::dropIfExists('issuances');
		
		Schema::dropIfExists('guests');

		Schema::dropIfExists('events');
		
		Schema::dropIfExists('dues');
		
		Schema::dropIfExists('crats');

		Schema::dropIfExists('awards');

		Schema::dropIfExists('attendances');

		Schema::dropIfExists('archetypes');

		Schema::dropIfExists('accounts');
	}
};
