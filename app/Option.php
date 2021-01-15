<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Option extends Model
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

    /**
     * Set this option's table name via mutator.
     *
     * @param string $value
     */
    public function setTableNameAttribute(string $value)
    {
        $this->attributes['table_name'] = 'table_option_' . $value;
    }

    /**
     * Set this option's title.
     *
     * @param string $title
     * @return $this
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Return this option's id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Return this option's table name.
     * @return string
     */
    public function getTableName()
    {
        return $this->table_name;
    }

    /**
     * Return this option's title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    public function injects()
    {
        return $this->hasMany('App\Inject');
    }
}
