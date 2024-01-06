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
        Schema::create('surveys', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class, 'user_id')->comment('ユーザーID');
            $table->string('title', 1000)->comment('タイトル');
            $table->string('slug', 1000)->comment('ページを識別するURL');
            $table->tinyInteger('status')->comment('公開状態');
            $table->text('description')->nullable()->comment('説明文');
            $table->timestamps();
            $table->timestamp('expire_date')->nullable()->comment('有効期限');
            $table->comment('アンケート');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surveys');
    }
};
