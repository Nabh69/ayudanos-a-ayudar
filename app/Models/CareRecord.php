<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class CareRecord extends Model {
 protected $guarded = ['id'];
 public function user() { return $this->belongsTo(User::class); }
 public function dog() { return $this->belongsTo(Dog::class); }
 public function need() { return $this->belongsTo(Need::class); }
}
