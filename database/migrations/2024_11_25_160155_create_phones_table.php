<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('phones', function (Blueprint $table) {
      $table->id();
      $table->string('phone_num', 100)->unique();
      $table->string('provider_name', 100);
      $table->timestamps();

      $table->foreignId('user_id')->constrained();
      // $table->unSignedBigInteger('id_user');
      // $table->foreign('id_user')->references('id')->on('users');
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('phones');
  }
};
