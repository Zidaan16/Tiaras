<?php
namespace App\Controller;

/**
 * Controllers
 * Copyright 2024 Ahmad Zidan
 * 
 * Follow me :D
 * http://instagram.com/zidaaaaanz
 * 
 */

class Controllers {

    public function validate(array $data)
    {
        if (!empty($data)){
            foreach ($data as $key => $value) {
                $exp = explode('|', $value);
                if (!empty($exp[1]) || !empty($exp[2])){
                    if (!empty($exp2)) {
                        if ($exp[2] == 'nullable'){
                            if (empty($key))$key = 'null';
                            $length = explode(':', $exp[1]);
                            if ($length[0] == 'min' || $length[0] == 'max')$exp[1] = $length[0];
                            if ($exp[1] == 'nullable'){
                                if (empty($key))$key = 'null';
                            }elseif ($exp[1] == 'max') {
                                if (strlen($key) > $length[1]) return false;
                            }elseif ($exp[1] == 'min') {
                                if (strlen($key) < $length[1]) return false;
                            }else{
                                return false;
                            }
                        }else {
                            return false;
                        }
                    }else{
                        if (empty($key)) return false;
                        $length = explode(':', $exp[1]);
                        if ($length[0] == 'min' || $length[0] == 'max')$exp[1] = $length[0];
                        if ($exp[1] == 'nullable'){
                            if (empty($key))$key = 'null';
                        }elseif ($exp[1] == 'max') {
                            if (strlen($key) > $length[1]) return false;
                        }elseif ($exp[1] == 'min') {
                            if (strlen($key) < $length[1]) return false;
                        }else{
                            return false;
                        }
                    }
                }else {
                    if (!empty($key) && $key !== 'null'){
                        if ($exp[0] == 'string'){
                            return (is_string($key)) ? true : false;
                        }elseif ($exp[0] == 'integer') {
                            return (is_integer($key)) ? true : false;
                        }
                    }else {
                        return false;
                    }
                }
            }
        }else{
            return false;
        }
    }

}