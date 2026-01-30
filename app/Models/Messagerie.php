<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Messagerie extends Model
{
    protected $table = 'contact'; // Spécifie le nom de la table si ce n'est pas "members" (par défaut Laravel devine à partir du nom du modèle)
    protected $fillable = ['name', 'email', 'message', 'ip', 'datetime']; // autoriser les champs à l’insertion
    public $timestamps = false;

}
