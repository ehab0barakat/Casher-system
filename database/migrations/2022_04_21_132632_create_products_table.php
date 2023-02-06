 <?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    class CreateProductsTable extends Migration
    {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            Schema::create('products', function (Blueprint $table) {
                $table->id();
                $table->foreignId('supplier_id')->constrained('suppliers', 'id')->cascadeOnUpdate()->cascadeOnDelete();
                $table->string('name');
                $table->unsignedSmallInteger('quantity');
                $table->double('costPrice', 8, 2);
                $table->double('retailPrice', 8, 2);
                $table->string('photo')->nullable();
                $table->string('barcodeId')->unique()->default('');
                $table->enum('status', ['0', '1'])->default('1');
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
            Schema::dropIfExists('products');
        }
    }