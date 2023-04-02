<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Capsule\Manager as Capsule;

class JamfConnectInit extends Migration
{
    public function up()
    {
        $capsule = new Capsule();
        $capsule::schema()->create('jamf_connect', function (Blueprint $table) {
            $table->increments('id');
            $table->string('serial_number');
            $table->string('display_name')->nullable();
            $table->string('jamf_connect_id')->nullable();
            $table->string('password_last_changed')->nullable();
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('locale')->nullable();
            $table->string('login')->nullable();
            $table->string('time_zone')->nullable();
            $table->string('last_analytics_checkin')->nullable();
            $table->string('last_sign_in')->nullable();
            $table->string('last_license_check')->nullable();
            $table->boolean('password_current')->nullable();

            $table->unique('serial_number');
            $table->index('display_name');
            $table->index('jamf_connect_id');
            $table->index('password_last_changed');
            $table->index('first_name');
            $table->index('last_name');
            $table->index('locale');
            $table->index('login');
            $table->index('time_zone');
            $table->index('last_analytics_checkin');
            $table->index('last_sign_in');
            $table->index('last_license_check');
            $table->index('password_current');

        });
    }
    
    public function down()
    {
        $capsule = new Capsule();
        $capsule::schema()->dropIfExists('jamf_connect');
    }
}
