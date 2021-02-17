<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CModel extends Model
{
    use HasFactory;
    protected $fillable=[
            'name',
            'invoice_title',
            'c_name_v',
            'c_address_v',
            'c_tel_v',
            'c_country_v',
            'c_email_v',
            'cl_name_v',
            'cl_address_v',
            'cl_tel_v',
            'cl_country_v',
            'cl_email_v',
            'from_date',
            'to_date',
            'from_date_v',
            'to_date_v',
            'title_sp',
            'text1',
            'text1_v',
            'note1',
            'note2',
            'note3',
            'note4',
            'note1_v',
            'note2_v',
            'note3_v',
            'note4_v',
            'pdf_mr',
            'pdf_ml',
            'pdf_mt',
            'sp_gt_note',
            'sp_note_footer',
            'color_sheme',
            'wfrom_company',
            'wto_client',
            'wfrom_date',
            'wto_date',
            'witem_code',
            'wdescription',
            'wquantity',
            'wprice',
            'wamount',
            'wtotal',
            'woutstanding',
            'wgrandtotal',
            'wnote',
            'wamout_total',
            'wtotal_quantity',
            'winvoice_number',
            'rinvoice_number',
            'rquantity',
            'routstanding',
            'rgrandtotal',
            'spcr',
            'footer',
    ];
}