<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateUsersTable.
 */
class CreateCommissionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(config('access.table_names.commission'), function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->string('transection_to');
            $table->string('transection_by');
            $table->string('previous_bal')->nullable();
            $table->enum('type',['credit', 'debit'])->default('credit');//credit/debit
            $table->enum('commission_type',['enroller', 'downline', 'royalty','other']);
            $table->double('amount',15,2);
            $table->enum('status',['pending', 'inprogress','completed'])->default('pending');
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
        Schema::dropIfExists(config('access.table_names.commission'));
    }
}
