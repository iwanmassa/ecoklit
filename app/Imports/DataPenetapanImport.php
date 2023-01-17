<?php

namespace App\Imports;

use App\Models\DataPenetapan;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DataPenetapanImport implements ToModel, WithHeadingRow, WithCustomCsvSettings,WithChunkReading,ShouldQueue
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
       // dd($row);
        return new DataPenetapan([
            'dpid'=>$row["id"],
            'nkk'=>$row['nkk'],
            'nik'=>$row['nik'],
            'nama'=>$row['nama'],
            'tempat_lahir'=>$row['tempat_lahir'],
            'tgl_lahir'=>$row['tanggal_lahir'],
            'jenis_kelamin'=>$row['jenis_kelamin'],
            'status'=>$row['kawin'],
            'alamat'=>$row['alamat'],
            'rt'=>$row['rt'],
            'rw'=>$row['rw'],
            'disabilitas'=>$row['difabel'],
            'kd_kec'=>request()->post('kd_kec'),
            'kd_kel'=>request()->post('kd_kel'),
            'tps'=>$row['tps']
        ]);
    }
    public function getCsvSettings(): array
    {
        return [
            'delimiter' => "#"
        ];
    }
    public function batchSize(): int
    {
        return 1000;
    }
    public function chunkSize(): int
    {
        return 1000;
    }
    
}
