<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class UsersImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new User([
            'name'            => $row['name'] ?? null,
            'last_name'       => $row['last_name'] ?? null,
            'email'           => $row['email'] ?? null,
            'nubhar'          => $row['phone'] ?? null,
            'dob'             => $this->formatDate($row['dob'] ?? null),
            'anniversaryDate' => $this->formatDate($row['anniversary_date'] ?? null),
            'status'          => $row['status'] ?? 'Active',
            'user_type'       => $row['user_type'] ?? 'B2C',
            'b2b_agent'      => $row['b2b_agent']
        ]);
    }

    private function formatDate($value)
    {
        if (!$value) return null;

        // If it's a number, treat it as Excel date
        if (is_numeric($value)) {
            return Date::excelToDateTimeObject($value)->format('Y-m-d');
        }

        // If already in a string date format
        return date('Y-m-d', strtotime($value));
    }
}
