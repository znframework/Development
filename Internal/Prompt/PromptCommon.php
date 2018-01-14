<?php namespace ZN\Prompt;
/**
 * ZN PHP Web Framework
 * 
 * "Simplicity is the ultimate sophistication." ~ Da Vinci
 * 
 * @package ZN
 * @license MIT [http://opensource.org/licenses/MIT]
 * @author  Ozan UYKUN [ozan@znframework.com]
 */

use ZN\Config;
use ZN\Structure;
use ZN\DataTypes\Arrays;

class PromptCommon implements PromptCommonInterface
{
    //--------------------------------------------------------------------------------------------------------
    // Path
    //--------------------------------------------------------------------------------------------------------
    //
    // @var string
    //
    //--------------------------------------------------------------------------------------------------------
    protected $path;

    //--------------------------------------------------------------------------------------------------------
    // String Command
    //--------------------------------------------------------------------------------------------------------
    //
    // @var string
    //
    //--------------------------------------------------------------------------------------------------------
    protected $stringCommand;

    //--------------------------------------------------------------------------------------------------------
    // Command
    //--------------------------------------------------------------------------------------------------------
    //
    // @var string
    //
    //--------------------------------------------------------------------------------------------------------
    protected $command;

    /**
     * Magic Constructor
     */
    public function __construct()
    {
        $this->getConfig = Config::get('Services', 'processor');
    }

    //--------------------------------------------------------------------------------------------------------
    // Path
    //--------------------------------------------------------------------------------------------------------
    //
    // @param  string $path: empty
    // @return object
    //
    //--------------------------------------------------------------------------------------------------------
    public function path(String $path = NULL)
    {
        $this->path = $path;
        
        return $this;
    }

    //--------------------------------------------------------------------------------------------------------
    // String Command
    //--------------------------------------------------------------------------------------------------------
    //
    // @param void
    //
    //--------------------------------------------------------------------------------------------------------
    public function stringCommand() : String
    {
        return (string) $this->stringCommand;
    }

    //--------------------------------------------------------------------------------------------------------
    // Protected Controller
    //--------------------------------------------------------------------------------------------------------
    //
    // @param string $path
    //
    //--------------------------------------------------------------------------------------------------------
    protected function _controller($path)
    {
        $datas = Structure::data($path);

        $controller = $datas['page'];
        $function   = $datas['function'] ?? 'main';
        $namespace  = $datas['namespace'];
        $parameters = $datas['parameters'];
        $class      = $namespace . $controller;
        $file       = str_replace('\\', '\\\\', $datas['file']);
        $command    = 'import("'.$file.'"); uselib("'.$class.'")->'.$function.
        '('. 
            implode(',', array_map(function($data)
            { 
                return '"'.$data.'"';

            }, $parameters)).
        ')';

        return $command;
    }

    //--------------------------------------------------------------------------------------------------------
    // Protected Command
    //--------------------------------------------------------------------------------------------------------
    //
    // @param string $path
    //
    //--------------------------------------------------------------------------------------------------------
    protected function _commandFile($path)
    {
        $command = explode(':', $path);

        return '(new \Project\Commands\\'.$command[0].'")->'.$command[1].'()';
    }
}