<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;


class Category extends Model
{
    use HasFactory;
    use SoftDeletes;
    use LogsActivity;


    protected $fillable = [
        'name'
    ];


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults();
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

}
