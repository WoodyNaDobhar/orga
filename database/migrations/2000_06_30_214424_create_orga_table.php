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
            $table->enum('accountable_type', ['Kingdom', 'Park', 'Unit', 'Event']);
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
            $table->unsignedBigInteger('user_id')->index('user_id');
            $table->unsignedBigInteger('archetype_id')->nullable()->index('archetype_id');
            $table->enum('attendable_type', ['Park', 'Kingdom', 'Event']);
            $table->unsignedBigInteger('attendable_id')->index('attendable_id');
            $table->date('attended_at');
            $table->double('credits', 4, 2);
            $table->unsignedBigInteger('created_by')->default(1)->index('created_by');
            $table->timestamp('created_at')->useCurrent();
            $table->unsignedBigInteger('updated_by')->nullable()->index('updated_by');
            $table->timestamp('updated_at')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable()->index('deleted_by');
            $table->softDeletes();
        });

        Schema::create('awards', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('awardable_type', ['Kingdom', 'Park', 'Unit']);
            $table->unsignedBigInteger('awardable_id')->nullable()->index('awardable_id');
            $table->string('name', 100);
            $table->boolean('is_ladder')->default(false);
            $table->unsignedBigInteger('created_by')->default(1)->index('created_by');
            $table->timestamp('created_at')->useCurrent();
            $table->unsignedBigInteger('updated_by')->nullable()->index('updated_by');
            $table->timestamp('updated_at')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable()->index('deleted_by');
            $table->softDeletes();
        });

        Schema::create('configurations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('configurable_type', ['Service', 'Application', 'Kingdom', 'Park', 'Event', 'Tournament', 'Unit'])->default('Service');
            $table->unsignedBigInteger('configurable_id')->default(0)->index('configurable_id');
            $table->string('key', 50);
            $table->mediumText('value');
            $table->boolean('is_user_setting')->default(true);
            $table->mediumText('allowed_values');
            $table->timestamp('modified')->useCurrentOnUpdate()->useCurrent();
            $table->enum('var_type', ['string', 'fixed', 'mixed', 'number', 'date', 'color']);
            $table->unsignedBigInteger('created_by')->default(1)->index('created_by');
            $table->timestamp('created_at')->useCurrent();
            $table->unsignedBigInteger('updated_by')->nullable()->index('updated_by');
            $table->timestamp('updated_at')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable()->index('deleted_by');
            $table->softDeletes();
        });

        Schema::create('dues', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->index('user_id');
            $table->unsignedBigInteger('park_id')->index('park_id');
            $table->unsignedBigInteger('transaction_id')->nullable()->index('transaction_id');
            $table->boolean('is_for_life')->default(false);
            $table->date('dues_at');
            $table->integer('intervals')->default(1);
            $table->date('revoked_on')->nullable();
            $table->unsignedBigInteger('revoked_by')->nullable()->index('revoked_by');
            $table->unsignedBigInteger('created_by')->default(1)->index('created_by');
            $table->timestamp('created_at')->useCurrent();
            $table->unsignedBigInteger('updated_by')->nullable()->index('updated_by');
            $table->timestamp('updated_at')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable()->index('deleted_by');
            $table->softDeletes();
        });

        Schema::create('events', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('eventable_type', ['Kingdom', 'Park', 'Unit', 'User']);
            $table->unsignedBigInteger('eventable_id')->index('eventable_id');
            $table->unsignedBigInteger('autocrat_id')->default(0)->index('autocrat_id');
            $table->unsignedBigInteger('location_id')->index('at_park_id');
            $table->string('name');
            $table->mediumText('description');
            $table->timestamp('event_start');
            $table->timestamp('event_end');
            $table->float('price', 6)->nullable();
            $table->string('url')->nullable();
            $table->string('url_name', 40)->nullable();
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
            $table->unsignedBigInteger('user_id')->index('user_id');
            $table->unsignedBigInteger('issuer_id')->index('issuer_id');
            $table->enum('issuedable_type', ['Park', 'Kingdom', 'Event']);
            $table->unsignedBigInteger('issuedable_id')->index('issuedable_id');
            $table->string('custom_name', 64)->nullable();
            $table->unsignedInteger('rank')->nullable();
            $table->date('issued_at');
            $table->string('note', 400)->nullable();
            $table->string('image', 255)->nullable();
            $table->string('revocation', 50)->nullable();
            $table->unsignedBigInteger('revoked_by')->nullable()->index('revoked_by');
            $table->date('revoked_at')->nullable();
            $table->unsignedBigInteger('created_by')->default(1)->index('created_by');
            $table->timestamp('created_at')->useCurrent();
            $table->unsignedBigInteger('updated_by')->nullable()->index('updated_by');
            $table->timestamp('updated_at')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable()->index('deleted_by');
            $table->softDeletes();
        });

        Schema::create('kingdom_office', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('kingdom_id')->index('kingdom_office_kingdom_id');
            $table->unsignedBigInteger('office_id')->index('kingdom_office_office_id');
            $table->string('custom_name', 100)->nullable();
            $table->unsignedBigInteger('created_by')->default(1)->index('created_by');
            $table->timestamp('created_at')->useCurrent();
            $table->unsignedBigInteger('updated_by')->nullable()->index('updated_by');
            $table->timestamp('updated_at')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable()->index('deleted_by');
            $table->softDeletes();
        });

        Schema::create('kingdom_title', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('kingdom_id')->index('kingdom_id');
            $table->unsignedBigInteger('title_id')->index('title_id');
            $table->string('custom_name', 100)->nullable();
            $table->unsignedBigInteger('created_by')->default(1)->index('created_by');
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

        Schema::create('locations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('address')->nullable();
            $table->string('city', 50)->nullable();
            $table->string('province', 35)->nullable();
            $table->string('postal_code', 10)->nullable();
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
            $table->unsignedBigInteger('park_id')->index('park_id');
            $table->unsignedBigInteger('location_id')->index('location_id');
            $table->unsignedBigInteger('alt_location_id')->nullable()->index('alt_location_id');
            $table->enum('recurrence', ['Weekly', 'Monthly', 'Week-of-Month']);
            $table->smallInteger('week_of_month')->nullable();
            $table->enum('week_day', ['None', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday']);
            $table->smallInteger('month_day')->nullable();
            $table->time('occurs_at');
            $table->enum('purpose', ['Park Day', 'Fighter Practice', 'A&S Gathering', 'Other']);
            $table->string('description');
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
            $table->unsignedBigInteger('user_id')->index('user_id');
            $table->enum('role', ['Captain', 'Lord', 'Member']);
            $table->string('title', 100);
            $table->boolean('is_active')->default(true);
            $table->unsignedBigInteger('created_by')->default(1)->index('created_by');
            $table->timestamp('created_at')->useCurrent();
            $table->unsignedBigInteger('updated_by')->nullable()->index('updated_by');
            $table->timestamp('updated_at')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable()->index('deleted_by');
            $table->softDeletes();
        });

        Schema::create('officers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('office_id')->default(0)->index('office_id');
            $table->unsignedBigInteger('user_id')->default(0)->index('user_id');
            $table->unsignedBigInteger('authorized_by')->default(0)->index('authorized_by');
            $table->enum('officerable_type', ['Kingdom', 'Park']);
            $table->unsignedBigInteger('officerable_id')->default(0)->index('officerable_id');
            $table->enum('scope', ['Kingdom', 'Park', 'Principality', 'BoD', 'Other', 'None'])->default('None');
            $table->unsignedBigInteger('created_by')->default(1)->index('created_by');
            $table->timestamp('created_at')->useCurrent();
            $table->unsignedBigInteger('updated_by')->nullable()->index('updated_by');
            $table->timestamp('updated_at')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable()->index('deleted_by');
            $table->softDeletes();
        });

        Schema::create('offices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 100);
            $table->integer('crown_points')->default(0);
            $table->integer('crown_limit')->default(0);
            $table->unsignedBigInteger('created_by')->default(1)->index('created_by');
            $table->timestamp('created_at')->useCurrent();
            $table->unsignedBigInteger('updated_by')->nullable()->index('updated_by');
            $table->timestamp('updated_at')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable()->index('deleted_by');
            $table->softDeletes();
        });

        Schema::create('parkranks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('kingdom_id')->index('kingdom_id');
            $table->string('name', 50);
            $table->integer('rank')->default(0);
            $table->integer('minimumattendance')->default(5);
            $table->integer('minimumcutoff')->default(1);
            $table->enum('period', ['Month', 'Week'])->default('Month');
            $table->integer('period_length')->default(6);
            $table->unsignedBigInteger('created_by')->default(1)->index('created_by');
            $table->timestamp('created_at')->useCurrent();
            $table->unsignedBigInteger('updated_by')->nullable()->index('updated_by');
            $table->timestamp('updated_at')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable()->index('deleted_by');
            $table->softDeletes();
        });

        Schema::create('parks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('kingdom_id')->index('kingdom_id');
            $table->unsignedBigInteger('parkrank_id')->default(1)->index('parkrank_id');
            $table->unsignedBigInteger('location_id')->index('location_id');
            $table->string('name', 100);
            $table->string('abbreviation', 3);
            $table->string('heraldry')->default('0');
            $table->string('url');
            $table->boolean('is_active')->default(true);
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
            $table->unsignedBigInteger('user_id')->index('mundane_id');
            $table->unsignedBigInteger('award_id')->index('award_id');
            $table->integer('rank');
            $table->boolean('is_anonymous')->default(false);
            $table->string('reason', 400);
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
            $table->unsignedBigInteger('user_id')->index('user_id');
            $table->boolean('is_reconciled')->default(false);
            $table->unsignedBigInteger('created_by')->default(1)->index('created_by');
            $table->timestamp('created_at')->useCurrent();
            $table->unsignedBigInteger('updated_by')->nullable()->index('updated_by');
            $table->timestamp('updated_at')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable()->index('deleted_by');
            $table->softDeletes();
        });

        Schema::create('splits', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('account_id')->index('account_id');
            $table->unsignedBigInteger('transaction_id')->index('transaction_id');
            $table->unsignedBigInteger('user_id')->index('user_id');
            $table->double('amount', 10, 4);
            $table->unsignedBigInteger('created_by')->default(1)->index('created_by');
            $table->timestamp('created_at')->useCurrent();
            $table->unsignedBigInteger('updated_by')->nullable()->index('updated_by');
            $table->timestamp('updated_at')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable()->index('deleted_by');
            $table->softDeletes();
        });

        Schema::create('suspensions', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->unsignedBigInteger('user_id')->index('user_id');
            $table->unsignedBigInteger('suspended_by')->index('suspended_by');
            $table->date('suspended_at')->nullable();
            $table->date('suspended_expires');
            $table->string('cause');
            $table->unsignedBigInteger('created_by')->default(1)->index('created_by');
            $table->timestamp('created_at')->useCurrent();
            $table->unsignedBigInteger('updated_by')->nullable()->index('updated_by');
            $table->timestamp('updated_at')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable()->index('deleted_by');
            $table->softDeletes();
        });

        Schema::create('titles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 50);
            $table->unsignedSmallInteger('rank')->default(0);
            $table->enum('peerage', ['Knight', 'Squire', 'Person-At-Arms', 'Page', 'Lords Page', 'None', 'Master', 'Paragon', 'Apprentice', 'Kingdom Level Award'])->default('None');
            $table->unsignedBigInteger('created_by')->default(1)->index('created_by');
            $table->timestamp('created_at')->useCurrent();
            $table->unsignedBigInteger('updated_by')->nullable()->index('updated_by');
            $table->timestamp('updated_at')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable()->index('deleted_by');
            $table->softDeletes();
        });

        Schema::create('tournaments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('tournamentable_type', ['Kingdom', 'Park', 'Event']);
            $table->unsignedBigInteger('tournamentable_id')->index('tournamentable_id');
            $table->unsignedBigInteger('event_id')->index('event_id');
            $table->string('name', 50);
            $table->mediumText('description');
            $table->string('url');
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
            $table->string('url')->nullable();
            $table->unsignedBigInteger('created_by')->default(1)->index('created_by');
            $table->timestamp('created_at')->useCurrent();
            $table->unsignedBigInteger('updated_by')->nullable()->index('updated_by');
            $table->timestamp('updated_at')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable()->index('deleted_by');
            $table->softDeletes();
        });

        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('park_id')->index('park_id');
            $table->unsignedBigInteger('pronoun_id')->nullable()->index('pronoun_id');
            $table->string('name');
            $table->string('persona');
            $table->string('heraldry')->nullable();
            $table->string('image')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->boolean('restricted')->default(false);
            $table->boolean('waivered')->default(false);
            $table->string('waiver_ext', 8);
            $table->tinyInteger('penalty_box')->default(0);
            $table->boolean('is_active')->default(true);
            $table->date('reeve_qualified_expires')->nullable();
            $table->date('corpora_qualified_expires')->nullable();
            $table->date('joined_park_at')->nullable();
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
            $table->foreign(['user_id'], 'attendances_user_id')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });

        Schema::table('awards', function (Blueprint $table) {
            $table->foreign(['created_by'], 'awards_created_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['deleted_by'], 'awards_deleted_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['updated_by'], 'awards_updated_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });

        Schema::table('configurations', function (Blueprint $table) {
            $table->foreign(['created_by'], 'configurations_created_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['deleted_by'], 'configurations_deleted_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['updated_by'], 'configurations_updated_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });

        Schema::table('dues', function (Blueprint $table) {
            $table->foreign(['created_by'], 'dues_created_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['deleted_by'], 'dues_deleted_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['park_id'], 'dues_park_id')->references(['id'])->on('parks')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['revoked_by'], 'dues_revoked_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['transaction_id'], 'dues_transaction_id')->references(['id'])->on('transactions')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['updated_by'], 'dues_updated_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['user_id'], 'dues_user_id')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });

        Schema::table('events', function (Blueprint $table) {
            $table->foreign(['autocrat_id'], 'events_autocrat_id')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['created_by'], 'events_created_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['deleted_by'], 'events_deleted_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['location_id'], 'events_location_id')->references(['id'])->on('locations')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['updated_by'], 'events_updated_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });

        Schema::table('issuances', function (Blueprint $table) {
            $table->foreign(['created_by'], 'issuances_created_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['deleted_by'], 'issuances_deleted_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['issuer_id'], 'issuances_issuer_id')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['revoked_by'], 'issuances_revoked_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['updated_by'], 'issuances_updated_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['user_id'], 'issuances_user_id')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });

        Schema::table('kingdom_office', function (Blueprint $table) {
            $table->foreign(['created_by'], 'kingdom_office_created_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['deleted_by'], 'kingdom_office_deleted_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['kingdom_id'], 'kingdom_office_kingdom_id')->references(['id'])->on('kingdoms')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['office_id'], 'kingdom_office_office_id')->references(['id'])->on('offices')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['updated_by'], 'kingdom_office_updated_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });

        Schema::table('kingdom_title', function (Blueprint $table) {
            $table->foreign(['created_by'], 'kingdom_title_created_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['deleted_by'], 'kingdom_title_deleted_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['kingdom_id'], 'kingdom_title_kingdom_id')->references(['id'])->on('kingdoms')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['title_id'], 'kingdom_title_title_id')->references(['id'])->on('kingdoms')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['updated_by'], 'kingdom_title_updated_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
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
            $table->foreign(['park_id'], 'meetups_park_id')->references(['id'])->on('parks')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['updated_by'], 'meetups_updated_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });

        Schema::table('members', function (Blueprint $table) {
            $table->foreign(['created_by'], 'members_created_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['deleted_by'], 'members_deleted_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['unit_id'], 'members_unit_id')->references(['id'])->on('units')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['updated_by'], 'members_updated_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['user_id'], 'members_user_id')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });

        Schema::table('officers', function (Blueprint $table) {
            $table->foreign(['authorized_by'], 'officers_authorized_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['created_by'], 'officers_created_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['deleted_by'], 'officers_deleted_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['office_id'], 'officers_office_id')->references(['id'])->on('offices')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['updated_by'], 'officers_updated_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['user_id'], 'officers_user_id')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });

        Schema::table('offices', function (Blueprint $table) {
            $table->foreign(['created_by'], 'offices_created_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['deleted_by'], 'offices_deleted_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['updated_by'], 'offices_updated_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });

        Schema::table('parkranks', function (Blueprint $table) {
            $table->foreign(['created_by'], 'parkranks_created_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['deleted_by'], 'parkranks_deleted_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['kingdom_id'], 'parkranks_kingdom_id')->references(['id'])->on('kingdoms')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['updated_by'], 'parkranks_updated_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });

        Schema::table('parks', function (Blueprint $table) {
            $table->foreign(['created_by'], 'parks_created_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['deleted_by'], 'parks_deleted_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['updated_by'], 'parks_updated_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });

        Schema::table('pronouns', function (Blueprint $table) {
            $table->foreign(['created_by'], 'pronouns_created_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['deleted_by'], 'pronouns_deleted_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['updated_by'], 'pronouns_updated_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });

        Schema::table('recommendations', function (Blueprint $table) {
            $table->foreign(['award_id'], 'recommendations_award_id')->references(['id'])->on('awards')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['created_by'], 'recommendations_created_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['deleted_by'], 'recommendations_deleted_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['updated_by'], 'recommendations_updated_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['user_id'], 'recommendations_user_id')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });

        Schema::table('reconciliations', function (Blueprint $table) {
            $table->foreign(['archetype_id'], 'reconciliations_archetype_id')->references(['id'])->on('archetypes')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['created_by'], 'reconciliations_created_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['deleted_by'], 'reconciliations_deleted_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['updated_by'], 'reconciliations_updated_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['user_id'], 'reconciliations_user_id')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });

        Schema::table('splits', function (Blueprint $table) {
            $table->foreign(['account_id'], 'splits_account_id')->references(['id'])->on('accounts')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['created_by'], 'splits_created_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['deleted_by'], 'splits_deleted_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['transaction_id'], 'splits_transaction_id')->references(['id'])->on('transactions')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['updated_by'], 'splits_updated_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['user_id'], 'splits_user_id')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });

        Schema::table('suspensions', function (Blueprint $table) {
            $table->foreign(['created_by'], 'suspensions_created_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['deleted_by'], 'suspensions_deleted_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['suspended_by'], 'suspensions_suspended_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['updated_by'], 'suspensions_updated_by')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
            $table->foreign(['user_id'], 'suspensions_user_id')->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
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
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
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
            $table->dropForeign('suspensions_user_id');
        });

        Schema::table('splits', function (Blueprint $table) {
            $table->dropForeign('splits_account_id');
            $table->dropForeign('splits_created_by');
            $table->dropForeign('splits_deleted_by');
            $table->dropForeign('splits_transaction_id');
            $table->dropForeign('splits_updated_by');
            $table->dropForeign('splits_user_id');
        });

        Schema::table('reconciliations', function (Blueprint $table) {
            $table->dropForeign('reconciliations_archetype_id');
            $table->dropForeign('reconciliations_created_by');
            $table->dropForeign('reconciliations_deleted_by');
            $table->dropForeign('reconciliations_updated_by');
            $table->dropForeign('reconciliations_user_id');
        });

        Schema::table('recommendations', function (Blueprint $table) {
            $table->dropForeign('recommendations_award_id');
            $table->dropForeign('recommendations_created_by');
            $table->dropForeign('recommendations_deleted_by');
            $table->dropForeign('recommendations_updated_by');
            $table->dropForeign('recommendations_user_id');
        });

        Schema::table('pronouns', function (Blueprint $table) {
            $table->dropForeign('pronouns_created_by');
            $table->dropForeign('pronouns_deleted_by');
            $table->dropForeign('pronouns_updated_by');
        });

        Schema::table('parks', function (Blueprint $table) {
            $table->dropForeign('parks_created_by');
            $table->dropForeign('parks_deleted_by');
            $table->dropForeign('parks_updated_by');
        });

        Schema::table('parkranks', function (Blueprint $table) {
            $table->dropForeign('parkranks_created_by');
            $table->dropForeign('parkranks_deleted_by');
            $table->dropForeign('parkranks_kingdom_id');
            $table->dropForeign('parkranks_updated_by');
        });

        Schema::table('offices', function (Blueprint $table) {
            $table->dropForeign('offices_created_by');
            $table->dropForeign('offices_deleted_by');
            $table->dropForeign('offices_updated_by');
        });

        Schema::table('officers', function (Blueprint $table) {
            $table->dropForeign('officers_authorized_by');
            $table->dropForeign('officers_created_by');
            $table->dropForeign('officers_deleted_by');
            $table->dropForeign('officers_office_id');
            $table->dropForeign('officers_updated_by');
            $table->dropForeign('officers_user_id');
        });

        Schema::table('members', function (Blueprint $table) {
            $table->dropForeign('members_created_by');
            $table->dropForeign('members_deleted_by');
            $table->dropForeign('members_unit_id');
            $table->dropForeign('members_updated_by');
            $table->dropForeign('members_user_id');
        });

        Schema::table('meetups', function (Blueprint $table) {
            $table->dropForeign('meetups_alt_location_id');
            $table->dropForeign('meetups_created_by');
            $table->dropForeign('meetups_deleted_by');
            $table->dropForeign('meetups_location_id');
            $table->dropForeign('meetups_park_id');
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

        Schema::table('kingdom_title', function (Blueprint $table) {
            $table->dropForeign('kingdom_title_created_by');
            $table->dropForeign('kingdom_title_deleted_by');
            $table->dropForeign('kingdom_title_kingdom_id');
            $table->dropForeign('kingdom_title_title_id');
            $table->dropForeign('kingdom_title_updated_by');
        });

        Schema::table('kingdom_office', function (Blueprint $table) {
            $table->dropForeign('kingdom_office_created_by');
            $table->dropForeign('kingdom_office_deleted_by');
            $table->dropForeign('kingdom_office_kingdom_id');
            $table->dropForeign('kingdom_office_office_id');
            $table->dropForeign('kingdom_office_updated_by');
        });

        Schema::table('issuances', function (Blueprint $table) {
            $table->dropForeign('issuances_created_by');
            $table->dropForeign('issuances_deleted_by');
            $table->dropForeign('issuances_issuer_id');
            $table->dropForeign('issuances_revoked_by');
            $table->dropForeign('issuances_updated_by');
            $table->dropForeign('issuances_user_id');
        });

        Schema::table('events', function (Blueprint $table) {
            $table->dropForeign('events_autocrat_id');
            $table->dropForeign('events_created_by');
            $table->dropForeign('events_deleted_by');
            $table->dropForeign('events_location_id');
            $table->dropForeign('events_updated_by');
        });

        Schema::table('dues', function (Blueprint $table) {
            $table->dropForeign('dues_created_by');
            $table->dropForeign('dues_deleted_by');
            $table->dropForeign('dues_park_id');
            $table->dropForeign('dues_revoked_by');
            $table->dropForeign('dues_transaction_id');
            $table->dropForeign('dues_updated_by');
            $table->dropForeign('dues_user_id');
        });

        Schema::table('configurations', function (Blueprint $table) {
            $table->dropForeign('configurations_created_by');
            $table->dropForeign('configurations_deleted_by');
            $table->dropForeign('configurations_updated_by');
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
            $table->dropForeign('attendances_user_id');
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

        Schema::dropIfExists('users');

        Schema::dropIfExists('units');

        Schema::dropIfExists('transactions');

        Schema::dropIfExists('tournaments');

        Schema::dropIfExists('titles');

        Schema::dropIfExists('suspensions');

        Schema::dropIfExists('splits');

        Schema::dropIfExists('reconciliations');

        Schema::dropIfExists('recommendations');

        Schema::dropIfExists('pronouns');

        Schema::dropIfExists('parks');

        Schema::dropIfExists('parkranks');

        Schema::dropIfExists('offices');

        Schema::dropIfExists('officers');

        Schema::dropIfExists('members');

        Schema::dropIfExists('meetups');

        Schema::dropIfExists('locations');

        Schema::dropIfExists('kingdoms');

        Schema::dropIfExists('kingdom_title');

        Schema::dropIfExists('kingdom_office');

        Schema::dropIfExists('issuances');

        Schema::dropIfExists('events');

        Schema::dropIfExists('dues');

        Schema::dropIfExists('configurations');

        Schema::dropIfExists('awards');

        Schema::dropIfExists('attendances');

        Schema::dropIfExists('archetypes');

        Schema::dropIfExists('accounts');
    }
};
