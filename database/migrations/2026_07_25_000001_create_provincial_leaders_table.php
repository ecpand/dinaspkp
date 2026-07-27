<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration { public function up():void { Schema::create('provincial_leaders',function(Blueprint $table){$table->id();$table->string('name');$table->enum('position',['gubernur','wakil_gubernur']);$table->string('period',50)->nullable();$table->text('vision')->nullable();$table->string('photo_path')->nullable();$table->string('emblem_path')->nullable();$table->boolean('is_active')->default(true);$table->unsignedInteger('sort_order')->default(0);$table->timestamps();}); } public function down():void {Schema::dropIfExists('provincial_leaders');} };
