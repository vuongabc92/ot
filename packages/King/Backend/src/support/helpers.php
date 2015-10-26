<?php

if ( ! function_exists('_t')) {

    /**
     * Translate the given message.
     *
     * @param  string  $id
     * @param  array   $parameters
     * @param  string  $domain
     * @param  string  $locale
     *
     * @return string
     */
    function _t($id = null, $parameters = [], $domain = 'backend', $locale = null) {
        return trans("backend::backend.{$id}", $parameters = [], $domain = 'backend', $locale = null);
    }

}

if ( ! function_exists('user')) {
    /**
     * Current authenticated user
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    function user() {
        if (auth()->check()) {
            return auth()->user();
        }

        return null;
    }
}



if ( ! function_exists('_const')) {
    /**
     * Get / set the specified configuration value.
     *
     * If an array is passed as the key, we will assume you want to set an array of values.
     *
     * @param  array|string  $key
     * @param  mixed         $default
     *
     * @return mixed
     */
    function _const($key = null, $default = null) {
        return config("constant.{$key}", $default);
    }

}

if ( ! function_exists('pong')) {

    /**
     * Return a new simple JSON response from the application.
     *
     * @param  string $status
     * @param  string $messages
     * @param  int    $status_code
     * @param  array  $headers
     * @param  int    $options
     *
     * @return \Illuminate\Http\JsonResponse
     */
    function pong($status, $messages, $status_code = 200, array $headers = [], $options = 0) {

        switch ($status) {

            case 0:
                $status_text = _const('AJAX_ERROR');
                break;

            case 1:
                $status_text = _const('AJAX_OK');
                break;

            default :
                $status_text = _t('UNDEFINED');
                break;
        }

        if (is_array($messages)) {
            $data = array_merge(['status'   => $status_text], $messages);
        } else {
            $data = [
                'status'   => $status_text,
                'messages' => $messages
            ];
        }

        return response()->json($data, $status_code, $headers, $options);
    }

}

if ( ! function_exists('file_pong')) {

    /**
     * Return a new JSON response from the application.
     *
     * @param  string|array  $data
     * @param  int           $status
     * @param  int           $options
     *
     * @return \Illuminate\Http\JsonResponse
     */
    function file_pong($data = [], $status = 200, $options = 0) {
        return response()->json($data, $status, ['Content-Type' => 'text/html'], $options);
    }

}

if ( ! function_exists('str_equal')) {

    /**
     * Compares two strings using a constant-time algorithm.
     *
     * Note: This method will leak length information.
     *
     * Note: Adapted from Symfony\Component\Security\Core\Util\StringUtils.
     *
     * @param  string  $knownString
     * @param  string  $userInput
     *
     * @return bool
     */
    function str_equal($knownString, $userInput) {
        return \Illuminate\Support\Str::equals($knownString, $userInput);
    }

}

if ( ! function_exists('remove_rules')) {

    /**
     * Remove one or many rules in a list of rules
     *
     * @param array        $rules       List of rules will be removed out
     * @param array|string $rulesRemove Rule to be found in $rules to remove
     *
     * @return array
     */
    function remove_rules($rules, $rulesRemove) {

        //Remove list rules
        if (is_array($rulesRemove) && count($rulesRemove)) {
            foreach ($rulesRemove as $one) {
                $rules = remove_rules($rules, $one);
            }

            return $rules;
        }

        /**
         * Remove rule string
         * 1. If rule contains dot "." then remove rule after dot for rule name
         *    before the dot.
         * 2. If rule doesn't contain dot then remove the rule name present
         *
         */
        if (is_string($rulesRemove)) {

            if (str_contains($rulesRemove, '.')) {
                $ruleInField = explode('.', $rulesRemove);
                if (isset($rules[$ruleInField[0]])) {
                    $ruleSplit = explode('|', $rules[$ruleInField[0]]);
                    $ruleFlip  = array_flip($ruleSplit);

                    if (isset($ruleFlip[$ruleInField[1]])) {
                        unset($ruleSplit[$ruleFlip[$ruleInField[1]]]);
                    }

                    //Remove the rule name if it contains no rule
                    if (count($ruleSplit)) {
                        $rules[$ruleInField[0]] = implode('|', $ruleSplit);
                    } else {
                        unset($rules[$ruleInField[0]]);
                    }
                }

            } elseif (isset($rules[$rulesRemove])) {
                unset($rules[$rulesRemove]);
            }

            return $rules;
        }

        return $rules;
    }

}

if ( ! function_exists('check_file')) {

    /**
     * Check does the present file exist
     *
     * @param string $file Path to file
     *
     * @return boolean
     */
    function check_file($file) {

        if ( ! is_dir($file) && file_exists($file)) {
            return true;
        }

        return false;
    }

}

if ( ! function_exists('delete_file')) {

    /**
     * Delete file
     *
     * @param string|array $file
     *
     * @return boolean
     *
     * @throws \Exception
     */
    function delete_file($file) {

        //Delete list of files
        if (is_array($file) && count($file)) {
            foreach ($file as $one) {
                delete_file($one);
            }

            return true;
        }

        if (check_file($file)) {
            try {
                \Illuminate\Support\Facades\File::delete($file);
            } catch (Exception $ex) {
                throw new \Exception('Whoop!! Can not delete file. ' . $ex->getMessage());
            }
        }

        return true;
    }

}

if ( ! function_exists('number_to_kmbt')) {

    /**
     * Format number to K or M or B or T
     * Such as:
     * + 1000 = 1k, 5500 = 5.5k, 1234 = 1.2k
     * + 1000000 = 1m
     * + 1000000000000 = 1b
     * + 1000000000000000 = 1t
     *
     * @param int $number
     *
     * @return string
     */
    function number_to_kmbt($number) {

        $numberRound  = $number;
        $numberFormat = number_format($numberRound);
        $numberSplit  = explode(',', $numberFormat);
        $formats      = array('k', 'm', 'b', 't');
        $display      = $numberSplit[0] . ((int) $numberSplit[1][0] !== 0 ? '.' . $numberSplit[1][0] : '');
        $display     .= $formats[count($numberSplit) - 2];

        return $display;
   }
}

if ( ! function_exists('nl2p')) {

    /**
     * Convert a string that contains new line (\n) character to paragraph (<p>)
     *
     * @param string  $string
     *
     * @return string
     */
    function nl2p($string) {

        return preg_replace('#\R+#', '</p><p>', $string);
    }
}

if ( ! function_exists('time_format')) {
    /**
     * Format time to some type
     *
     * @param string $time
     * @param string $format
     *
     * @return string
     */
    function time_format($time, $format) {

        $time = new \DateTime($time);

        return $time->format($format);
    }
}

if ( ! function_exists('error_or_label')) {

    /**
     * Show label or error message of validation form field
     *
     * @param string $label
     * @param string $error
     *
     * @return string
     */
    function error_or_label($label, $error) {

        $errors = Session::get('errors');

        if ($errors === null) {
            return $label;
        }

        $message = $errors->all->first($error);

        if ($message === '') {
            return $label;
        } else {
            return '<span class="_tr5">' . $message . '</span>';
        }
    }
}

if ( ! function_exists('nav_active')) {

    
    function nav_active($nav, $current, $class = 'active') {

        if ($nav === $current) {
            return $class;
        }
        
    }
}