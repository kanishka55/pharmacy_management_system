<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Prescription;

class Image extends Model
{
    use HasFactory;

    protected $table = 'images';

    protected $fillable=[
        'image',
        'prescription_id',
    ];

    public function prescription(){
        return $this->belongsTo(Prescription::class);
    }
}
