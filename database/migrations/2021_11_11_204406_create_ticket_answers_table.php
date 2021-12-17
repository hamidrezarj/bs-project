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
            $table->text('description')->nullable();
            $table->integer('user_vote')->nullable();
            $table->foreignId('technical_id')->nullable()->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('ticket_id')->nullable()->references('id')->on('tickets')->onDelete('cascade');
            $table->timestamp('reply_date')->nullable();
            $table->timestamp('vote_date')->nullable();
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
