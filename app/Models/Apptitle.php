<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apptitle extends Model
{
    use HasFactory;

    protected $fillable = [
        'searchtitle',
        'searchsub',
        'featuretitle',
        'featuresub',
        'testimonialtitle',
        'testimonialsub',
        'faqtitle',
        'faqsub',
        'articletitle',
        'articlesub',
        'image',
        'image1',
        'image2',
        'image3',
        'image4',
        'title',
        'checkbox',
        'featurecheck',
        'testimonialcheck',
        'faqcheck',
        'articlecheck'
    ];
}
