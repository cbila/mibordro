<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromCollection, WithMapping, WithHeadings, ShouldAutoSize
{
    use Exportable;

    protected $users;

    public function __construct($users)
    {
        $this->users = $users;

        return $this;

    }


    public function collection()
    {
        return $this->users;
    }


    public function map($user): array
    {
        return [
            $user->name ?? '',
            $user->email ?? '',
            $user->identity ?? '',
            $user->company->name ?? '',
            $user->sgk->name ?? '',
            $user->recruitment_date,
            $user->gsm ?? '',
            $user->iban ?? '',
            $user->position ?? '',
            $user->holidays ?? '',
            $user->info ?? '',
            $user->created_at ?? '',
        ];
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function headings(): array
    {
        return ['Adı Soyadı', 'e-Posta', 'TC Kimlik', 'Firma', 'SGK', 'İşe Giriş', 'Telefon', 'IBAN', 'Görevi', 'İzin Günü', 'Notlar', 'Sisteme Kayıt'];
    }

    // public function columnFormats(): array
    // {
    //     return [
    //         'A' => 300,
    //         'B' => 300,
    //         'C' => 300,
    //         'D' => 300,
    //     ];
    // }
}
