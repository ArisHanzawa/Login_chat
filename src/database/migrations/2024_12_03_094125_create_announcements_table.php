<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        schema::create('announcements', function (Blueprint $table){
            $table->id();
            $table->string('title')->comment('お知らせ：タイトル');
            $table->text('description')->comment('お知らせ：内容');
            $table->timestamps();
        });
    }
};