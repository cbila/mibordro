<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Document extends Model
{
    use HasFactory;
    use LogsActivity;


    protected $fillable = ['disk', 'category_id', 'extension', 'date', 'file', 'alias', 'mime', 'path', 'size', 'description'];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logFillable();

    }



    /**
     * The document that belong to the user.
     */
    public function owner()
    {
        return $this->belongsTo(User::class);
    }

    // public function getDateAttribute()
    // {
    //     return date('d-m-Y', strtotime($this->attributes['date']));
    // }
    
    // public function setDateAttribute()
    // {
    //     // dd(date('Y-m', strtotime($this->attributes['date'])));

    //     return date('Y-m-d', strtotime($this->attributes['date']));
    // }

    // public function getCreatedAtAttribute()
    // {
    //     return date('d-m-Y H:i', strtotime($this->attributes['created_at']));
    // }

    // public function getUpdatedAtAttribute()
    // {
    //     return date('d-m-Y H:i', strtotime($this->attributes['updated_at']));
    // }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }


}
