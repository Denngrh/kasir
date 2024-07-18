<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
 
class Member extends Model
{
    protected $tables = 'members';
    protected $guarded = [];
    protected $primaryKey = 'id_member';
    protected $fillable = ['nama_member', 'email', 'nomer_hp', 'alamat', 'diskon'];
}
 