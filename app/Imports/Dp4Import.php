<?php

namespace App\Imports;

use App\Models\dp4;
use Maatwebsite\Excel\Concerns\ToModel;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class Dp4Import implements ToModel, WithCustomCsvSettings,WithChunkReading,ShouldQueue
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
       
        return new dp4([
            'nkk'=>$row[0],
            'nik'=>$row[1],
            'nama'=>$row[2],
            'tempat_lahir'=>$row[3],
            'tgl_lahir'=>$row[4],
            'jenis_kelamin'=>$row[5],
            'status'=>$row[6],
            'alamat'=>$row[7],
            'rt'=>$row[8],
            'rw'=>$row[9],
            'disabilitas'=>$row[10],
            'kd_kec'=>$row[13],
            'nama_kec'=>$row[14],
            'kd_kel'=>$row[15],
            'nama_kel'=>$row[16],
            'tps'=>$row[17],
            'ket'=>$row[18]
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
