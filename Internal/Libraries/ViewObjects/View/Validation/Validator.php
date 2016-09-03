<?php namespace ZN\ViewObjects\View;

use CallController;

class InternalValidator extends CallController implements ValidatorInterface
{
    //--------------------------------------------------------------------------------------------------------
    //
    // Author     : Ozan UYKUN <ozanbote@gmail.com>
    // Site       : www.znframework.com
    // License    : The MIT License
    // Telif Hakkı: Copyright (c) 2012-2016, znframework.com
    //
    //--------------------------------------------------------------------------------------------------------

    //--------------------------------------------------------------------------------------------------------
    // Phone
    //--------------------------------------------------------------------------------------------------------
    //
    // @param string $data
    // @param string $pattern = NULL
    //
    //--------------------------------------------------------------------------------------------------------
    public function phone(String $data, String $pattern = NULL) : Bool
    {
        if( $pattern !== NULL)
        {
            $phoneData = preg_replace('/([^\*])/', 'key:$1', $pattern);
            $phoneData = '/'.str_replace(['*', 'key:'], ['[0-9]', '\\'], $phoneData).'/';
        }
        else
        {
            $phoneData = '/\+*[0-9]{10,14}$/';
        }

        if( ! preg_match($phoneData, $data) )
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    //--------------------------------------------------------------------------------------------------------
    // Numeric
    //--------------------------------------------------------------------------------------------------------
    //
    // @param string $data
    //
    //--------------------------------------------------------------------------------------------------------
    public function numeric($data) : Bool
    {
        if( ! is_numeric($data) )
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    //--------------------------------------------------------------------------------------------------------
    // Alnum
    //--------------------------------------------------------------------------------------------------------
    //
    // @param string $data
    //
    //--------------------------------------------------------------------------------------------------------
    public function alnum(String $data) : Bool
    {
        if( ! preg_match('/^\w+$/',$data) )
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    //--------------------------------------------------------------------------------------------------------
    // Alpha
    //--------------------------------------------------------------------------------------------------------
    //
    // @param string $data
    //
    //--------------------------------------------------------------------------------------------------------
    public function alpha(String $data) : Bool
    {
        if( ! ctype_alpha($data) )
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    //--------------------------------------------------------------------------------------------------------
    // Identity
    //--------------------------------------------------------------------------------------------------------
    //
    // @param int $no
    //
    //--------------------------------------------------------------------------------------------------------
    public function identity($no) : Bool
    {
        if( ! is_numeric($no) || strlen($no) !== 11  )
        {
            return false;
        }

        $no = (string) $no;

        $numone     = ($no[0] + $no[2] + $no[4] + $no[6]  + $no[8]) * 7;
        $numtwo     = $no[1] + $no[3] + $no[5] + $no[7];
        $result     = $numone - $numtwo;
        $tenth      = $result%10;
        $total      = ($no[0] + $no[1] + $no[2] + $no[3] + $no[4] + $no[5] + $no[6] + $no[7] + $no[8] + $no[9]);
        $elewenth   = $total%10;

        if($no[0] == 0)
        {
            return false;
        }
        elseif($no[9] != $tenth)
        {
            return false;
        }
        elseif($no[10] != $elewenth)
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    //--------------------------------------------------------------------------------------------------------
    // Email
    //--------------------------------------------------------------------------------------------------------
    //
    // @param string $no
    //
    //--------------------------------------------------------------------------------------------------------
    public function email(String $data) : Bool
    {
        if( ! isEmail($data) )
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    //--------------------------------------------------------------------------------------------------------
    // URL
    //--------------------------------------------------------------------------------------------------------
    //
    // @param string $data
    //
    //--------------------------------------------------------------------------------------------------------
    public function url(String $data) : Bool
    {
        if( ! isUrl($data) )
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    //--------------------------------------------------------------------------------------------------------
    // Special Char
    //--------------------------------------------------------------------------------------------------------
    //
    // @param string $data
    //
    //--------------------------------------------------------------------------------------------------------
    public function specialChar(String $data) : Bool
    {
        if( ! preg_match('#[!\'^\#\\\+\$%&\/\(\)\[\]\{\}=\|\-\?:\.\,;_ĞÜŞİÖÇğüşıöç]+#', $data) )
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    //--------------------------------------------------------------------------------------------------------
    // Maxchar
    //--------------------------------------------------------------------------------------------------------
    //
    // @param string $data
    // @param int    $char
    //
    //--------------------------------------------------------------------------------------------------------
    public function maxchar(String $data, Int $char) : Bool
    {
        if( strlen($data) <= $char )
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    //--------------------------------------------------------------------------------------------------------
    // Minchar
    //--------------------------------------------------------------------------------------------------------
    //
    // @param string $data
    // @param int    $char
    //
    //--------------------------------------------------------------------------------------------------------
    public function minchar(String $data, Int $char) : Bool
    {
        if( strlen($data) >= $char )
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}
