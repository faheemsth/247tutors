<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;
    protected $appends = ['doc_type_name'];

    protected $fillable = [
        'user_id',
        'doc_type',
        'file',
        'status',
        'description'
    ];

    public function getDocTypeNameAttribute(){
        $doc_type = $this->doc_type;
        $doc = DocumentType::where('id',$doc_type)->first();
        return $doc->title;
    }
}
