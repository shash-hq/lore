<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $duplicates = DB::table('bookmarks')
            ->select('user_id', 'video_id', DB::raw('MIN(id) as keep_id'))
            ->groupBy('user_id', 'video_id')
            ->havingRaw('COUNT(*) > 1')
            ->get();

        foreach ($duplicates as $duplicate) {
            DB::table('bookmarks')
                ->where('user_id', $duplicate->user_id)
                ->where('video_id', $duplicate->video_id)
                ->where('id', '!=', $duplicate->keep_id)
                ->delete();
        }

        Schema::table('bookmarks', function (Blueprint $table) {
            $table->unique(['user_id', 'video_id']);
        });
    }

    public function down(): void
    {
        Schema::table('bookmarks', function (Blueprint $table) {
            $table->dropUnique('bookmarks_user_id_video_id_unique');
        });
    }
};
