<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalReports extends Model
{
    use HasFactory;

    /**
     * Allow fields that can be saved into the database
     */
    protected $fillable = [
        'user_id',
        'xray',
        'ultrasound_scan',
        'ct_scan',
        'mri'
    ];

    /**
     * Get the patient that owns the medical report.
     */
    public function patient()
    {
        return $this->belongsTo( User::class,'user_id');
    }
}
