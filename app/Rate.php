<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rate extends Model
{
    use SoftDeletes;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Set this option's table name.
     *
     * @param string $tableName
     * @return $this
     */
    public function setTableName(string $tableName)
    {
        $this->table_name = $tableName;
        return $this;
    }

  
}
