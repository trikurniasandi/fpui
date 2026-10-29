<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Tipe publikasi yang didukung setelah penambahan menu Publikasi.
     */
    private array $newTypes = ['article', 'news', 'best_practice', 'bulletin', 'infographic', 'video'];

    private array $oldTypes = ['article', 'news'];

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('publications', function (Blueprint $table) {
            $table->string('video_url')->nullable()->after('attachment');
        });

        $this->changeTypeEnum($this->newTypes);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Baris dengan tipe baru tidak akan lolos enum lama, kembalikan ke 'article' dulu.
        DB::table('publications')
            ->whereNotIn('type', $this->oldTypes)
            ->update(['type' => 'article']);

        $this->changeTypeEnum($this->oldTypes);

        Schema::table('publications', function (Blueprint $table) {
            $table->dropColumn('video_url');
        });
    }

    /**
     * Kolom `type` memakai enum MySQL. Perubahan enum membutuhkan ALTER langsung,
     * karena Laravel 10 memerlukan doctrine/dbal untuk ->change().
     * Driver lain (mis. sqlite pada test) tidak diubah.
     */
    private function changeTypeEnum(array $types): void
    {
        if (DB::getDriverName() !== 'mysql') {
            return;
        }

        $values = implode("','", $types);

        DB::statement(
            "ALTER TABLE `publications` MODIFY COLUMN `type` "
            . "ENUM('{$values}') NOT NULL DEFAULT 'article'"
        );
    }
};
