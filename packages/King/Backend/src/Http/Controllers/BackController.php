<?php

/**
 * BackController
 *
 * @author vuongabc92@gmail.com
 */

namespace King\Backend\Http\Controllers;

use App\Http\Controllers\Controller;

/**
 * Back Controller
 */
class BackController extends Controller
{
    /**
     * Binding
     *
     * @param object $entity Entity to be bind data from user form
     * @param array  $fields Form data
     * @param array  $except Fields that won't be set data
     *
     * @return type
     */
    public function bind($entity, $fields, $except = []) {

        $except += config('back.except_fields');
        $bcryptFields = config('back.bcrypt_fields');

        foreach($fields as $fieldName => $fieldData) {

            if ( ! in_array($fieldName, $except)) {
                $entity->$fieldName = (in_array($fieldName, $bcryptFields)) ? bcrypt($fieldData) : $fieldData;
            }
        }

        return $entity;
    }
}
