<?php

namespace App\Models;

class CategoryTwo extends Base
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'category_two';

    /**
     * Validation rules
     *
     * @return array
     */
    public function rules() {
        return [
            'category_one_id' => 'required|exists:category_one,id',
            'name'            => 'required|max:250',
            'slug'            => 'max:250|unique:category_two,slug',
            'image'           => 'image',
        ];
    }

    /**
     * Validation rule messages
     *
     * @return array
     */
    public function messages() {
        return [
            'category_one_id.required' => _t('backend_ct_msg_coreq'),
            'category_one_id.exists'   => _t('backend_ct_msg_coexi'),
            'name.required'            => _t('backend_ct_msg_nareq'),
            'name.max'                 => _t('backend_ct_msg_namax'),
            'image.image'              => _t('backend_ct_msg_imgimage'),
        ];
    }

    /**
     * Category One
     *
     * @return App\Models\CategoryOne
     */
    public function categoryOne() {
        return $this->belongsTo('App\Models\CategoryOne');
    }
}
