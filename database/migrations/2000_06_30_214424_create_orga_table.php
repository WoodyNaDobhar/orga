<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
            $table->bigIncrements('id');
            $table->unsignedBigInteger('parent_id')->nullable()->index('parent_id');
            $table->enum('accountable_type', ['Kingdom', 'Chapter', 'Unit', 'Event']);
            $table->unsignedInteger('accountable_id')->index('accountable_id');
            $table->string('name', 50);
            $table->enum('type', ['Imbalance', 'Income', 'Expense', 'Asset', 'Liability', 'Equity']);
            $table->unsignedBigInteger('created_by')->default(1)->index('created_by');
            $table->timestamp('created_at')->useCurrent();
            $table->unsignedBigInteger('updated_by')->nullable()->index('updated_by');
            $table->timestamp('updated_at')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable()->index('deleted_by');
            $table->softDeletes();
        });

        Schema::create('archetypes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 50);
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('created_by')->default(1)->index('created_by');
            $table->timestamp('created_at')->useCurrent();
            $table->unsignedBigInteger('updated_by')->nullable()->index('updated_by');
            $table->timestamp('updated_at')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable()->index('deleted_by');
            $table->softDeletes();
        });

        Schema::create('attendances', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('persona_id')->index('persona_id');
            $table->unsignedBigInteger('archetype_id')->nullable()->index('archetype_id');
            $table->enum('attendable_type', ['Meetup', 'Event']);
            $table->unsignedBigInteger('attendable_id')->index('attendable_id');
            $table->date('attended_at');
            $table->double('credits', 4, 2)->default(1);
            $table->unsignedBigInteger('created_by')->default(1)->index('created_by');
            $table->timestamp('created_at')->useCurrent();
            $table->unsignedBigInteger('updated_by')->nullable()->index('updated_by');
            $table->timestamp('updated_at')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable()->index('deleted_by');
            $table->softDeletes();
        });

        Schema::create('awards', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('awarder_type', ['Kingdom', 'Chapter', 'Unit']);
            $table->unsignedBigInteger('awarder_id')->nullable()->index('awarder_id');
            $table->string('name', 100);
            $table->boolean('is_ladder')->default(false);
            $table->unsignedBigInteger('created_by')->default(1)->index('created_by');
            $table->timestamp('created_at')->useCurrent();
            $table->unsignedBigInteger('updated_by')->nullable()->index('updated_by');
            $table->timestamp('updated_at')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable()->index('deleted_by');
            $table->softDeletes();
        });
        	
       	Schema::create('crats', function (Blueprint $table) {
       		$table->bigIncrements('id');
       		$table->unsignedBigInteger('event_id')->index('event_id');
       		$table->unsignedBigInteger('persona_id')->index('persona_id');
       		$table->string('role', 50);
       		$table->boolean('is_autocrat')->default(false);
       		$table->unsignedBigInteger('created_by')->default(1)->index('created_by');
       		$table->timestamp('created_at')->useCurrent();
       		$table->unsignedBigInteger('updated_by')->nullable()->index('updated_by');
       		$table->timestamp('updated_at')->nullable();
       		$table->unsignedBigInteger('deleted_by')->nullable()->index('deleted_by');
       		$table->softDeletes();
       	});

        Schema::create('dues', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('persona_id')->index('persona_id');
            $table->unsignedBigInteger('transaction_id')->index('transaction_id');
            $table->date('dues_on');
            $table->integer('intervals')->nullable();
            $table->unsignedBigInteger('created_by')->default(1)->index('created_by');
            $table->timestamp('created_at')->useCurrent();
            $table->unsignedBigInteger('updated_by')->nullable()->index('updated_by');
            $table->timestamp('updated_at')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable()->index('deleted_by');
            $table->softDeletes();
        });

        Schema::create('events', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('eventable_type', ['Kingdom', 'Chapter', 'Unit', 'Persona']);
            $table->unsignedBigInteger('eventable_id')->index('eventable_id');
            $table->unsignedBigInteger('location_id')->nullable()->index('at_chapter_id');
            $table->string('name');
            $table->mediumText('description')->nullable();
            $table->string('image', 255)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamp('event_start')->nullable();
            $table->timestamp('event_end')->nullable();
            $table->float('price', 6)->nullable();
            $table->unsignedBigInteger('created_by')->default(1)->index('created_by');
            $table->timestamp('created_at')->useCurrent();
            $table->unsignedBigInteger('updated_by')->nullable()->index('updated_by');
            $table->timestamp('updated_at')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable()->index('deleted_by');
            $table->softDeletes();
        });

        Schema::create('issuances', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('issuable_type', ['Award', 'Title']);
            $table->unsignedBigInteger('issuable_id')->index('issuable_id');
            $table->enum('whereable_type', ['Event','Meetup','Location'])->nullable();
            $table->unsignedBigInteger('whereable_id')->index('whereable_id')->nullable();
            $table->enum('authority_type', ['Chapter', 'Kingdom', 'Unit', 'Persona']);
            $table->unsignedBigInteger('authority_id')->index('authority_id');
            $table->enum('recipient_type', ['Persona', 'Unit']);
            $table->unsignedBigInteger('recipient_id')->index('recipient_id');
            $table->unsignedBigInteger('issuer_id')->nullable()->index('issuer_id');
            $table->string('custom_name', 64)->nullable();
            $table->unsignedInteger('rank')->nullable();
            $table->date('issued_at');
            $table->string('note', 400)->nullable();
            $table->string('image', 255)->nullable();
            $table->unsignedBigInteger('revoked_by')->nullable()->index('revoked_by');
            $table->date('revoked_at')->nullable();
            $table->unsignedBigInteger('created_by')->default(1)->index('created_by');
            $table->string('revocation', 50)->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->unsignedBigInteger('updated_by')->nullable()->index('updated_by');
            $table->timestamp('updated_at')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable()->index('deleted_by');
            $table->softDeletes();
        });

        Schema::create('kingdoms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('parent_id')->nullable()->index('parent_id');
            $table->string('name', 100);
            $table->string('abbreviation', 4);
            $table->string('color', 6)->default('FACADE');
            $table->string('heraldry')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedSmallInteger('credit_minimum')->nullable();
            $table->unsignedSmallInteger('credit_maximum')->nullable();
            $table->unsignedSmallInteger('daily_minimum')->nullable();
            $table->unsignedSmallInteger('weekly_minimum')->nullable();
            $table->enum('average_period_type', ['Week','Month'])->nullable();
            $table->unsignedSmallInteger('average_period')->nullable();
            $table->unsignedSmallInteger('dues_amount')->nullable();
            $table->enum('dues_intervals_type', ['Week','Month'])->nullable();
            $table->unsignedSmallInteger('dues_intervals')->nullable();
            $table->unsignedSmallInteger('dues_take')->nullable();
            $table->unsignedBigInteger('created_by')->default(1)->index('created_by');
            $table->timestamp('created_at')->useCurrent();
            $table->unsignedBigInteger('updated_by')->nullable()->index('updated_by');
            $table->timestamp('updated_at')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable()->index('deleted_by');
            $table->softDeletes();
        });

        Schema::create('locations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('address')->nullable();
            $table->string('city', 50)->nullable();
            $table->string('province', 35)->nullable();
            $table->string('postal_code', 10)->nullable();
            $table->string('country', 2)->nullable()->default('US');
            $table->mediumText('google_geocode')->nullable();
            $table->double('latitude')->nullable();
            $table->double('longitude')->nullable();
            $table->mediumText('location')->nullable();
            $table->mediumText('map_url')->nullable();
            $table->mediumText('description')->nullable();
            $table->mediumText('directions')->nullable();
            $table->unsignedBigInteger('created_by')->default(1)->index('created_by');
            $table->timestamp('created_at')->useCurrent();
            $table->unsignedBigInteger('updated_by')->nullable()->index('updated_by');
            $table->timestamp('updated_at')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable()->index('deleted_by');
            $table->softDeletes();
        });

        Schema::create('meetups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('chapter_id')->index('chapter_id');
            $table->unsignedBigInteger('location_id')->nullable()->index('location_id');
            $table->unsignedBigInteger('alt_location_id')->nullable()->index('alt_location_id');
            $table->enum('recurrence', ['Weekly', 'Monthly', 'Week-of-Month']);
            $table->smallInteger('week_of_month')->nullable();
            $table->enum('week_day', ['None', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday']);
            $table->smallInteger('month_day')->nullable();
            $table->time('occurs_at');
            $table->enum('purpose', ['Park Day', 'Fighter Practice', 'A&S Gathering', 'Other']);
            $table->string('description')->nullable();
            $table->unsignedBigInteger('created_by')->default(1)->index('created_by');
            $table->timestamp('created_at')->useCurrent();
            $table->unsignedBigInteger('updated_by')->nullable()->index('updated_by');
            $table->timestamp('updated_at')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable()->index('deleted_by');
            $table->softDeletes();
        });

        Schema::create('members', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('unit_id')->index('unit_id');
            $table->unsignedBigInteger('persona_id')->index('persona_id');
            $table->boolean('is_head')->default(true);
            $table->boolean('is_voting')->default(true);
            $table->date('joined_at')->nullable();
            $table->date('left_at')->nullable();
            $table->string('notes')->nullable();
            $table->unsignedBigInteger('created_by')->default(1)->index('created_by');
            $table->timestamp('created_at')->useCurrent();
            $table->unsignedBigInteger('updated_by')->nullable()->index('updated_by');
            $table->timestamp('updated_at')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable()->index('deleted_by');
            $table->softDeletes();
        });

        Schema::create('officers', function (Blueprint $table) {
        	$table->bigIncrements('id');
        	$table->enum('officerable_type', ['Reign', 'Unit']);
        	$table->unsignedBigInteger('officerable_id')->index('officerable_id');
            $table->unsignedBigInteger('office_id')->index('office_id');
            $table->unsignedBigInteger('persona_id')->index('persona_id');
            $table->string('label', 50)->nullable();
            $table->date('starts_on')->nullable();
            $table->date('ends_on')->nullable();
            $table->string('notes')->nullable();
            $table->unsignedBigInteger('created_by')->default(1)->index('created_by');
            $table->timestamp('created_at')->useCurrent();
            $table->unsignedBigInteger('updated_by')->nullable()->index('updated_by');
            $table->timestamp('updated_at')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable()->index('deleted_by');
            $table->softDeletes();
        });

        Schema::create('offices', function (Blueprint $table) {
        	$table->bigIncrements('id');
        	$table->enum('officeable_type', ['Kingdom', 'Chaptertype', 'Unit']);
        	$table->unsignedBigInteger('officeable_id')->nullable()->index('officeable_id');
        	$table->string('name', 100);
        	$table->integer('duration')->nullable()->default(6);
        	$table->integer('order')->nullable();
            $table->unsignedBigInteger('created_by')->default(1)->index('created_by');
            $table->timestamp('created_at')->useCurrent();
            $table->unsignedBigInteger('updated_by')->nullable()->index('updated_by');
            $table->timestamp('updated_at')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable()->index('deleted_by');
            $table->softDeletes();
        });

        Schema::create('chaptertypes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('kingdom_id')->index('kingdom_id');
            $table->string('name', 50);
            $table->integer('rank')->nullable();
            $table->integer('minimumattendance')->default(5);
            $table->integer('minimumcutoff')->default(1);
            $table->unsignedBigInteger('created_by')->default(1)->index('created_by');
            $table->timestamp('created_at')->useCurrent();
            $table->unsignedBigInteger('updated_by')->nullable()->index('updated_by');
            $table->timestamp('updated_at')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable()->index('deleted_by');
            $table->softDeletes();
        });

        Schema::create('chapters', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('kingdom_id')->index('kingdom_id');
            $table->unsignedBigInteger('chaptertype_id')->default(1)->index('chaptertype_id');
            $table->unsignedBigInteger('location_id')->index('location_id');
            $table->string('name', 100);
            $table->string('abbreviation', 3);
            $table->string('heraldry')->nullable();
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('created_by')->default(1)->index('created_by');
            $table->timestamp('created_at')->useCurrent();
            $table->unsignedBigInteger('updated_by')->nullable()->index('updated_by');
            $table->timestamp('updated_at')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable()->index('deleted_by');
            $table->softDeletes();
        });

        Schema::create('personas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('chapter_id')->index('chapter_id');
            $table->unsignedBigInteger('user_id')->nullable()->index('user_id');
            $table->unsignedBigInteger('pronoun_id')->nullable()->index('pronoun_id');
            $table->string('mundane')->nullable();
            $table->string('name');
            $table->string('heraldry')->nullable();
            $table->string('image')->nullable();
            $table->boolean('is_active')->default(true);
            $table->date('reeve_qualified_expires_at')->nullable();
            $table->date('corpora_qualified_expires_at')->nullable();
            $table->date('joined_chapter_at')->nullable();
            $table->unsignedBigInteger('created_by')->default(1)->index('created_by');
            $table->timestamp('created_at')->useCurrent();
            $table->unsignedBigInteger('updated_by')->nullable()->index('updated_by');
            $table->timestamp('updated_at')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable()->index('deleted_by');
            $table->softDeletes();
        });

        Schema::create('pronouns', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('subject', 30);
            $table->string('object', 30);
            $table->string('possessive', 30);
            $table->string('possessivepronoun', 30);
            $table->string('reflexive', 30);
            $table->unsignedBigInteger('created_by')->default(1)->index('created_by');
            $table->timestamp('created_at')->useCurrent();
            $table->unsignedBigInteger('updated_by')->nullable()->index('updated_by');
            $table->timestamp('updated_at')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable()->index('deleted_by');
            $table->softDeletes();
        });

        Schema::create('recommendations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('persona_id')->index('mundane_id');
            $table->enum('recommendable_type', ['Award', 'Title']);
            $table->unsignedBigInteger('recommendable_id')->nullable()->index('recommendable_id');
            $table->integer('rank')->nullable();
            $table->boolean('is_anonymous')->default(false);
            $table->string('reason', 400);
            $table->unsignedBigInteger('created_by')->default(1)->index('created_by');
            $table->timestamp('created_at')->useCurrent();
            $table->unsignedBigInteger('updated_by')->nullable()->index('updated_by');
            $table->timestamp('updated_at')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable()->index('deleted_by');
            $table->softDeletes();
        });
        	
       	Schema::create('reigns', function (Blueprint $table) {
       		$table->bigIncrements('id');
       		$table->enum('reignable_type', ['Kingdom', 'Chapter']);
       		$table->unsignedBigInteger('reignable_id')->nullable()->index('reignable_id');
       		$table->string('name', 100)->nullable();
       		$table->date('starts_on');
       		$table->date('ends_on');
       		$table->unsignedBigInteger('created_by')->default(1)->index('created_by');
       		$table->timestamp('created_at')->useCurrent();
       		$table->unsignedBigInteger('updated_by')->nullable()->index('updated_by');
       		$table->timestamp('updated_at')->nullable();
       		$table->unsignedBigInteger('deleted_by')->nullable()->index('deleted_by');
       		$table->softDeletes();
       	});

        Schema::create('reconciliations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('archetype_id')->index('archetype_id');
            $table->unsignedBigInteger('persona_id')->index('persona_id');
            $table->double('credits', 6, 2)->default(1);
            $table->string('notes')->nullable();
            $table->unsignedBigInteger('created_by')->default(1)->index('created_by');
            $table->timestamp('created_at')->useCurrent();
            $table->unsignedBigInteger('updated_by')->nullable()->index('updated_by');
            $table->timestamp('updated_at')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable()->index('deleted_by');
            $table->softDeletes();
        });
        	
       	Schema::create('socials', function (Blueprint $table) {
       		$table->bigIncrements('id');
       		$table->enum('sociable_type', ['Kingdom', 'Chapter', 'Event', 'Unit', 'Persona']);
       		$table->unsignedBigInteger('sociable_id')->nullable()->index('sociable_id');
       		$table->enum('media', ['Web', 'Facebook', 'Discord', 'Instagram', 'YouTube', 'TicToc']);
       		$table->string('value', 255);
       		$table->unsignedBigInteger('created_by')->default(1)->index('created_by');
       		$table->timestamp('created_at')->useCurrent();
       		$table->unsignedBigInteger('updated_by')->nullable()->index('updated_by');
       		$table->timestamp('updated_at')->nullable();
       		$table->unsignedBigInteger('deleted_by')->nullable()->index('deleted_by');
       		$table->softDeletes();
       	});

        Schema::create('splits', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('account_id')->index('account_id')->nullable();
            $table->unsignedBigInteger('transaction_id')->index('transaction_id');
            $table->unsignedBigInteger('persona_id')->index('persona_id');
            $table->double('amount', 10, 4);
            $table->unsignedBigInteger('created_by')->default(1)->index('created_by');
            $table->timestamp('created_at')->useCurrent();
            $table->unsignedBigInteger('updated_by')->nullable()->index('updated_by');
            $table->timestamp('updated_at')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable()->index('deleted_by');
            $table->softDeletes();
        });

        Schema::create('suspensions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('persona_id')->index('persona_id');
            $table->unsignedBigInteger('kingdom_id')->index('kingdom_id');
            $table->unsignedBigInteger('suspended_by')->index('suspended_by');
            $table->date('suspended_at')->nullable();
            $table->date('expires_at')->nullable();
            $table->string('cause');
            $table->boolean('is_propogating')->default(false);
            $table->unsignedBigInteger('created_by')->default(1)->index('created_by');
            $table->timestamp('created_at')->useCurrent();
            $table->unsignedBigInteger('updated_by')->nullable()->index('updated_by');
            $table->timestamp('updated_at')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable()->index('deleted_by');
            $table->softDeletes();
        });

        Schema::create('titles', function (Blueprint $table) {
        	$table->bigIncrements('id');
        	$table->enum('titleable_type', ['Kingdom', 'Chapter', 'Unit']);
        	$table->unsignedBigInteger('titleable_id')->nullable()->index('titleable_id');
            $table->string('name', 100);
            $table->unsignedSmallInteger('rank')->nullable();
            $table->enum('peerage', ['Gentry', 'Knight', 'Master', 'Nobility', 'None', 'Retainer', 'Paragon', 'Squire'])->default('None');
            $table->boolean('is_roaming')->default(0);
            $table->boolean('is_active')->default(1);
            $table->unsignedBigInteger('created_by')->default(1)->index('created_by');
            $table->timestamp('created_at')->useCurrent();
            $table->unsignedBigInteger('updated_by')->nullable()->index('updated_by');
            $table->timestamp('updated_at')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable()->index('deleted_by');
            $table->softDeletes();
        });

        Schema::create('tournaments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('tournamentable_type', ['Kingdom', 'Chapter', 'Event']);
            $table->unsignedBigInteger('tournamentable_id')->index('tournamentable_id');
            $table->string('name', 50);
            $table->mediumText('description');
            $table->dateTime('occured_at');
            $table->unsignedBigInteger('created_by')->default(1)->index('created_by');
            $table->timestamp('created_at')->useCurrent();
            $table->unsignedBigInteger('updated_by')->nullable()->index('updated_by');
            $table->timestamp('updated_at')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable()->index('deleted_by');
            $table->softDeletes();
        });

        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('description');
            $table->mediumText('memo');
            $table->date('transaction_at');
            $table->unsignedBigInteger('created_by')->default(1)->index('created_by');
            $table->timestamp('created_at')->useCurrent();
            $table->unsignedBigInteger('updated_by')->nullable()->index('updated_by');
            $table->timestamp('updated_at')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable()->index('deleted_by');
            $table->softDeletes();
        });

        Schema::create('units', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('type', ['Company', 'Household', 'Event'])->default('Household');
            $table->string('name', 100);
            $table->string('heraldry')->nullable();
            $table->mediumText('description')->nullable();
            $table->mediumText('history')->nullable();
            $table->unsignedBigInteger('created_by')->default(1)->index('created_by');
            $table->timestamp('created_at')->useCurrent();
            $table->unsignedBigInteger('updated_by')->nullable()->index('updated_by');
            $table->timestamp('updated_at')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable()->index('deleted_by');
            $table->softDeletes();
        });

        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->boolean('is_restricted')->default(false);
            $table->unsignedBigInteger('created_by')->default(1)->index('created_by');
            $table->timestamp('created_at')->useCurrent();
            $table->unsignedBigInteger('updated_by')->nullable()->index('updated_by');
            $table->timestamp('updated_at')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable()->index('deleted_by');
            $table->softDeletes();
        });

        Schema::create('waivers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('pronoun_id')->nullable()->index('pronoun_id');
            $table->unsignedBigInteger('persona_id')->nullable()->index('persona_id');
            $table->enum('waiverable_type', ['Kingdom', 'Event']);
            $table->unsignedBigInteger('waiverable_id')->index('waiverable_id');
            $table->string('file')->nullable();
            $table->string('player', 150);
            $table->string('email', 255)->nullable();
            $table->string('phone', 25)->nullable();
            $table->unsignedBigInteger('location_id')->nullable()->index('location_id');
            $table->date('dob')->nullable();
            $table->date('age_verified_at')->nullable();
            $table->unsignedBigInteger('age_verified_by')->nullable()->index('age_verified_by');
            $table->string('guardian', 150)->nullable();
            $table->string('emergency_name', 150)->nullable();
            $table->string('emergency_relationship', 150)->nullable();
            $table->string('emergency_phone', 25)->nullable();
            $table->date('signed_at');
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
       		$table->foreign(['event_id'], 'crats_persona_id')->references(['id'])->on('events')->onUpdate('NO ACTION')->onDelete('NO ACTION');
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

        Schema::table('issuances', function (Blueprint $table) {
            $table->foreign(['created_by'], 'issuances_created_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['deleted_by'], 'issuances_deleted_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['issuer_id'], 'issuances_issuer_id')->references(['id'])->on('personas')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['revoked_by'], 'issuances_revoked_by')->references(['id'])->on('personas')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['updated_by'], 'issuances_updated_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });

        Schema::table('kingdoms', function (Blueprint $table) {
            $table->foreign(['created_by'], 'kingdoms_created_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['deleted_by'], 'kingdoms_deleted_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['parent_id'], 'kingdoms_parent_id')->references(['id'])->on('kingdoms')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['updated_by'], 'kingdoms_updated_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });

        Schema::table('locations', function (Blueprint $table) {
            $table->foreign(['created_by'], 'locations_created_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['deleted_by'], 'locations_deleted_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['updated_by'], 'locations_updated_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });

        Schema::table('meetups', function (Blueprint $table) {
            $table->foreign(['alt_location_id'], 'meetups_alt_location_id')->references(['id'])->on('locations')->onUpdate('NO ACTION')->onDelete('NO ACTION');
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
            $table->foreign(['kingdom_id'], 'chaptertypes_kingdom_id')->references(['id'])->on('kingdoms')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['updated_by'], 'chaptertypes_updated_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });

        Schema::table('chapters', function (Blueprint $table) {
            $table->foreign(['created_by'], 'chapters_created_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['deleted_by'], 'chapters_deleted_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['updated_by'], 'chapters_updated_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['kingdom_id'], 'chapters_kingdom_id')->references(['id'])->on('kingdoms')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['chaptertype_id'], 'chapters_chaptertype_id')->references(['id'])->on('chaptertypes')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['location_id'], 'chapters_location_id')->references(['id'])->on('locations')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });

        Schema::table('personas', function (Blueprint $table) {
            $table->foreign(['chapter_id'], 'personas_chapter_id')->references(['id'])->on('chapters')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['user_id'], 'personas_user_id')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['pronoun_id'], 'personas_pronoun_id')->references(['id'])->on('pronouns')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['created_by'], 'users_created_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['deleted_by'], 'users_deleted_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['updated_by'], 'users_updated_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
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
            $table->foreign(['kingdom_id'], 'suspensions_kingdom_id')->references(['id'])->on('kingdoms')->onUpdate('NO ACTION')->onDelete('NO ACTION');
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
            $table->foreign(['created_by'], 'users_created_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['deleted_by'], 'users_deleted_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['updated_by'], 'users_updated_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });

        Schema::table('waivers', function (Blueprint $table) {
            $table->foreign(['age_verified_by'], 'waivers_age_verified_by')->references(['id'])->on('personas')->onUpdate('NO ACTION')->onDelete('NO ACTION');
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
            $table->dropForeign('pronoun_id');
            $table->dropForeign('created_by');
            $table->dropForeign('deleted_by');
            $table->dropForeign('updated_by');
        });
        
        Schema::table('users', function (Blueprint $table) {
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
            $table->dropForeign('suspensions_kingdom_id');
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
            $table->dropForeign('personas_persona_id');
            $table->dropForeign('personas_chapter_id');
            $table->dropForeign('personas_pronoun_id');
        });

        Schema::table('chapters', function (Blueprint $table) {
            $table->dropForeign('chapters_created_by');
            $table->dropForeign('chapters_deleted_by');
            $table->dropForeign('chapters_updated_by');
            $table->dropForeign('chapters_kingdom_id');
            $table->dropForeign('chapters_chaptertype_id');
            $table->dropForeign('chapters_location_id');
        });

        Schema::table('chaptertypes', function (Blueprint $table) {
            $table->dropForeign('chaptertypes_created_by');
            $table->dropForeign('chaptertypes_deleted_by');
            $table->dropForeign('chaptertypes_kingdom_id');
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
            $table->dropForeign('meetups_alt_location_id');
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

        Schema::table('kingdoms', function (Blueprint $table) {
            $table->dropForeign('kingdoms_created_by');
            $table->dropForeign('kingdoms_deleted_by');
            $table->dropForeign('kingdoms_parent_id');
            $table->dropForeign('kingdoms_updated_by');
        });

        Schema::table('issuances', function (Blueprint $table) {
            $table->dropForeign('issuances_created_by');
            $table->dropForeign('issuances_deleted_by');
            $table->dropForeign('issuances_issuer_id');
            $table->dropForeign('issuances_revoked_by');
            $table->dropForeign('issuances_updated_by');
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

        Schema::dropIfExists('kingdoms');

        Schema::dropIfExists('issuances');

        Schema::dropIfExists('events');
        
        Schema::dropIfExists('dues');
        
        Schema::dropIfExists('crats');

        Schema::dropIfExists('awards');

        Schema::dropIfExists('attendances');

        Schema::dropIfExists('archetypes');

        Schema::dropIfExists('accounts');
    }
};
