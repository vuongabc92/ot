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
