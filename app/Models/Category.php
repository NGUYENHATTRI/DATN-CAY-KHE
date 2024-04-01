<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'catergory';
<<<<<<< HEAD
    protected $primaryKey = 'catergoryID';
    protected $fillable = [
        'catergoryID',
=======
    protected $primaryKey = 'categoryID';
    protected $fillable = [
        'categoryID',
>>>>>>> 9be4f535119801111f8ba8b55f169930c5848259
        'name',
    ];
    public $timestamps =false;
}
