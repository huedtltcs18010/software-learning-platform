<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddSomeColumnsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('role')->default(0)->after('id');
            $table->string('fullname')->after('email_verified_at');
            $table->string('phone_number')->nullable()->after('fullname');
            $table->string('avatar')->nullable()->after('phone_number');
            $table->string('cover')->nullable()->after('avatar');
            $table->text('about')->nullable()->after('cover');
            $table->string('website')->nullable()->after('about');
            $table->string('social_links')->nullable()->after('website');
        });
        DB::table('users')
            ->where('id', 1)
            ->update([
                'role' => 1,
                'fullname' => 'Root Admin',
                'phone_number' => '0123456789',
                'avatar' => '/images/avatar-person.svg',
                'cover' => null,
                'about' => null,
                'website' => null,
                'social_links' => json_encode(['facebook' => '', 'youtube' => '']),
            ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
            $table->dropColumn('fullname');
            $table->dropColumn('phone_number');
            $table->dropColumn('avatar');
            $table->dropColumn('cover');
            $table->dropColumn('about');
            $table->dropColumn('website');
            $table->dropColumn('social_links');
        });
    }
}
