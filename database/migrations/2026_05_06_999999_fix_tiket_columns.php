 <?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('tikets', function (Blueprint $table) {
            if (!Schema::hasColumn('tikets', 'kategori')) {
                $table->string('kategori')->nullable()->after('nama_tiket');
            }
            if (!Schema::hasColumn('tikets', 'subtitle')) {
                $table->string('subtitle')->nullable()->after('kategori');
            }
            if (!Schema::hasColumn('tikets', 'widget_code')) {
                $table->text('widget_code')->nullable()->after('stok');
            }
            if (!Schema::hasColumn('tikets', 'is_featured')) {
                $table->boolean('is_featured')->default(false)->after('widget_code');
            }
        });
    }

    public function down(): void
    {
        Schema::table('tikets', function (Blueprint $table) {
            $table->dropColumn(['kategori', 'subtitle', 'widget_code', 'is_featured']);
        });
    }
};
