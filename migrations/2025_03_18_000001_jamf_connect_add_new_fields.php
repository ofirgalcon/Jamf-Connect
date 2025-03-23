<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Capsule\Manager as Capsule;

class JamfConnectAddNewFields extends Migration
{
    private $tableName = 'jamf_connect';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $capsule = new Capsule();
        $capsule::schema()->table($this->tableName, function (Blueprint $table) {
            $table->timestamp('expiration_warning_last')->nullable();
            $table->boolean('first_run_done')->nullable();
            $table->timestamp('last_certificate_expiration')->nullable();
            $table->timestamp('last_totp_notification')->nullable();
            $table->boolean('offline_mfa_setup_success')->nullable();
            $table->integer('password_expiration_remaining_days')->nullable();
            $table->integer('unsent_offline_mfa_events')->nullable();
            $table->string('user_login_name')->nullable();

            // Add indexes for the new columns
            $table->index('expiration_warning_last');
            $table->index('first_run_done');
            $table->index('last_certificate_expiration');
            $table->index('last_totp_notification');
            $table->index('offline_mfa_setup_success');
            $table->index('password_expiration_remaining_days');
            $table->index('unsent_offline_mfa_events');
            $table->index('user_login_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $capsule = new Capsule();
        $capsule::schema()->table($this->tableName, function (Blueprint $table) {
            // Drop indexes first
            $table->dropIndex(['expiration_warning_last']);
            $table->dropIndex(['first_run_done']);
            $table->dropIndex(['last_certificate_expiration']);
            $table->dropIndex(['last_totp_notification']);
            $table->dropIndex(['offline_mfa_setup_success']);
            $table->dropIndex(['password_expiration_remaining_days']);
            $table->dropIndex(['unsent_offline_mfa_events']);
            $table->dropIndex(['user_login_name']);

            // Then drop columns
            $table->dropColumn([
                'expiration_warning_last',
                'first_run_done',
                'last_certificate_expiration',
                'last_totp_notification',
                'offline_mfa_setup_success',
                'password_expiration_remaining_days',
                'unsent_offline_mfa_events',
                'user_login_name'
            ]);
        });
    }
} 