<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\LetterCategory;

class LetterCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Undangan',
            'Pemberitahuan',
            'Permohonan',
            'Keputusan',
            'Penawaran',
            'Kerja Sama',
            'Laporan',
            'Lainnya',
        ];

        foreach ($categories as $category) {
            LetterCategory::updateOrCreate(
                ['category_name' => $category],
                [
                    'description' => 'Kategori surat ' . $category,
                    'is_active' => true,
                ]
            );
        }
    }
}
