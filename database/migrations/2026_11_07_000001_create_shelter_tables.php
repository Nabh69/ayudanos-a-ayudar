<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
 public function up(): void {
 Schema::table('users',fn(Blueprint $t)=>$t->string('role')->default('supporter'));
 Schema::create('dogs',function(Blueprint $t){$t->id();$t->string('name');$t->string('age_text');$t->string('sex');$t->string('size');$t->text('description');$t->string('adoption_status')->default('disponible');$t->boolean('is_published')->default(false);$t->timestamps();});
 Schema::create('needs',function(Blueprint $t){$t->id();$t->string('title');$t->text('description');$t->unsignedInteger('quantity');$t->string('priority');$t->string('status')->default('activa');$t->timestamps();});
 Schema::create('donations',function(Blueprint $t){$t->id();$t->foreignId('user_id')->nullable()->constrained()->nullOnDelete();$t->foreignId('need_id')->nullable()->constrained()->nullOnDelete();$t->string('type');$t->decimal('amount',10,2)->nullable();$t->text('description');$t->string('status')->default('pendiente');$t->timestamps();});
 Schema::create('adoption_requests',function(Blueprint $t){$t->id();$t->foreignId('user_id')->constrained()->cascadeOnDelete();$t->foreignId('dog_id')->constrained()->restrictOnDelete();$t->string('housing_type');$t->text('experience');$t->string('status')->default('pendiente');$t->text('admin_notes')->nullable();$t->timestamps();});
 Schema::create('volunteer_applications',function(Blueprint $t){$t->id();$t->foreignId('user_id')->constrained()->cascadeOnDelete();$t->text('skills');$t->string('availability');$t->string('status')->default('pendiente');$t->timestamps();});
 Schema::create('care_records',function(Blueprint $t){$t->id();$t->foreignId('user_id')->constrained()->restrictOnDelete();$t->foreignId('dog_id')->constrained()->restrictOnDelete();$t->string('care_type');$t->text('description');$t->date('recorded_at');$t->timestamps();});
 }
 public function down(): void {foreach(['care_records','volunteer_applications','adoption_requests','donations','needs','dogs'] as $table) Schema::dropIfExists($table);Schema::table('users',fn(Blueprint $t)=>$t->dropColumn('role'));}
};
