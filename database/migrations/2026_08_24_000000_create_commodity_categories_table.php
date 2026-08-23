<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('commodity_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->timestamps();
        });

        // Insert initial/default categories
        $defaultCategories = ['Hortikultura', 'Perkebunan', 'Peternakan', 'Kehutanan', 'Pangan'];
        foreach ($defaultCategories as $name) {
            DB::table('commodity_categories')->insert([
                'name' => $name,
                'slug' => Str::slug($name),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Add category_id to agriculture_commodities
        Schema::table('agriculture_commodities', function (Blueprint $table) {
            $table->unsignedBigInteger('category_id')->nullable()->after('slug');
            $table->foreign('category_id')->references('id')->on('commodity_categories')->onDelete('restrict');
        });

        // Map existing categories to category_id
        $commodities = DB::table('agriculture_commodities')->get();
        foreach ($commodities as $com) {
            $catName = trim($com->category ?? '');
            if (empty($catName)) {
                $catName = 'Lainnya';
            }
            // Find or create category
            $cat = DB::table('commodity_categories')->where('name', $catName)->first();
            if (!$cat) {
                // In case it's some other category, create it dynamically
                $catId = DB::table('commodity_categories')->insertGetId([
                    'name' => $catName,
                    'slug' => Str::slug($catName),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } else {
                $catId = $cat->id;
            }

            DB::table('agriculture_commodities')->where('id', $com->id)->update([
                'category_id' => $catId,
            ]);
        }

        // Drop category column
        Schema::table('agriculture_commodities', function (Blueprint $table) {
            $table->dropColumn('category');
        });
    }

    public function down(): void
    {
        Schema::table('agriculture_commodities', function (Blueprint $table) {
            $table->string('category')->nullable()->after('slug');
        });

        // Map category_id back to string category
        $commodities = DB::table('agriculture_commodities')->get();
        foreach ($commodities as $com) {
            if ($com->category_id) {
                $cat = DB::table('commodity_categories')->where('id', $com->category_id)->first();
                if ($cat) {
                    DB::table('agriculture_commodities')->where('id', $com->id)->update([
                        'category' => $cat->name,
                    ]);
                }
            }
        }

        Schema::table('agriculture_commodities', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
        });

        Schema::dropIfExists('commodity_categories');
    }
};
