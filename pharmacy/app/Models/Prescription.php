<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Image;
class Prescription extends Model
{
    use HasFactory;

    use HasFactory;

    protected $table = 'prescriptions';

    protected $fillable=[
        'note',
        'deliveryaddress',
        'delivery_time',
        'user_id',
        'is_complete',
    ];

    public function uploadImages(){
        return $this->hasMany(Image::class, 'prescription_id','id');
    }

    public function quotation()
    {
        return $this->hasOne(Quotation::class, 'prescription_id','id');
    }
}
