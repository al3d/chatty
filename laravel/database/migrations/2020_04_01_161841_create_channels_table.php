<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChannelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('channels', function (Blueprint $table) {
            $table->id();
            $table->char('uuid', 30)->unique();
            $table->string('name');
            $table->string('description');
            $table->unsignedBigInteger('creator_id')->nullable()->index();
            $table->boolean('is_deleteable')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table
                ->foreign('creator_id')
                ->references('id')
                ->on('users')
            ;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('channels');
    }
}
