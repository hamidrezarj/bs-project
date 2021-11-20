<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticket_answers', function (Blueprint $table) {
            $table->id();
            $table->text('description');
            $table->integer('user_vote')->nullable();
            $table->foreignId('user_id')->references('id')->on('users');
            $table->foreignId('ticket_id')->nullable()->references('id')->on('tickets');
            $table->timestamp('created_at_fa')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ticket_answers');
    }
}
