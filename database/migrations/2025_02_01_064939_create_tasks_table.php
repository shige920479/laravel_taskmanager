<?php

use App\Models\User;
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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onUpdate('cascade');
            $table->tinyInteger('priority');
            $table->string('category', 50);
            $table->string('theme', 50);
            $table->string('content', 255);
            $table->date('deadline');
            $table->tinyInteger('msg_flag')->default(0);
            $table->tinyInteger('mg_to_mem')->default(0);
            $table->tinyInteger('mem_to_mg')->default(0);
            $table->tinyInteger('del_flag')->default(0);
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
        Schema::dropIfExists('tasks');
    }
};
