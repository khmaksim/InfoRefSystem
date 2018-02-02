<?php
namespace controller;

require_once('command/Command.php');
require_once('command/DefaultCommand.php');

class AppController {
    private static $base_cmd=null;
    private static $default_cmd=null;
    private $controllerMap;
    private $invoked = array();

    function __construct( ControllerMap $map ) {
        $this->controllerMap = $map;
        if (is_null(self::$base_cmd)) {
            self::$base_cmd = new \ReflectionClass("\command\Command");
            self::$default_cmd = new \command\DefaultCommand();
        }
    }

    function reset() {
        $this->invoked = array();
    }

    function getView( Request $req ) {
        $view = $this->getResource($req, "View");
        return $view;
    }

    private function getForward(Request $req) {
        $forward = $this->getResource($req, "Forward");
        if ($forward) {
            $req->setProperty('cmd', $forward);
        }
        return $forward;
    }

    private function getResource(Request $req, $res) {
        $cmd_str = $req->getProperty('cmd');
        $previous = $req->getLastCommand();
        $status = $previous->getStatus();
        
        if (!isset($status) || !is_int($status)) { 
            $status = 0; 
        }

        $acquire = "get$res";
        $resource = $this->controllerMap->$acquire($cmd_str, $status);
        if (is_null($resource)) {
            $resource = $this->controllerMap->$acquire($cmd_str, 0);
        }
        if (is_null($resource)) {
            $resource = $this->controllerMap->$acquire('default', $status);
        }
        if (is_null($resource)) {
            $resource = $this->controllerMap->$acquire('default', 0);
        }
        return $resource;
    }

    function getCommand(Request $req) {
        $previous = $req->getLastCommand();

        if (is_null($previous)) {
            $cmd = $req->getProperty('cmd');
            if (is_null($cmd)) {
                $req->setProperty('cmd', 'default');
                return self::$default_cmd;
            }
        } 
        else {
            $cmd = $this->getForward($req);
            if (is_null($cmd)) { 
                return null; 
            }
        }

        $cmd_obj = $this->resolveCommand( $cmd );
        if (is_null($cmd_obj)) {
            throw new \base\AppException( "couldn't resolve '$cmd'" ); 
        }
        $cmd_class = get_class( $cmd_obj );
        if (isset($this->invoked[$cmd_class])) {
            throw new \base\AppException( "circular forwarding" );
        }
        $this->invoked[$cmd_class]=1;
        return $cmd_obj;
    }

    function resolveCommand( $cmd ) {
        $classroot = $this->controllerMap->getClassroot($cmd);
        $filepath = "command/$classroot.php";
        $classname = "\\command\\$classroot";
        if (file_exists($filepath)) {
            require_once($filepath);
            if ( class_exists( $classname) ) {
                $cmd_class = new \ReflectionClass($classname);
                if ( $cmd_class->isSubClassOf( self::$base_cmd ) ) {
                    return $cmd_class->newInstance();
                }
            }
        }
        return null;
    }
}

class ControllerMap {
    private $viewMap = array();
    private $forwardMap = array();
    private $classrootMap = array();

    function addClassroot( $command, $classroot ) {
        $this->classrootMap[$command]=$classroot;
    }

    function getClassroot( $command ) {
        if ( isset( $this->classrootMap[$command] ) ) {
            return $this->classrootMap[$command];
        }
        return $command;
    }

    function addView( $view, $command='default', $status=0 ) {
        $this->viewMap[$command][$status]=$view;
    }

    function getView( $command, $status ) {
        if (isset( $this->viewMap[$command][$status] ) ) {
            return $this->viewMap[$command][$status];
        }
        return null;
    }

    function addForward( $command, $status=0, $newCommand ) {
        $this->forwardMap[$command][$status]=$newCommand;
    }

    function getForward( $command, $status ) {
        if ( isset( $this->forwardMap[$command][$status] ) ) {
            return $this->forwardMap[$command][$status];
        }
        return null;
    }
}
?>
