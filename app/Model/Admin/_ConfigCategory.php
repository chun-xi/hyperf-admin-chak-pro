<?php

declare (strict_types=1);
namespace App\Model\Admin;

use App\Model\Model;

/**
 * @property int $id 
 * @property string $name 
 * @property string $create_date 
 * @property int $rank 
 */
class _ConfigCategory extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = '_config_category';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['id' => 'integer', 'rank' => 'integer'];
}