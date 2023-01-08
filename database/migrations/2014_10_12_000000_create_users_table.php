<?php

use App\Models\Address;
use App\Models\UserRole;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_roles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('login_allowed')->default(false);
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('mobile',20)->nullable();
            $table->string('user_role')->default(UserRole::CUSTOMER);
            $table->string('password')->nullable();
            $table->string('referral_code',20)->nullable();
            $table->bigInteger('referred_by')->nullable();
            $table->string('image')->nullable()->default('images/user.jpg');
            $table->string('gender', 30)->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('marital', 30)->nullable();
            $table->date('aniversary')->nullable();
            $table->boolean('active')->default(true);
            $table->rememberToken();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
            $table->softDeletes();

            // Table Index
            $table->unique(['email']);
            $table->unique(['mobile']);

            $table->index('referral_code');
            $table->index('referred_by');
        });

        Schema::create('configs', function (Blueprint $table) {
            $table->id();
            $table->string('config_key',100);
            $table->string('config_value');
            $table->longText('description')->nullable();
            $table->bigInteger('updated_by')->comment('UserId from Users Table')->nullable();
            $table->softDeletes();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });

        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->unsigned()->index();
            $table->string('title')->nullable();
            $table->longText('message')->nullable();
            $table->longText('payload')->nullable();
            $table->timestamp('read_at')->nullable();
            $table->softDeletes();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });

        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->unsigned()->index();
            $table->string('type',15)->default(Address::HOME);
            $table->longText('address_line_1')->nullable();
            $table->longText('address_line_2')->nullable();
            $table->longText('landmark')->nullable();
            $table->string('pincode',20)->nullable();
            $table->string('latitude',150)->nullable();
            $table->string('longitude',150)->nullable();
            $table->boolean('default')->default(false);
            $table->softDeletes();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });

        Schema::create('category', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('active')->default(true);
            $table->softDeletes();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });

        Schema::create('businesses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id')->comment('Referance of Client from User Table')->unsigned()->index();
            $table->unsignedBigInteger('category_id')->comment('Referance of Category Table Id')->unsigned()->index();
            $table->string('name');
            $table->string('logo')->default('images/business-img.png');
            $table->text('address')->nullable();
            $table->string('pincode')->nullable();
            $table->string('business_email')->nullable();
            $table->string('business_mobile')->nullable();
            $table->timestamp('valid_till')->nullable();
            $table->boolean('active')->default(true);
            $table->softDeletes();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('client_id');
            $table->bigInteger('business_id');
            $table->string('image');
            $table->string('name');
            $table->decimal('price',8,2)->nullable()->comment('Product Price Per Unit');
            $table->decimal('discount',2,2)->nullable()->comment('Discounted Percentage');
            $table->longText('description')->nullable()->comment('Discription about Product');
            $table->date('expiry')->nullable();
            $table->softDeletes();
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_roles');
        Schema::dropIfExists('users');
        Schema::dropIfExists('configs');
        Schema::dropIfExists('notifications');
        Schema::dropIfExists('addresses');
        Schema::dropIfExists('category');
        Schema::dropIfExists('businesses');
        Schema::dropIfExists('products');
    }
}
