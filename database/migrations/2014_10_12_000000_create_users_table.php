<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateUsersTable.
 */
class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('access.table_names.users'), function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->string('referral_code')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->date('dob')->nullable();
            $table->string('pan_no')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->unique();
            $table->string('avatar_type')->default('gravatar');
            $table->string('gender')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('avatar_location')->nullable();
            $table->string('password')->nullable();
            $table->timestamp('password_changed_at')->nullable();
            $table->string('enroller_id')->nullable();
            $table->string('sponsor_id')->nullable();
            $table->tinyInteger('active')->default(0)->unsigned();
            $table->string('confirmation_code')->nullable();
            $table->boolean('confirmed')->default(config('access.users.confirm_email') ? false : true);
            $table->boolean('receive_email')->default(true);
            $table->string('timezone')->default('Asia/Kolkata');
            $table->string('nominee_name')->nullable();
            $table->string('nominee_relation')->nullable();
            $table->string('address1')->nullable();
            $table->string('address2')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->string('postal_code')->nullable();
            $table->string('account_no')->nullable();
            $table->string('account_title')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('branch_name')->nullable();
            $table->string('ifcs')->nullable();
            $table->string('swift_code')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(config('access.table_names.users'));
    }
}
