<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category = new \App\Models\Category();
        $category->{\App\Models\Category::FIELD_TITLE} = "Ложки";
        $category->save();

        foreach (["Металлические", "Деревянные"] as $subTitle) {
            $subCategory = new \App\Models\Category();
            $subCategory->{\App\Models\Category::FIELD_TITLE} = $subTitle;
            $subCategory->save();

            foreach (["Большие", "Средние", "Маленькие"] as $lastTitle) {
                $lastCategory = new \App\Models\Category();
                $lastCategory->{\App\Models\Category::FIELD_TITLE} = $lastTitle;
                $lastCategory->save();
                $subCategory->appendNode($lastCategory);
            }

            $category->appendNode($subCategory);
        }
    }
}
