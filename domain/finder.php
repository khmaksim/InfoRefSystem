<?php
namespace domain;

interface Finder {
    function find( $id );
    function findAll();

    function update( DomainObject $obj );
    function insert( DomainObject $obj );
    //function delete();
}

// interface SpaceFinder extends Finder { 
//     function findByVenue( $id );
// }

interface UserFinder extends Finder {}
?>
