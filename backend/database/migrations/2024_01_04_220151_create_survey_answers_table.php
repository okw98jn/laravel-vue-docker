<?php

use App\Models\Survey;
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
        Schema::create('survey_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Survey::class, 'survey_id')->comment('アンケートID');
            $table->timestamp('start_date')->nullable()->comment('回答開始日時');
            $table->timestamp('end_date')->nullable()->comment('回答終了日時');
            $table->comment('アンケート回答');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('survey_answers');
    }
};
