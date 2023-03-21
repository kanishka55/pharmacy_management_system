<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
    use HasFactory;
    protected $table = 'quotations';

    protected $fillable = [

        'prescription_id',
        'user_id',
        'total_amount',
        'is_accept',
        'is_reject',


    ];

    public function prescription()
    {
        return $this->belongsTo(Prescription::class);
    }

    public function drugs()
    {
        return $this->belongsToMany(Drug::class,'quotation_drugs')->withPivot('quantity', 'amount');
    }
}
