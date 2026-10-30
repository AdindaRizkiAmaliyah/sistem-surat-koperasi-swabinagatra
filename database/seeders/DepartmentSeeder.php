<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $departments = [
            [
                'department_code' => 'KEU',
                'department_name' => 'Keuangan',
                'description' => 'Departemen Keuangan Koperasi',
            ],
            [
                'department_code' => 'OPS',
                'department_name' => 'Operasional',
                'description' => 'Departemen Operasional Koperasi',
            ],
            [
                'department_code' => 'ADM',
                'department_name' => 'Administrasi',
                'description' => 'Departemen Administrasi Koperasi',
            ],
        ];

        foreach ($departments as $department) {
            Department::updateOrCreate(
                ['department_code' => $department['department_code']],
                $department
            );
        }
    }
}
