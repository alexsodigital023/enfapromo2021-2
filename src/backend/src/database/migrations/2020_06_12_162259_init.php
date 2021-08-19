<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class Init extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this
            ->createStatus()
            ->createTienda()
            ->createEstado()
            ->createRegex()
            ->createTicket()
            ->createSyncout()
            ->createSyncin()
            ->createPhoto()
            ->createOauth()
            ->createAsignaciones()
            ->createCdp();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('ticket');
    }

    protected function createTienda(){
        Schema::create('cat_tienda',function(Blueprint $table){
            $table->id();
            $table->string('name',200);

        });
        return $this;
    }

    protected function createAsignaciones(){
        Schema::create('asignacion',function(Blueprint $table){
            $table->bigInteger('user_id',false,true);
            $table->bigInteger('ticket_id',false,true)->unique();
            $table->timestamp('fecha')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('ticket_id')->references('id')->on('ticket')->onDelete('cascade')->onUpdate('cascade');

        });
        return $this;
    }

    protected function createTicket(){

        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->string('email',false);
            $table->string('firstname');
            $table->string('lastname');
            $table->integer('source');
            $table->integer('status');
            $table->integer('points');
            $table->string('image');
            $table->datetime('submitDate');
            $table->string('timeZone')->nullable();
            $table->string('phonenumber');
            $table->string('shop');
            $table->string('TX')->nullable();
        });
        
        Schema::create('ticket', function (Blueprint $table) {
           
            $table->id();
            $table->bigInteger('user_id',false,true);
            $table->string('numero',20)->nullable();
            $table->string('nombre',50)->nullable();
            $table->string('apellido',50)->nullable();
            $table->string('telefono',50)->nullable();
            $table->string('edad',50)->nullable();
            $table->string('game_t',50)->nullable();
            $table->string('game_m',50)->nullable();
            $table->string('foto',200)->nullable();
            $table->bigInteger('estado_id',false,true);
            $table->bigInteger('tienda_id',false,true);
            $table->char('fingerprint',32);
            $table->string('mes',20)->nullable();
            $table->integer('dia',false,true)->nullable();
            $table->integer('anyo',false,true)->nullable();
            $table->string('email',false,true)->nullable();
            $table->string('path',200);
            $table->tinyInteger('status_id',false,true);
            $table->text('status_desc')->nullable();
            $table->bigInteger('rule_id',false,true)->nullable();
            //$table->text('data')->nullable();
            $table->longText('data')->nullable();
            $table->text('products_find')->nullable();
            $table->tinyInteger('product',false,true)->nullable();
            $table->decimal('import',8,2)->nullable();
            $table->double('process_time')->nullable();
            $table->integer('submited')->default(0);
            $table->timestamps();
            $table->integer("week",false,true)->virtualAs("WEEKOFYEAR(created_at)");
            $table->unique("fingerprint");
            $table->index(["status_id","path","product","import"]);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('status_id')->references('id')->on('cat_status');
            $table->foreign('estado_id')->references('id')->on('cat_estado');
            $table->foreign('tienda_id')->references('id')->on('cat_tienda');
            $table->foreign('rule_id')->references('id')->on('regex_rule');
        });

        DB::statement("create or replace view ganadores as
        select
        concat(SUBSTRING(`u`.`email`, 1,3),'***@***',SUBSTRING(`u`.`email`, -6)) as 'email',
        `e`.`name` as 'estado',
        `s`.`name` as 'tienda',
        `t`.`foto` as 'foto',
        `t`.`week`
        from `ticket` `t`
        left join `users` `u` on `u`.`id`=`t`.`user_id`
        left join `cat_estado` `e` on `e`.`id`=`t`.`estado_id`
        left join `cat_tienda` `s` on `s`.`id` = `t`.`tienda_id`
        where `status_id` = '11'");

        return $this;
    }
    protected function createStatus(){

        Schema::create('cat_status', function (Blueprint $table) {
            $table->tinyInteger('id',true,true);
            $table->string('name',200);
        });
        return $this;
    }
    protected function createEstado(){

        Schema::create('cat_estado', function (Blueprint $table) {
            $table->id('id');
            $table->string('name',200);
        });
        return $this;
    }
    protected function createRegex(){

        Schema::create('regex_rule', function (Blueprint $table) {
            $table->id('id');
            $table->text('product');
            $table->text('import');
            $table->tinyInteger('active')->default(0);
        });
        return $this;
    }
    protected function createSyncout(){

        Schema::create('syncout_status', function (Blueprint $table) {
            $table->bigInteger('ticket_id',false,true);
            $table->tinyInteger('status_id',false,true);
            $table->text('data')->nullable();
            $table->foreign('status_id')->references('id')->on('cat_status');
            $table->foreign('ticket_id')->references('id')->on('ticket')->onDelete('cascade')->onUpdate('cascade');
            $table->index(["ticket_id","status_id"]);
            $table->timestamps();
        });
        return $this;
    }
    protected function createSyncin(){

        Schema::create('syncin_status', function (Blueprint $table) {
            $table->bigInteger('ticket_id',false,true);
            $table->tinyInteger('status_id',false,true);
            $table->text('data')->nullable();
            $table->foreign('status_id')->references('id')->on('cat_status');
            $table->foreign('ticket_id')->references('id')->on('ticket')->onDelete('cascade')->onUpdate('cascade');
            $table->index(["ticket_id","status_id"]);
            $table->timestamps();
        });
        return $this;
    }
    protected function createPhoto(){

        Schema::create('photo', function (Blueprint $table) {
            $table->char('uuid',36);
            $table->bigInteger('user_id',false,true);
            $table->tinyInteger('status_id',false,true);
            $table->string('path',200);
            $table->foreign('status_id')->references('id')->on('cat_status');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->primary('uuid');
            $table->index(["uuid","status_id","path"]);
            $table->index(["user_id","path","uuid","status_id"]);
            $table->timestamps();
        });
        return $this;
    }

    protected function createOauth(){

        Schema::create('oauth_clients', function (Blueprint $table) {
            $table->id('client_id');
            $table->string('client_secret',80);
            $table->string('redirect_uri',200);
            $table->string('grant_types',80)->nullable();
            $table->string('scope',200)->nullable();
            $table->bigInteger('user_id',false,true)->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });

        Schema::create('oauth_access_tokens', function (Blueprint $table) {
            $table->string('access_token',40);
            $table->bigInteger('client_id',false,true);
            $table->string('user_id')->nullable();
            $table->dateTime('expires');
            $table->string('scope',200)->nullable();
            $table->foreign('user_id')->references('email')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('client_id')->references('client_id')->on('oauth_clients')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });

        Schema::create('oauth_authorization_codes', function (Blueprint $table) {
            $table->id('id');
            $table->string('authorization_code',40);
            $table->bigInteger('client_id',false,true);
            $table->string('user_id')->nullable();
            $table->string('redirect_uri',200);
            $table->dateTime('expires');
            $table->string('scope',200)->nullable();
            $table->foreign('user_id')->references('email')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('client_id')->references('client_id')->on('oauth_clients')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });

        Schema::create('oauth_refresh_tokens', function (Blueprint $table) {
            $table->string('refresh_token',40);
            $table->bigInteger('client_id',false,true);
            $table->string('user_id')->nullable();
            $table->dateTime('expires');
            $table->string('scope',200)->nullable();
            $table->foreign('user_id')->references('email')->on('users')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('client_id')->references('client_id')->on('oauth_clients')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });

        Schema::create('oauth_scopes', function (Blueprint $table) {
            $table->string('type',255)->default("supported");
            $table->string('scope',200)->nullable();
            $table->bigInteger('client_id',false,true)->nullable();
            $table->tinyInteger('is_default',false,true)->nullable();
            $table->foreign('client_id')->references('client_id')->on('oauth_clients')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });

        Schema::create('oauth_jwt', function (Blueprint $table) {
            $table->bigInteger('client_id',false,true)->nullable();
            $table->string('subject',255)->nullable();
            $table->string('public_key',2000)->nullable();
            $table->foreign('client_id')->references('client_id')->on('oauth_clients')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });

        DB::statement("create or REPLACE VIEW oauth_users as select email as username, password as password, name as first_name, null as last_name from users where oauth=1");
        return $this;
    }
    protected function createCdp(){

        Schema::create('cdp_token', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('access_token',200);
            $table->string('token_type',20);
            $table->string('refresh_token',200);
            $table->dateTime('expires_date');
        });
        return $this;
    }

}

