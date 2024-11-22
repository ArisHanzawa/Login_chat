<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // インデックスの削除
        DB::statement('ALTER TABLE push_subscriptions DROP INDEX push_subscriptions_endpoint_unique');
        // カラムのデータ型を変更
        DB::statement('ALTER TABLE push_subscriptions MODIFY COLUMN endpoint TEXT');
        // インデックスの再作成
        DB::statement('ALTER TABLE push_subscriptions ADD UNIQUE (endpoint(255))');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // インデックスの削除
        DB::statement('ALTER TABLE push_subscriptions DROP INDEX push_subscriptions_endpoint_unique');
        // カラムのデータ型を元に戻す
        DB::statement('ALTER TABLE push_subscriptions MODIFY COLUMN endpoint VARCHAR(255)');
        // インデックスの再作成
        DB::statement('ALTER TABLE push_subscriptions ADD UNIQUE (endpoint)');
    }
};
