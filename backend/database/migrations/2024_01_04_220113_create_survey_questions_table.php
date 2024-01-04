<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Survey;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('survey_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Survey::class, 'survey_id')->comment('アンケートID');
            $table->string('type', 45)->comment('質問種類');
            $table->string('question', 2000)->comment('質問文');
            $table->longText('description')->nullable()->comment('説明文');
            $table->longText('data')->nullable()->comment('質問データ');
            $table->timestamps();
            $table->comment('アンケート質問');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('survey_questions');
    }
};
