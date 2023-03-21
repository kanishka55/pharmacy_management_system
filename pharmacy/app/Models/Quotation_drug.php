<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quotation_drug extends Model
{
    use HasFactory;

    protected $table = 'quotation_drugs';

    protected $fillable = [
        'quotation_id',
        'drug_id',
        'quantity',
        'amount',
    ];

    public function quotation()
    {
        return $this->belongsTo(Quotation::class);
    }

    public function drug()
    {
        return $this->belongsTo(Drug::class);
    }
}
