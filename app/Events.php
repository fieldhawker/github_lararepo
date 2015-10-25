<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Events extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'events';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array(
      'title',
      'image_path',
      'article_url',
      'status',
      'site_id',
      'start_date',
      'end_date',
      'updated_by'
    );

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['_token'];


}
