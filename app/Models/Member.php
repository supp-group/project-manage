<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected  $fillable =['NotPad','branch','IDTeam','FullName',
    'MotherName','PlaceOfBirth','BirthDate','Constraint',
    'City','IDNumber','Gender','Qualification','Occupation','MobilePhone','HomeAddress',
    'WorkAddress','HomePhone','WorkPhone','DateOfJoin','Specialization','Image','user_id'];


public function users(): BelongsTo
{
    return $this->belongsTo(User::class);
}
}
