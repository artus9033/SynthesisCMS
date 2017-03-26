        <?php

        use Illuminate\Support\Facades\Schema;
        use Illuminate\Database\Schema\Blueprint;
        use Illuminate\Database\Migrations\Migration;

        class CreateLithiumExtensionsTable extends Migration
        {
            /**
             * Run the migrations.
             *
             * @return void
             */
            public function up()
            {
                Schema::create('lithium_extensions', function (Blueprint $table) {
                    $table->increments('id');
                    $table->integer('atom')->default(1);
                    $table->boolean('showHeader')->default(true);
                    $table->timestamps();
                });
            }

            /**
             * Reverse the migrations.
             *
             * @return void
             */
            public function down()
            {
                Schema::dropIfExists('lithium_extensions');
            }
        }
