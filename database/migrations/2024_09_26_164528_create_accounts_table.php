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
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
            $table->integer('bmr'); // BMR
            $table->integer('goalModifier'); //Goal Modifier
            $table->integer('goal'); //Goal
            $table->integer('age');
            $table->string('gender');
            $table->float('height');
            $table->float('weight');
            $table->string('activity');
            $table->boolean('trackMacros')->default(false);
            $table->json('macros')->default(json_encode(['carbohydrates' => 0, 'protein' => 0, 'fats' => 0]));
            $table->string('theme')->default('theme-sunRise');
            $table->string('timezone');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
