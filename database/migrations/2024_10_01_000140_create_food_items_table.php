<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('food_items', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
            $table->string('fdcId')->nullable();
            $table->string('description');
            $table->string('brandName')->nullable();
            $table->string('brandOwner')->nullable();
            $table->integer('servingSize');
            $table->string('servingSizeUnit');
            $table->string('foodCategory');
            $table->integer('calories');
            $table->json('foodNutrients');
            $table->text('ingredients')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('food_items');
    }
};
