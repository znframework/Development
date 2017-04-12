<?php namespace ZN\ViewObjects\View;

trait FormElementsTrait
{
    //--------------------------------------------------------------------------------------------------------
    //
    // Author     : Ozan UYKUN <ozanbote@gmail.com>
    // Site       : www.znframework.com
    // License    : The MIT License
    // Copyright  : (c) 2012-2016, znframework.com
    //
    //--------------------------------------------------------------------------------------------------------

    //--------------------------------------------------------------------------------------------------------
    // $enctypes
    //--------------------------------------------------------------------------------------------------------
    //
    // @var array
    //
    //--------------------------------------------------------------------------------------------------------
    protected $enctypes =
    [
        'multipart'     => 'multipart/form-data',
        'application'   => 'application/x-www-form-urlencoded',
        'text'          => 'text/plain'
    ];

    //--------------------------------------------------------------------------------------------------------
    // $postback
    //--------------------------------------------------------------------------------------------------------
    //
    // @var array
    //
    //--------------------------------------------------------------------------------------------------------
    protected $postback = [];

    //--------------------------------------------------------------------------------------------------------
    // postBack
    //--------------------------------------------------------------------------------------------------------
    //
    // @param bool $postback
    //
    //--------------------------------------------------------------------------------------------------------
    public function postBack(Bool $postback = true, String $type = 'post')
    {
        $this->postback['bool'] = $postback;
        $this->postback['type'] = $type;

        return $this;
    }

    //--------------------------------------------------------------------------------------------------------
    // csrf()
    //--------------------------------------------------------------------------------------------------------
    //
    // @param void
    //
    //--------------------------------------------------------------------------------------------------------
    public function csrf()
    {
        $this->settings['token'] = true;

        return $this;
    }

    //--------------------------------------------------------------------------------------------------------
    // excluding()
    //--------------------------------------------------------------------------------------------------------
    //
    // @param mixed $exclude
    //
    //--------------------------------------------------------------------------------------------------------
    public function excluding($exclude)
    {
        if( is_scalar($exclude) )
        {
            $exclude[] = $exclude;
        }

        $this->settings['exclude'] = $exclude;

        return $this;
    }

    //--------------------------------------------------------------------------------------------------------
    // including()
    //--------------------------------------------------------------------------------------------------------
    //
    // @param mixed $exclude
    //
    //--------------------------------------------------------------------------------------------------------
    public function including($include)
    {
        if( is_scalar($include) )
        {
            $include[] = $include;
        }

        $this->settings['include'] = $include;

        return $this;
    }

    //--------------------------------------------------------------------------------------------------------
    // query()
    //--------------------------------------------------------------------------------------------------------
    //
    // @param string $query
    //
    //--------------------------------------------------------------------------------------------------------
    public function query(String $query)
    {
        $this->settings['query'] = $query;

        return $this;
    }

    //--------------------------------------------------------------------------------------------------------
    // table()
    //--------------------------------------------------------------------------------------------------------
    //
    // @param string $table
    //
    //--------------------------------------------------------------------------------------------------------
    public function table(String $table)
    {
        $this->settings['table'] = $table;

        return $this;
    }

    //--------------------------------------------------------------------------------------------------------
    // order()
    //--------------------------------------------------------------------------------------------------------
    //
    // Arrays::order() yönteminde kullanılan type ve flags parametreleri aynen geçerlidir.
    //
    // @param string $type:desc
    // @param string $flags:regular
    //
    //--------------------------------------------------------------------------------------------------------
    public function order(String $type = 'desc', String $flags = 'regular')
    {
        $this->settings['order']['type']  = $type;
        $this->settings['order']['flags'] = $flags;

        return $this;
    }

    //--------------------------------------------------------------------------------------------------------
    // attr()
    //--------------------------------------------------------------------------------------------------------
    //
    // @param array $attr
    //
    //--------------------------------------------------------------------------------------------------------
    public function attr(Array $attr = [])
    {
        if( isset($this->settings['attr']) && is_array($this->settings['attr']) )
        {
            $settings = $this->settings['attr'];
        }
        else
        {
            $settings = [];
        }

        $this->settings['attr'] = array_merge($settings, $attr);

        return $this;
    }

    //--------------------------------------------------------------------------------------------------------
    // attr()
    //--------------------------------------------------------------------------------------------------------
    //
    // @param array $attr
    //
    //--------------------------------------------------------------------------------------------------------
    public function action(String $url = NULL)
    {
        $this->settings['attr']['action'] = isUrl($url) ? $url : siteUrl($url);

        return $this;
    }

    //--------------------------------------------------------------------------------------------------------
    // enctype()
    //--------------------------------------------------------------------------------------------------------
    //
    // @param  string $enctype
    // @return string
    //
    //--------------------------------------------------------------------------------------------------------
    public function enctype(String $enctype)
    {
        if( isset($this->enctypes[$enctype]) )
        {
            $enctype = $this->enctypes[$enctype];
        }

        $this->_element(__FUNCTION__, $enctype);

        return $this;
    }

    //--------------------------------------------------------------------------------------------------------
    // option()
    //--------------------------------------------------------------------------------------------------------
    //
    // @param mixed  $key
    // @param string $value
    //
    //--------------------------------------------------------------------------------------------------------
    public function option($key, String $value = NULL)
    {
        if( is_array($key) )
        {
            $this->settings['option'] = $key;
        }
        else
        {
            $this->settings['option'][$key] = $value;
        }

        return $this;
    }
}
