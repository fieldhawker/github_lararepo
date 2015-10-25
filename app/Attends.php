<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Attends extends Model {

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'attends';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array(
      'user_key',
      'type',
      'attend_at',
      'salaried',
      'biko',
      'updated_by'
    );

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['_token'];

}
