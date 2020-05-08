<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Officialbills extends Model
{
  protected $guarded = [];

  protected $fillable = [
    'invoice_id', 'for_name', 'for_company', 'for_position', 'for_address', 
    'letter', 'billing_date', 'by_name', 'by_position', 'status', 'createdby_id', 'updatedby_id', 
  ];

  public function invoice(){
    return $this->hasOne('App\Invoices','id', 'invoice_id');
  }

}
