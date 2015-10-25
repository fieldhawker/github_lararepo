<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Information extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'informations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['text', 'updated_by'];

}
