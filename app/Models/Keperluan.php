<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keperluan extends Model
{
    protected $table = 'keperluan';

    protected $primaryKey = 'id_keperluan';

    public $timestamps = false;

    public const CREATED_AT = 'created';

    protected $fillable = ['nama', 'keperluan'];

    public function setAttribute($key, $value)
    {
        return parent::setAttribute($key === 'nama' ? 'keperluan' : $key, $value);
    }

    public function getAttribute($key)
    {
        return parent::getAttribute($key === 'nama' ? 'keperluan' : $key);
    }
}