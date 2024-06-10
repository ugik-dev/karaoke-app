<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenditureUnit extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'code'];

    public static function findExpenditureUnitId($unitCode)
    {
        $expenditureUnit = self::firstWhere('code', $unitCode);

        return $expenditureUnit ? $expenditureUnit->id : null;
    }
}
