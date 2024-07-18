<?php
 
 use Illuminate\Database\Migrations\Migration;
 use Illuminate\Database\Schema\Blueprint;
 use Illuminate\Support\Facades\Schema;
  
 return new class extends Migration
 {
     public function up()
     {
         Schema::create('members', function (Blueprint $table) {
             $table->id('id_member');
             $table->string('nama_member');
             $table->string('email')->unique();
             $table->string('nomer_hp');
             $table->text('alamat');
             $table->integer('diskon')->default(0);
             $table->timestamps();
         });
     }
  
     /**
      * Reverse the migrations.
      */
     public function down(): void
     {
         Schema::dropIfExists('member');
     }
 };
  