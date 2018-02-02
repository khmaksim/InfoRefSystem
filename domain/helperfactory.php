<?php
namespace domain;

// if ( ! isset( $EG_DISABLE_INCLUDES ) ) {
//     require_once( "mapper/VenueMapper.php" );
//     require_once( "mapper/SpaceMapper.php" );
//     require_once( "mapper/EventMapper.php" );
//     require_once( "mapper/Collections.php" );
// }

class HelperFactory {
	static function getFinder( $type ) {
        $type = preg_replace( '|^.*\\\|', "", $type );
        $mapper = "\\mapper\\{$type}Mapper";
        if ( class_exists( $mapper ) ) {
            return new $mapper();
        }
        throw new \base\AppException( "Unknown: $mapper" );
    }

    static function getCollection( $type ) {
        $type = preg_replace( '|^.*\\\|', "", $type );
        $collection = "\\mapper\\{$type}Collection";
        if ( class_exists( $collection ) ) {
            return new $collection();
        }
        throw new \base\AppException( "Unknown: $collection" );
    }
}
?>