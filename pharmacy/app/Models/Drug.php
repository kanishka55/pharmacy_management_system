<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Drug extends Model
{
    use HasFactory;

    protected $table = 'drugs';

    protected $fillable = [

        'drug_name',
        'unit_price',
    ];


    public function quotations()
    {
        return $this->belongsToMany(Quotation::class, 'quotation_drugs')
                    ->withPivot('quantity', 'amount');
    }
}
