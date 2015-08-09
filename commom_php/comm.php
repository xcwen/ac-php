/* Local Variables: */
/*  (setq ac-php-comm-tags-data-list nil ) */
/*  End: */


<?php

class SplDoublyLinkedList implements Iterator , ArrayAccess , Countable {
    /* 方法 */
    public  function __construct(){}
    /** @return void */
    public  function add( mixed $index , mixed $newval ){} 
    /** @return mixed */
    public  function bottom(){} 
    /** @return int */
    public  function count(){} 
    /** @return mixed */
    public  function current(){} 
    /** @return int */
    public  function getIteratorMode(){} 
    /** @return bool */
    public  function isEmpty(){} 
    /** @return mixed */
    public  function key(){} 
    /** @return void */
    public  function next(){} 
    /** @return bool */
    public  function offsetExists( mixed $index ){} 
    /** @return mixed */
    public  function offsetGet( mixed $index ){} 
    /** @return void */
    public  function offsetSet( mixed $index , mixed $newval ){} 
    /** @return void */
    public  function offsetUnset( mixed $index ){} 
    /** @return mixed */
    public  function pop(){} 
    /** @return void */
    public  function prev(){} 
    /** @return void */
    public  function push( mixed $value ){} 
    /** @return void */
    public  function rewind(){} 
    /** @return string */
    public  function serialize(){} 
    /** @return void */
    public  function setIteratorMode( int $mode ){} 
    /** @return mixed */
    public  function shift(){} 
    /** @return mixed */
    public  function top(){} 
    /** @return void */
    public  function unserialize( string $serialized ){} 
    /** @return void */
    public  function unshift( mixed $value ){} 
    /** @return bool */
    public  function valid(){} 
}

class SplStack extends SplDoublyLinkedList implements Iterator , ArrayAccess , Countable {
    /* 方法 */
    function __construct(){}
    /** @return void */
    function setIteratorMode( int $mode ){} 
}

class SplQueue extends SplDoublyLinkedList implements Iterator , ArrayAccess , Countable {
    /* 方法 */
    function __construct(){}
    /** @return mixed */
    function dequeue(){} 
    /** @return void */
    function enqueue( mixed $value ){} 
    /** @return void */
    function setIteratorMode( int $mode ){} 
}
abstract class  SplHeap implements Iterator , Countable {
    /* 方法 */
    public  function __construct(){}
    /** @return protected */
    abstract  function compare( mixed $value1 , mixed $value2 ); 
    /** @return int */
    public  function count(){} 
    /** @return mixed */
    public  function current(){} 
    /** @return mixed */
    public  function extract(){} 
    /** @return void */
    public  function insert( mixed $value ){} 
    /** @return bool */
    public  function isEmpty(){} 
    /** @return mixed */
    public  function key(){} 
    /** @return void */
    public  function next(){} 
    /** @return void */
    public  function recoverFromCorruption(){} 
    /** @return void */
    public  function rewind(){} 
    /** @return mixed */
    public  function top(){} 
    /** @return bool */
    public  function valid(){} 
}

class SplMaxHeap extends SplHeap implements Iterator , Countable {
    /* 方法 */
    /** @return int */
    protected  function compare( mixed $value1 , mixed $value2 ){} 
}

class SplMinHeap extends SplHeap implements Iterator , Countable {
    /* 方法 */
    /** @return int */
    protected  function compare( mixed $value1 , mixed $value2 ){} 
}

class SplPriorityQueue implements Iterator , Countable {
    /* 方法 */
    public  function __construct(){}
    /** @return int */
    public  function compare( mixed $priority1 , mixed $priority2 ){} 
    /** @return int */
    public  function count(){} 
    /** @return mixed */
    public  function current(){} 
    /** @return mixed */
    public  function extract(){} 
    /** @return void */
    public  function insert( mixed $value , mixed $priority ){} 
    /** @return bool */
    public  function isEmpty(){} 
    /** @return mixed */
    public  function key(){} 
    /** @return void */
    public  function next(){} 
    /** @return void */
    public  function recoverFromCorruption(){} 
    /** @return void */
    public  function rewind(){} 
    /** @return void */
    public  function setExtractFlags( int $flags ){} 
    /** @return mixed */
    public  function top(){} 
    /** @return bool */
    public  function valid(){} 
}
class SplFixedArray implements Iterator , ArrayAccess , Countable {
    /* 方法 */
    public  function __construct( int $size = 0  ){}
    /** @return int */
    public  function count(){} 
    /** @return mixed */
    public  function current(){} 
    /** @return SplFixedArray */
    public static  function fromArray( array $array , bool $save_indexes = true  ){} 
    /** @return int */
    public  function getSize(){} 
    /** @return int */
    public  function key(){} 
    /** @return void */
    public  function next(){} 
    /** @return bool */
    public  function offsetExists( int $index ){} 
    /** @return mixed */
    public  function offsetGet( int $index ){} 
    /** @return void */
    public  function offsetSet( int $index , mixed $newval ){} 
    /** @return void */
    public  function offsetUnset( int $index ){} 
    /** @return void */
    public  function rewind(){} 
    /** @return int */
    public  function setSize( int $size ){} 
    /** @return array */
    public  function toArray(){} 
    /** @return bool */
    public  function valid(){} 
    /** @return void */
    public  function __wakeup(){} 
}

class SplObjectStorage implements Countable , Iterator , Serializable , ArrayAccess {
    /* 方法 */
	/** @return void */
	public  function addAll( SplObjectStorage $storage ){} 
	/** @return void */
	public  function attach( object $object , mixed $data = NULL  ){} 
	/** @return bool */
	public  function contains( object $object ){} 
	/** @return int */
	public  function count(){} 
	/** @return object */
	public  function current(){} 
	/** @return void */
	public  function detach( object $object ){} 
	/** @return string */
	public  function getHash( object $object ){} 
	/** @return mixed */
	public  function getInfo(){} 
	/** @return int */
	public  function key(){} 
	/** @return void */
	public  function next(){} 
	/** @return bool */
	public  function offsetExists( object $object ){} 
	/** @return mixed */
	public  function offsetGet( object $object ){} 
	/** @return void */
	public  function offsetSet( object $object , mixed $data = NULL  ){} 
	/** @return void */
	public  function offsetUnset( object $object ){} 
	/** @return void */
	public  function removeAll( SplObjectStorage $storage ){} 
	/** @return void */
	public  function removeAllExcept( SplObjectStorage $storage ){} 
	/** @return void */
	public  function rewind(){} 
	/** @return string */
	public  function serialize(){} 
	/** @return void */
	public  function setInfo( mixed $data ){} 
	/** @return void */
	public  function unserialize( string $serialized ){} 
	/** @return bool */
	public  function valid(){} 
}
class IteratorIterator implements OuterIterator {
    /* 方法 */
	public  function __construct( Traversable $iterator ){}
	/** @return mixed */
	public  function current(){} 
	/** @return Traversable */
	public  function getInnerIterator(){} 
	/** @return scalar */
	public  function key(){} 
	/** @return void */
	public  function next(){} 
	/** @return void */
	public  function rewind(){} 
	/** @return bool */
	public  function valid(){} 
}

class OuterIterator extends Iterator {
	/** @return Iterator */
	public  function getInnerIterator(){} 
}

class ArrayIterator implements ArrayAccess , SeekableIterator , Countable , Serializable {
    /* 方法 */
	/** @return void */
	public  function append( mixed $value ){} 
	/** @return void */
	public  function asort(){} 
	/** @return void */
	public  function __construct( mixed $array = array() , int $flags = 0  ){} 
	/** @return int */
	public  function count(){} 
	/** @return mixed */
	public  function current(){} 
	/** @return array */
	public  function getArrayCopy(){} 
	/** @return void */
	public  function getFlags(){} 
	/** @return mixed */
	public  function key(){} 
	/** @return void */
	public  function ksort(){} 
	/** @return void */
	public  function natcasesort(){} 
	/** @return void */
	public  function natsort(){} 
	/** @return void */
	public  function next(){} 
	/** @return void */
	public  function offsetExists( string $index ){} 
	/** @return mixed */
	public  function offsetGet( string $index ){} 
	/** @return void */
	public  function offsetSet( string $index , string $newval ){} 
	/** @return void */
	public  function offsetUnset( string $index ){} 
	/** @return void */
	public  function rewind(){} 
	/** @return void */
	public  function seek( int $position ){} 
	/** @return string */
	public  function serialize(){} 
	/** @return void */
	public  function setFlags( string $flags ){} 
	/** @return void */
	public  function uasort( string $cmp_function ){} 
	/** @return void */
	public  function uksort( string $cmp_function ){} 
	/** @return string */
	public  function unserialize( string $serialized ){} 
	/** @return bool */
	public  function valid(){} 
}

abstract  class SeekableIterator extends Iterator {
    /* 方法 */
	/** @return void */
	abstract public  function seek( int $position ); 
}

class ArrayIterator implements ArrayAccess , SeekableIterator , Countable , Serializable {
    /* 方法 */
	/** @return void */
	public  function append( mixed $value ){} 
	/** @return void */
	public  function asort(){} 
	/** @return void */
	public  function __construct( mixed $array = array() , int $flags = 0  ){} 
	/** @return int */
	public  function count(){} 
	/** @return mixed */
	public  function current(){} 
	/** @return array */
	public  function getArrayCopy(){} 
	/** @return void */
	public  function getFlags(){} 
	/** @return mixed */
	public  function key(){} 
	/** @return void */
	public  function ksort(){} 
	/** @return void */
	public  function natcasesort(){} 
	/** @return void */
	public  function natsort(){} 
	/** @return void */
	public  function next(){} 
	/** @return void */
	public  function offsetExists( string $index ){} 
	/** @return mixed */
	public  function offsetGet( string $index ){} 
	/** @return void */
	public  function offsetSet( string $index , string $newval ){} 
	/** @return void */
	public  function offsetUnset( string $index ){} 
	/** @return void */
	public  function rewind(){} 
	/** @return void */
	public  function seek( int $position ){} 
	/** @return string */
	public  function serialize(){} 
	/** @return void */
	public  function setFlags( string $flags ){} 
	/** @return void */
	public  function uasort( string $cmp_function ){} 
	/** @return void */
	public  function uksort( string $cmp_function ){} 
	/** @return string */
	public  function unserialize( string $serialized ){} 
	/** @return bool */
	public  function valid(){} 
}
class CachingIterator extends IteratorIterator implements OuterIterator , ArrayAccess , Countable {
    /* 常量 */
	/**@var integer */
    const CALL_TOSTRING = 1 ;
	/**@var integer */
    const CATCH_GET_CHILD = 16 ;
	/**@var integer */
    const TOSTRING_USE_KEY = 2 ;
	/**@var integer */
    const TOSTRING_USE_CURRENT = 4 ;
	/**@var integer */
    const TOSTRING_USE_INNER = 8 ;
	/**@var integer */
    const FULL_CACHE = 256 ;
    /* 方法 */
	/** @return void */
	public  function __construct( Iterator $iterator , string $flags = self::CALL_TOSTRING  ){} 
	/** @return int */
	public  function count(){} 
	/** @return void */
	public  function current(){} 
	/** @return array */
	public  function getCache(){} 
	/** @return void */
	public  function getFlags(){} 
	/** @return Iterator */
	public  function getInnerIterator(){} 
	/** @return void */
	public  function hasNext(){} 
	/** @return scalar */
	public  function key(){} 
	/** @return void */
	public  function next(){} 
	/** @return void */
	public  function offsetExists( string $index ){} 
	/** @return void */
	public  function offsetGet( string $index ){} 
	/** @return void */
	public  function offsetSet( string $index , string $newval ){} 
	/** @return void */
	public  function offsetUnset( string $index ){} 
	/** @return void */
	public  function rewind(){} 
	/** @return void */
	public  function setFlags( bitmask $flags ){} 
	/** @return void */
	public  function __toString(){} 
	/** @return void */
	public  function valid(){} 
}
class CallbackFilterIterator extends FilterIterator implements OuterIterator {
    /* 方法 */
	/** @return void */
	public  function __construct( Iterator $iterator , callable $callback ){} 
	/** @return string */
	public  function accept(){} 
}


class DirectoryIterator extends SplFileInfo implements SeekableIterator {
    /* 方法 */
	/** @return void */
	public  function __construct( string $path ){} 
	/** @return DirectoryIterator */
	public  function current(){} 
	/** @return int */
	public  function getATime(){} 
	/** @return string */
	public  function getBasename( string $suffix  ){} 
	/** @return int */
	public  function getCTime(){} 
	/** @return string */
	public  function getExtension(){} 
	/** @return string */
	public  function getFilename(){} 
	/** @return int */
	public  function getGroup(){} 
	/** @return int */
	public  function getInode(){} 
	/** @return int */
	public  function getMTime(){} 
	/** @return int */
	public  function getOwner(){} 
	/** @return string */
	public  function getPath(){} 
	/** @return string */
	public  function getPathname(){} 
	/** @return int */
	public  function getPerms(){} 
	/** @return int */
	public  function getSize(){} 
	/** @return string */
	public  function getType(){} 
	/** @return bool */
	public  function isDir(){} 
	/** @return bool */
	public  function isDot(){} 
	/** @return bool */
	public  function isExecutable(){} 
	/** @return bool */
	public  function isFile(){} 
	/** @return bool */
	public  function isLink(){} 
	/** @return bool */
	public  function isReadable(){} 
	/** @return bool */
	public  function isWritable(){} 
	/** @return string */
	public  function key(){} 
	/** @return void */
	public  function next(){} 
	/** @return void */
	public  function rewind(){} 
	/** @return void */
	public  function seek( int $position ){} 
	/** @return string */
	public  function __toString(){} 
	/** @return bool */
	public  function valid(){} 
}

class EmptyIterator implements Iterator {
    /* 方法 */
	/** @return void */
	public  function current(){} 
	/** @return void */
	public  function key(){} 
	/** @return void */
	public  function next(){} 
	/** @return void */
	public  function rewind(){} 
	/** @return void */
	public  function valid(){} 
}
class FilesystemIterator extends DirectoryIterator implements SeekableIterator {
    /* 常量 */
	/** @var integer */
    const CURRENT_AS_PATHNAME = 32 ;
	/** @var integer */
    const CURRENT_AS_FILEINFO = 0 ;
	/** @var integer */
    const CURRENT_AS_SELF = 16 ;
	/** @var integer */
    const CURRENT_MODE_MASK = 240 ;
	/** @var integer */
    const KEY_AS_PATHNAME = 0 ;
	/** @var integer */
    const KEY_AS_FILENAME = 256 ;
	/** @var integer */
    const FOLLOW_SYMLINKS = 512 ;
	/** @var integer */
    const KEY_MODE_MASK = 3840 ;
	/** @var integer */
    const NEW_CURRENT_AND_KEY = 256 ;
	/** @var integer */
    const SKIP_DOTS = 4096 ;
	/** @var integer */
    const UNIX_PATHS = 8192 ;
    /* 方法 */
	/** @return void */
	public  function __construct( string $path , int $flags = FilesystemIterator::KEY_AS_PATHNAME | FilesystemIterator::CURRENT_AS_FILEINFO | FilesystemIterator::SKIP_DOTS  ){} 
	/** @return mixed */
	public  function current(){} 
	/** @return int */
	public  function getFlags(){} 
	/** @return string */
	public  function key(){} 
	/** @return void */
	public  function next(){} 
	/** @return void */
	public  function rewind(){} 
	/** @return void */
	public  function setFlags( int $flags  ){} 
}
abstract class FilterIterator extends IteratorIterator implements OuterIterator {
    /* 方法 */
	/** @return bool */
	public abstract  function accept(); 
	/** @return void */
	public  function __construct( Iterator $iterator ){} 
	/** @return mixed */
	public  function current(){} 
	/** @return Iterator */
	public  function getInnerIterator(){} 
	/** @return mixed */
	public  function key(){} 
	/** @return void */
	public  function next(){} 
	/** @return void */
	public  function rewind(){} 
	/** @return bool */
	public  function valid(){} 
}
class GlobIterator extends FilesystemIterator implements SeekableIterator , Countable {
    /* 方法 */
	/** @return void */
	public  function __construct( string $path , int $flags = FilesystemIterator::KEY_AS_PATHNAME | FilesystemIterator::CURRENT_AS_FILEINFO  ){} 
	/** @return int */
	public  function count(){} 
}
class InfiniteIterator extends IteratorIterator implements OuterIterator {
    /* 方法 */
	/** @return void */
	public  function __construct( Iterator $iterator ){} 
	/** @return void */
	public  function next(){} 
}
class IteratorIterator implements OuterIterator {
    /* 方法 */
	/** @return void */
	public  function __construct( Traversable $iterator ){} 
	/** @return mixed */
	public  function current(){} 
	/** @return Traversable */
	public  function getInnerIterator(){} 
	/** @return scalar */
	public  function key(){} 
	/** @return void */
	public  function next(){} 
	/** @return void */
	public  function rewind(){} 
	/** @return bool */
	public  function valid(){} 
}
class LimitIterator extends IteratorIterator implements OuterIterator {
    /* 方法 */
	/** @return void */
	public  function __construct( Iterator $iterator , int $offset = 0 , int $count = -1  ){} 
	/** @return mixed */
	public  function current(){} 
	/** @return Iterator */
	public  function getInnerIterator(){} 
	/** @return int */
	public  function getPosition(){} 
	/** @return mixed */
	public  function key(){} 
	/** @return void */
	public  function next(){} 
	/** @return void */
	public  function rewind(){} 
	/** @return int */
	public  function seek( int $position ){} 
	/** @return bool */
	public  function valid(){} 
}
class MultipleIterator implements Iterator {
    /* 常量 */
	/** @var integer */
    const MIT_NEED_ANY = 0 ;
	/** @var integer */
    const MIT_NEED_ALL = 1 ;
	/** @var integer */
    const MIT_KEYS_NUMERIC = 0 ;
	/** @var integer */
    const MIT_KEYS_ASSOC = 2 ;
    /* 方法 */
	/** @return void */
	public  function __construct( int $flags = MultipleIterator::MIT_NEED_ALL|MultipleIterator::MIT_KEYS_NUMERIC  ){} 
	/** @return void */
	public  function attachIterator( Iterator $iterator , string $infos  ){} 
	/** @return void */
	public  function containsIterator( Iterator $iterator ){} 
	/** @return void */
	public  function countIterators(){} 
	/** @return array */
	public  function current(){} 
	/** @return void */
	public  function detachIterator( Iterator $iterator ){} 
	/** @return void */
	public  function getFlags(){} 
	/** @return array */
	public  function key(){} 
	/** @return void */
	public  function next(){} 
	/** @return void */
	public  function rewind(){} 
	/** @return void */
	public  function setFlags( int $flags ){} 
	/** @return void */
	public  function valid(){} 
}
class NoRewindIterator extends IteratorIterator {
    /* 方法 */
	/** @return void */
	public  function __construct( Iterator $iterator ){} 
	/** @return mixed */
	public  function current(){} 
	/** @return iterator */
	public  function getInnerIterator(){} 
	/** @return mixed */
	public  function key(){} 
	/** @return void */
	public  function next(){} 
	/** @return void */
	public  function rewind(){} 
	/** @return bool */
	public  function valid(){} 
}
class ParentIterator extends RecursiveFilterIterator implements RecursiveIterator , OuterIterator {
    /* 方法 */
	/** @return bool */
	public  function accept(){} 
	/** @return void */
	public  function __construct( RecursiveIterator $iterator ){} 
	/** @return ParentIterator */
	public  function getChildren(){} 
	/** @return bool */
	public  function hasChildren(){} 
	/** @return void */
	public  function next(){} 
	/** @return void */
	public  function rewind(){} 
}

class RecursiveArrayIterator extends ArrayIterator implements RecursiveIterator {
    /* 方法 */
	/** @return RecursiveArrayIterator */
	public  function getChildren(){} 
	/** @return bool */
	public  function hasChildren(){} 
}
class RecursiveCachingIterator extends CachingIterator implements Countable , ArrayAccess , OuterIterator , RecursiveIterator {
    /* 方法 */
	/** @return void */
	public  function __construct( Iterator $iterator , string $flags = self::CALL_TOSTRING  ){} 
	/** @return RecursiveCachingIterator */
	public  function getChildren(){} 
	/** @return bool */
	public  function hasChildren(){} 
}
class RecursiveCallbackFilterIterator extends CallbackFilterIterator implements OuterIterator , RecursiveIterator {
    /* 方法 */
	/** @return void */
	public  function __construct( RecursiveIterator $iterator , string $callback ){} 
	/** @return RecursiveCallbackFilterIterator */
	public  function getChildren(){} 
	/** @return void */
	public  function hasChildren(){} 
}
class RecursiveDirectoryIterator extends FilesystemIterator implements SeekableIterator , RecursiveIterator {
    /* 方法 */
	/** @return void */
	public  function __construct( string $path , int $flags = FilesystemIterator::KEY_AS_PATHNAME | FilesystemIterator::CURRENT_AS_FILEINFO  ){} 
	/** @return mixed */
	public  function getChildren(){} 
	/** @return string */
	public  function getSubPath(){} 
	/** @return string */
	public  function getSubPathname(){} 
	/** @return bool */
	public  function hasChildren( bool $allow_links = false  ){} 
	/** @return string */
	public  function key(){} 
	/** @return void */
	public  function next(){} 
	/** @return void */
	public  function rewind(){} 
}

abstract class RecursiveFilterIterator extends FilterIterator implements OuterIterator , RecursiveIterator {
    /* 方法 */
	/** @return void */
	public  function __construct( RecursiveIterator $iterator ){} 
	/** @return RecursiveFilterIterator */
	public  function getChildren(){} 
	/** @return bool */
	public  function hasChildren(){} 
}

class RecursiveIteratorIterator implements OuterIterator {
    /* Constants */
	/** @var integer */
    const LEAVES_ONLY = 0 ;
	/** @var integer */
    const SELF_FIRST = 1 ;
	/** @var integer */
    const CHILD_FIRST = 2 ;
	/** @var integer */
    const CATCH_GET_CHILD = 16 ;
    /* 方法 */
	/** @return void */
	public  function beginChildren(){} 
	/** @return void */
	public  function beginIteration(){} 
	/** @return RecursiveIterator */
	public  function callGetChildren(){} 
	/** @return bool */
	public  function callHasChildren(){} 
	/** @return void */
	public  function __construct( Traversable $iterator , int $mode = RecursiveIteratorIterator::LEAVES_ONLY , int $flags = 0  ){} 
	/** @return mixed */
	public  function current(){} 
	/** @return void */
	public  function endChildren(){} 
	/** @return void */
	public  function endIteration(){} 
	/** @return int */
	public  function getDepth(){} 
	/** @return iterator */
	public  function getInnerIterator(){} 
	/** @return mixed */
	public  function getMaxDepth(){} 
	/** @return RecursiveIterator */
	public  function getSubIterator( int $level  ){} 
	/** @return mixed */
	public  function key(){} 
	/** @return void */
	public  function next(){} 
	/** @return void */
	public  function nextElement(){} 
	/** @return void */
	public  function rewind(){} 
	/** @return void */
	public  function setMaxDepth( string $max_depth = -1  ){} 
	/** @return bool */
	public  function valid(){} 
}

class RecursiveRegexIterator extends RegexIterator implements RecursiveIterator {
    /* 方法 */
	/** @return void */
	public  function __construct( RecursiveIterator $iterator , string $regex , int $mode = self::MATCH , int $flags = 0 , int $preg_flags = 0  ){} 
	/** @return RecursiveRegexIterator */
	public  function getChildren(){} 
	/** @return bool */
	public  function hasChildren(){} 
}
class RecursiveTreeIterator extends RecursiveIteratorIterator implements OuterIterator {
    /* 常量 */
	/** @var integer */
    const BYPASS_CURRENT = 4 ;
	/** @var integer */
    const BYPASS_KEY = 8 ;
	/** @var integer */
    const PREFIX_LEFT = 0 ;
	/** @var integer */
    const PREFIX_MID_HAS_NEXT = 1 ;
	/** @var integer */
    const PREFIX_MID_LAST = 2 ;
	/** @var integer */
    const PREFIX_END_HAS_NEXT = 3 ;
	/** @var integer */
    const PREFIX_END_LAST = 4 ;
	/** @var integer */
    const PREFIX_RIGHT = 5 ;
    /* 方法 */
	/** @return void */
	public  function beginChildren(){} 
	/** @return RecursiveIterator */
	public  function beginIteration(){} 
	/** @return RecursiveIterator */
	public  function callGetChildren(){} 
	/** @return bool */
	public  function callHasChildren(){} 
	/** @return void */
	public  function __construct( RecursiveIterator_IteratorAggregate $it , int $flags = RecursiveTreeIterator::BYPASS_KEY , int $cit_flags = CachingIterator::CATCH_GET_CHILD , int $mode = RecursiveIteratorIterator::SELF_FIRST  ){} 
	/** @return string */
	public  function current(){} 
	/** @return void */
	public  function endChildren(){} 
	/** @return void */
	public  function endIteration(){} 
	/** @return string */
	public  function getEntry(){} 
	/** @return void */
	public  function getPostfix(){} 
	/** @return string */
	public  function getPrefix(){} 
	/** @return string */
	public  function key(){} 
	/** @return void */
	public  function next(){} 
	/** @return void */
	public  function nextElement(){} 
	/** @return void */
	public  function rewind(){} 
	/** @return void */
	public  function setPrefixPart( int $part , string $value ){} 
	/** @return bool */
	public  function valid(){} 
}
class RegexIterator extends FilterIterator {
    /* 常量 */
	/** @var integer */
    const MATCH = 0 ;
	/** @var integer */
    const GET_MATCH = 1 ;
	/** @var integer */
    const ALL_MATCHES = 2 ;
	/** @var integer */
    const SPLIT = 3 ;
	/** @var integer */
    const REPLACE = 4 ;
	/** @var integer */
    const USE_KEY = 1 ;
    /* 方法 */
	/** @return void */
	public  function __construct( Iterator $iterator , string $regex , int $mode = self::MATCH , int $flags = 0 , int $preg_flags = 0  ){} 
	/** @return bool */
	public  function accept(){} 
	/** @return int */
	public  function getFlags(){} 
	/** @return int */
	public  function getMode(){} 
	/** @return int */
	public  function getPregFlags(){} 
	/** @return string */
	public  function getRegex(){} 
	/** @return void */
	public  function setFlags( int $flags ){} 
	/** @return void */
	public  function setMode( int $mode ){} 
	/** @return void */
	public  function setPregFlags( int $preg_flags ){} 
}

interface RecursiveIterator extends Iterator {
    /* 方法 */
	/** @return RecursiveIterator */
	public  function getChildren() ;
	/** @return bool */
	public  function hasChildren() ;
}


interface Countable {
	/** @return int */
	abstract public  function count(); 
}

interface OuterIterator extends Iterator {
    /* 方法 */
	/** @return Iterator */
	public  function getInnerIterator();
}

interface SeekableIterator extends Iterator {
    /* 方法 */
	/** @return void */
	abstract public  function seek( int $position ); 
}
interface Iterator extends Traversable {
    /* Methods */
	/** @return mixed */
	abstract public  function current(); 
	/** @return scalar */
	abstract public  function key(); 
	/** @return void */
	abstract public  function next(); 
	/** @return void */
	abstract public  function rewind(); 
	/** @return boolean */
	abstract public  function valid(); 
}

interface Traversable {
}

class Exception {
    /* 属性 */
	/** @var string */
    protected  $message ;
	/** @var int */
    protected  $code ;
	/** @var string */
    protected  $file ;
	/** @var int */
    protected  $line ;
    /* 方法 */
	/** @return void */
	public  function __construct( string $message = "" , int $code = 0 , Exception $previous = NULL  ){} 
	/** @return string */
	final public  function getMessage(){} 
	/** @return Exception */
	final public  function getPrevious(){} 
	/** @return int */
	final public  function getCode(){} 
	/** @return string */
	final public  function getFile(){} 
	/** @return int */
	final public  function getLine(){} 
	/** @return array */
	final public  function getTrace(){} 
	/** @return string */
	final public  function getTraceAsString(){} 
	/** @return string */
	public  function __toString(){} 
	/** @return private */
	final  function __clone(){} 
}

class LogicException extends Exception {
    
}

class BadFunctionCallException extends LogicException {
    
}
class BadMethodCallException extends BadFunctionCallException {}
class DomainException extends LogicException {}
class  InvalidArgumentException extends LogicException  {}
class  LengthException extends LogicException  {}

class OutOfBoundsException extends RuntimeException {}
class OutOfRangeException extends LogicException { }
class OverflowException extends RuntimeException { }
class RangeException extends RuntimeException { }
class RuntimeException extends Exception { }
class UnderflowException extends RuntimeException {}
class UnexpectedValueException extends RuntimeException {}
class SplFileInfo {
    /* 方法 */
	/** @return void */
	public  function __construct( string $file_name ){} 
	/** @return int */
	public  function getATime(){} 
	/** @return string */
	public  function getBasename( string $suffix  ){} 
	/** @return int */
	public  function getCTime(){} 
	/** @return string */
	public  function getExtension(){} 
	/** @return SplFileInfo */
	public  function getFileInfo( string $class_name  ){} 
	/** @return string */
	public  function getFilename(){} 
	/** @return int */
	public  function getGroup(){} 
	/** @return int */
	public  function getInode(){} 
	/** @return string */
	public  function getLinkTarget(){} 
	/** @return int */
	public  function getMTime(){} 
	/** @return int */
	public  function getOwner(){} 
	/** @return string */
	public  function getPath(){} 
	/** @return SplFileInfo */
	public  function getPathInfo( string $class_name  ){} 
	/** @return string */
	public  function getPathname(){} 
	/** @return int */
	public  function getPerms(){} 
	/** @return string */
	public  function getRealPath(){} 
	/** @return int */
	public  function getSize(){} 
	/** @return string */
	public  function getType(){} 
	/** @return bool */
	public  function isDir(){} 
	/** @return bool */
	public  function isExecutable(){} 
	/** @return bool */
	public  function isFile(){} 
	/** @return bool */
	public  function isLink(){} 
	/** @return bool */
	public  function isReadable(){} 
	/** @return bool */
	public  function isWritable(){} 
	/** @return SplFileObject */
	public  function openFile( string $open_mode = "r" , bool $use_include_path = false , resource $context = NULL  ){} 
	/** @return void */
	public  function setFileClass( string $class_name = "SplFileObject"  ){} 
	/** @return void */
	public  function setInfoClass( string $class_name = "SplFileInfo"  ){} 
	/** @return void */
	public  function __toString(){} 
}
class SplFileObject extends SplFileInfo implements RecursiveIterator , SeekableIterator {
	/** @var integer */
    const  DROP_NEW_LINE = 1 ;
	/** @var integer */
    const  READ_AHEAD = 2 ;
	/** @var integer */
    const  SKIP_EMPTY = 4 ;
	/** @var integer */
    const  READ_CSV = 8 ;

	/** @return string|array */
	public  function current(){} 
	/** @return bool */
	public  function eof(){} 
	/** @return bool */
	public  function fflush(){} 
	/** @return string */
	public  function fgetc(){} 
	/** @return array */
	public  function fgetcsv( string $delimiter = "," , string $enclosure = "\"" , string $escape = "\\"  ){} 
	/** @return string */
	public  function fgets(){} 
	/** @return string */
	public  function fgetss( string $allowable_tags  ){} 
	/** @return bool */
	public  function flock( int $operation , int &$wouldblock  ){} 
	/** @return int */
	public  function fpassthru(){} 
	/** @return int */
	public  function fputcsv( array $fields , string $delimiter = "," , string $enclosure = '"' , string $escape = "\\"  ){} 
	/** @return string */
	public  function fread( int $length ){} 
	/** @return mixed */
	public  function fscanf( string $format ,  $args){} 
	/** @return int */
	public  function fseek( int $offset , int $whence = SEEK_SET  ){} 
	/** @return array */
	public  function fstat(){} 
	/** @return int */
	public  function ftell(){} 
	/** @return bool */
	public  function ftruncate( int $size ){} 
	/** @return int */
	public  function fwrite( string $str , int $length  ){} 
	/** @return void */
	public  function getChildren(){} 
	/** @return array */
	public  function getCsvControl(){} 
	/** @return int */
	public  function getFlags(){} 
	/** @return int */
	public  function getMaxLineLen(){} 
	/** @return bool */
	public  function hasChildren(){} 
	/** @return int */
	public  function key(){} 
	/** @return void */
	public  function next(){} 
	/** @return void */
	public  function rewind(){} 
	/** @return void */
	public  function seek( int $line_pos ){} 
	/** @return void */
	public  function setCsvControl( string $delimiter = "," , string $enclosure = "\"" , string $escape = "\\"  ){} 
	/** @return void */
	public  function setFlags( int $flags ){} 
	/** @return void */
	public  function setMaxLineLen( int $max_len ){} 
	/** @return void */
	public  function __toString(){} 
	/** @return bool */
	public  function valid(){} 
}

class SplTempFileObject extends SplFileObject implements SeekableIterator , RecursiveIterator {
    /* 方法 */
	/** @return void */
	public  function __construct( int $max_memory  ){} 
}
class ArrayObject implements IteratorAggregate , ArrayAccess , Serializable , Countable {
    /* 常量 */
	/** @var integer */
    const  STD_PROP_LIST = 1 ;
	/** @var integer */
    const  ARRAY_AS_PROPS = 2 ;
    /* 方法 */
	/** @return void */
	public  function __construct( mixed $input = null  , int $flags = 0 , string $iterator_class = "ArrayIterator"  ){} 
	/** @return void */
	public  function append( mixed $value ){} 
	/** @return void */
	public  function asort(){} 
	/** @return int */
	public  function count(){} 
	/** @return array */
	public  function exchangeArray( mixed $input ){} 
	/** @return array */
	public  function getArrayCopy(){} 
	/** @return int */
	public  function getFlags(){} 
	/** @return ArrayIterator */
	public  function getIterator(){} 
	/** @return string */
	public  function getIteratorClass(){} 
	/** @return void */
	public  function ksort(){} 
	/** @return void */
	public  function natcasesort(){} 
	/** @return void */
	public  function natsort(){} 
	/** @return bool */
	public  function offsetExists( mixed $index ){} 
	/** @return mixed */
	public  function offsetGet( mixed $index ){} 
	/** @return void */
	public  function offsetSet( mixed $index , mixed $newval ){} 
	/** @return void */
	public  function offsetUnset( mixed $index ){} 
	/** @return string */
	public  function serialize(){} 
	/** @return void */
	public  function setFlags( int $flags ){} 
	/** @return void */
	public  function setIteratorClass( string $iterator_class ){} 
	/** @return void */
	public  function uasort( callable $cmp_function ){} 
	/** @return void */
	public  function uksort( callable $cmp_function ){} 
	/** @return void */
	public  function unserialize( string $serialized ){} 
}

abstract class SplObserver {
    /* 方法 */
	/** @return void */
	abstract public  function update( SplSubject $subject ); 
}
abstract class SplSubject {
    /* 方法 */
	/** @return void */
	abstract public  function attach( SplObserver $observer ); 
	/** @return void */
	abstract public  function detach( SplObserver $observer ); 
	/** @return void */
	abstract public  function notify(); 
}

//XML
class DOMAttr extends DOMNode {
    /* 属性 */
	/** @var string */
    public  $name ;
	/** @var DOMElement */
    public  $ownerElement ;
	/** @var bool */
    public  $schemaTypeInfo ;
	/** @var bool */
    public  $specified ;
	/** @var string */
    public  $value ;
    /* 方法 */
	/** @return void */
	public  function __construct( string $name , string $value  ){} 
	/** @return bool */
	public  function isId(){} 
    /* 继承的方法 */
}
class DOMCdataSection extends DOMText {
    /* Methods */
	/** @return void */
	public  function __construct( string $value ){} 
}

class DOMCharacterData extends DOMNode {
    /* 属性 */
	/** @var string */
    public  $data ;
	/** @var int */
    public  $length ;
    /* 方法 */
	/** @return void */
    function appendData( string $data ){} 
	/** @return void */
    function deleteData( int $offset , int $count ){} 
	/** @return void */
    function insertData( int $offset , string $data ){} 
	/** @return void */
    function replaceData( int $offset , int $count , string $data ){} 
	/** @return string */
    function substringData( int $offset , int $count ){} 
}

class DOMComment extends DOMCharacterData {
    /* 方法 */
	/** @return void */
	public  function __construct( string $value  ){} 
}

class DOMDocument extends DOMNode {
    /* 属性 */
	/** @var string */
    public  $actualEncoding ;
	/** @var DOMConfiguration */
    public  $config ;
	/** @var DOMDocumentType */
    public  $doctype ;
	/** @var DOMElement */
    public  $documentElement ;
	/** @var string */
    public  $documentURI ;
	/** @var string */
    public  $encoding ;
	/** @var bool */
    public  $formatOutput ;
	/** @var DOMImplementation */
    public  $implementation ;
	/** @var bool */
    public  $preserveWhiteSpace = true ;
	/** @var bool */
    public  $recover ;
	/** @var bool */
    public  $resolveExternals ;
	/** @var bool */
    public  $standalone ;
	/** @var bool */
    public  $strictErrorChecking = true ;
	/** @var bool */
    public  $substituteEntities ;
	/** @var bool */
    public  $validateOnParse = false ;
	/** @var string */
    public  $version ;
	/** @var string */
    public  $xmlEncoding ;
	/** @var bool */
    public  $xmlStandalone ;
	/** @var string */
    public  $xmlVersion ;
    /* 方法 */
	/** @return void */
	public  function __construct( string $version , string $encoding  ){} 
	/** @return DOMAttr */
	public  function createAttribute( string $name ){} 
	/** @return DOMAttr */
	public  function createAttributeNS( string $namespaceURI , string $qualifiedName ){} 
	/** @return DOMCDATASection */
	public  function createCDATASection( string $data ){} 
	/** @return DOMComment */
	public  function createComment( string $data ){} 
	/** @return DOMDocumentFragment */
	public  function createDocumentFragment(){} 
	/** @return DOMElement */
	public  function createElement( string $name , string $value  ){} 
	/** @return DOMElement */
	public  function createElementNS( string $namespaceURI , string $qualifiedName , string $value  ){} 
	/** @return DOMEntityReference */
	public  function createEntityReference( string $name ){} 
	/** @return DOMProcessingInstruction */
	public  function createProcessingInstruction( string $target , string $data  ){} 
	/** @return DOMText */
	public  function createTextNode( string $content ){} 
	/** @return DOMElement */
	public  function getElementById( string $elementId ){} 
	/** @return DOMNodeList */
	public  function getElementsByTagName( string $name ){} 
	/** @return DOMNodeList */
	public  function getElementsByTagNameNS( string $namespaceURI , string $localName ){} 
	/** @return DOMNode */
	public  function importNode( DOMNode $importedNode , bool $deep  ){} 
	/** @return mixed */
	public  function load( string $filename , int $options = 0  ){} 
	/** @return bool */
	public  function loadHTML( string $source , int $options = 0  ){} 
	/** @return bool */
	public  function loadHTMLFile( string $filename , int $options = 0  ){} 
	/** @return mixed */
	public  function loadXML( string $source , int $options = 0  ){} 
	/** @return void */
	public  function normalizeDocument(){} 
	/** @return bool */
	public  function registerNodeClass( string $baseclass , string $extendedclass ){} 
	/** @return bool */
	public  function relaxNGValidate( string $filename ){} 
	/** @return bool */
	public  function relaxNGValidateSource( string $source ){} 
	/** @return int */
	public  function save( string $filename , int $options  ){} 
	/** @return string */
	public  function saveHTML( DOMNode $node = NULL  ){} 
	/** @return int */
	public  function saveHTMLFile( string $filename ){} 
	/** @return string */
	public  function saveXML( DOMNode $node , int $options  ){} 
	/** @return bool */
	public  function schemaValidate( string $filename , int $flags  ){} 
	/** @return bool */
	public  function schemaValidateSource( string $source , int $flags  ){} 
	/** @return bool */
	public  function validate(){} 
	/** @return int */
	public  function xinclude( int $options  ){} 
}

class DOMDocumentFragment extends DOMNode {
    /* 方法 */
	/** @return bool */
	public  function appendXML( string $data ){} 
}
class DOMDocumentType extends DOMNode {
    /* 属性 */
	/** @var string */
    public  $publicId ;
	/** @var string */
    public  $systemId ;
	/** @var string */
    public  $name ;
	/** @var DOMNamedNodeMap */
    public  $entities ;
	/** @var DOMNamedNodeMap */
    public  $notations ;
	/** @var string */
    public  $internalSubset ;
}

class DOMElement extends DOMNode {
    /* 属性 */
	/** @var bool */
    public  $schemaTypeInfo ;
	/** @var string */
    public  $tagName ;
    /* 方法 */
	/** @return void */
	public  function __construct( string $name , string $value , string $namespaceURI  ){} 
	/** @return string */
	public  function getAttribute( string $name ){} 
	/** @return DOMAttr */
	public  function getAttributeNode( string $name ){} 
	/** @return DOMAttr */
	public  function getAttributeNodeNS( string $namespaceURI , string $localName ){} 
	/** @return string */
	public  function getAttributeNS( string $namespaceURI , string $localName ){} 
	/** @return DOMNodeList */
	public  function getElementsByTagName( string $name ){} 
	/** @return DOMNodeList */
	public  function getElementsByTagNameNS( string $namespaceURI , string $localName ){} 
	/** @return bool */
	public  function hasAttribute( string $name ){} 
	/** @return bool */
	public  function hasAttributeNS( string $namespaceURI , string $localName ){} 
	/** @return bool */
	public  function removeAttribute( string $name ){} 
	/** @return bool */
	public  function removeAttributeNode( DOMAttr $oldnode ){} 
	/** @return bool */
	public  function removeAttributeNS( string $namespaceURI , string $localName ){} 
	/** @return DOMAttr */
	public  function setAttribute( string $name , string $value ){} 
	/** @return DOMAttr */
	public  function setAttributeNode( DOMAttr $attr ){} 
	/** @return DOMAttr */
	public  function setAttributeNodeNS( DOMAttr $attr ){} 
	/** @return void */
	public  function setAttributeNS( string $namespaceURI , string $qualifiedName , string $value ){} 
	/** @return void */
	public  function setIdAttribute( string $name , bool $isId ){} 
	/** @return void */
	public  function setIdAttributeNode( DOMAttr $attr , bool $isId ){} 
	/** @return void */
	public  function setIdAttributeNS( string $namespaceURI , string $localName , bool $isId ){} 
}
class DOMEntity extends DOMNode {
    /* 属性 */
	/** @var string */
    public  $publicId ;
	/** @var string */
    public  $systemId ;
	/** @var string */
    public  $notationName ;
	/** @var string */
    public  $actualEncoding ;
	/** @var string */
    public  $encoding ;
	/** @var string */
    public  $version ;
}
class DOMEntityReference extends DOMNode {
    /* 属性 */
    /* 方法 */
	/** @return void */
	public  function __construct( string $name ){} 
}
class DOMException extends Exception {
    /* 属性 */
	/** @var int */
    public  $code ;
}
class DOMImplementation {
    /* 属性 */
    /* 方法 */
	/** @return void */
    function __construct(){} 
	/** @return DOMDocument */
	public  function createDocument( string $namespaceURI = NULL , string $qualifiedName = NULL , DOMDocumentType $doctype = NULL  ){} 
	/** @return DOMDocumentType */
	public  function createDocumentType( string $qualifiedName = NULL , string $publicId = NULL , string $systemId = NULL  ){} 
	/** @return bool */
	public  function hasFeature( string $feature , string $version ){} 
}

class DOMNamedNodeMap implements Traversable {
    /* 属性 */
	/** @var int */
    public  $length ;
    /* 方法 */
	/** @return DOMNode */
    function getNamedItem( string $name ){} 
	/** @return DOMNode */
    function getNamedItemNS( string $namespaceURI , string $localName ){} 
	/** @return DOMNode */
    function item( int $index ){} 
}
class DOMNode {
    /* 属性 */
	/** @var string */
    public  $nodeName ;
	/** @var string */
    public  $nodeValue ;
	/** @var int */
    public  $nodeType ;
	/** @var DOMNode */
    public  $parentNode ;
	/** @var DOMNodeList */
    public  $childNodes ;
	/** @var DOMNode */
    public  $firstChild ;
	/** @var DOMNode */
    public  $lastChild ;
	/** @var DOMNode */
    public  $previousSibling ;
	/** @var DOMNode */
    public  $nextSibling ;
	/** @var DOMNamedNodeMap */
    public  $attributes ;
	/** @var DOMDocument */
    public  $ownerDocument ;
	/** @var string */
    public  $namespaceURI ;
	/** @var string */
    public  $prefix ;
	/** @var string */
    public  $localName ;
	/** @var string */
    public  $baseURI ;
	/** @var string */
    public  $textContent ;
    /* 方法 */
	/** @return DOMNode */
	public  function appendChild( DOMNode $newnode ){} 
	/** @return string */
	public  function C14N( bool $exclusive , bool $with_comments , array $xpath , array $ns_prefixes  ){} 
	/** @return int */
	public  function C14NFile( string $uri , bool $exclusive , bool $with_comments , array $xpath , array $ns_prefixes  ){} 
	/** @return DOMNode */
	public  function cloneNode( bool $deep  ){} 
	/** @return int */
	public  function getLineNo(){} 
	/** @return string */
	public  function getNodePath(){} 
	/** @return bool */
	public  function hasAttributes(){} 
	/** @return bool */
	public  function hasChildNodes(){} 
	/** @return DOMNode */
	public  function insertBefore( DOMNode $newnode , DOMNode $refnode  ){} 
	/** @return bool */
	public  function isDefaultNamespace( string $namespaceURI ){} 
	/** @return bool */
	public  function isSameNode( DOMNode $node ){} 
	/** @return bool */
	public  function isSupported( string $feature , string $version ){} 
	/** @return string */
	public  function lookupNamespaceURI( string $prefix ){} 
	/** @return string */
	public  function lookupPrefix( string $namespaceURI ){} 
	/** @return void */
	public  function normalize(){} 
	/** @return DOMNode */
	public  function removeChild( DOMNode $oldnode ){} 
	/** @return DOMNode */
	public  function replaceChild( DOMNode $newnode , DOMNode $oldnode ){} 
}
class DOMNodeList implements Traversable {
    /* 属性 */
	/** @var int */
    public  $length ;
    /* 方法 */
	/** @return DOMNode */
	 function item( int $index ){} 
}

class DOMNotation extends DOMNode {
    /* 属性 */
	/** @var string */
    public  $publicId ;
	/** @var string */
    public  $systemId ;
}

class DOMProcessingInstruction extends DOMNode {
    /* 属性 */
	/** @var string */
    public  $target ;
	/** @var string */
    public  $data ;
    /* 方法 */
	/** @return void */
	public  function __construct( string $name , string $value  ){} 
}
class  DOMText extends DOMCharacterData {
    /* 属性 */
	/** @var string */
    public  $wholeText ;
    /* 方法 */
	/** @return void */
	public  function __construct( string $value  ){} 
	/** @return bool */
	public  function isWhitespaceInElementContent(){} 
	/** @return DOMText */
	public  function splitText( int $offset ){} 
}

class DOMXPath {
    /* 属性 */
	/** @var DOMDocument */
    public  $document ;
    /* 方法 */
	/** @return void */
	public  function __construct( DOMDocument $doc ){} 
	/** @return mixed */
	public  function evaluate( string $expression , DOMNode $contextnode , bool $registerNodeNS = true  ){} 
	/** @return DOMNodeList */
	public  function query( string $expression , DOMNode $contextnode , bool $registerNodeNS = true  ){} 
	/** @return bool */
	public  function registerNamespace( string $prefix , string $namespaceURI ){} 
	/** @return void */
	public  function registerPhpFunctions( mixed $restrict  ){} 
}

class ZipArchive {
    /** @return bool */
    function addEmptyDir( string $dirname ){} 
	/** @return bool */
    function addFile( string $filename , string $localname = NULL , int $start = 0 , int $length = 0  ){} 
	/** @return bool */
    function addFromString( string $localname , string $contents ){} 
	/** @return bool */
    function addGlob( string $pattern , int $flags = 0 , array $options = array()  ){} 
	/** @return bool */
    function addPattern( string $pattern , string $path = "." , array $options = array()  ){} 
	/** @return bool */
    function close(){} 
	/** @return bool */
    function deleteIndex( int $index ){} 
	/** @return bool */
    function deleteName( string $name ){} 
	/** @return bool */
    function extractTo( string $destination , mixed $entries  ){} 
	/** @return string */
    function getArchiveComment( int $flags  ){} 
	/** @return string */
    function getCommentIndex( int $index , int $flags  ){} 
	/** @return string */
    function getCommentName( string $name , int $flags  ){} 
	/** @return bool */
    function GetExternalAttributesIndex( int $index , int &$opsys , int &$attr , int $flags  ){} 
	/** @return bool */
    function getExternalAttributesName( string $name , int &$opsys , int &$attr , int $flags  ){} 
	/** @return string */
    function getFromIndex( int $index , int $length = 0 , int $flags  ){} 
	/** @return string */
    function getFromName( string $name , int $length = 0 , int $flags  ){} 
	/** @return string */
    function getNameIndex( int $index , int $flags  ){} 
	/** @return string */
    function getStatusString(){} 
	/** @return resource */
    function getStream( string $name ){} 
	/** @return int */
    function locateName( string $name , int $flags  ){} 
	/** @return mixed */
    function open( string $filename , int $flags  ){} 
	/** @return bool */
    function renameIndex( int $index , string $newname ){} 
	/** @return bool */
    function renameName( string $name , string $newname ){} 
	/** @return bool */
    function setArchiveComment( string $comment ){} 
	/** @return bool */
    function setCommentIndex( int $index , string $comment ){} 
	/** @return bool */
    function setCommentName( string $name , string $comment ){} 
	/** @return bool */
    function setCompressionIndex( int $index , int $comp_method , int $comp_flags = 0  ){} 
	/** @return bool */
    function setCompressionName( string $name , int $comp_method , int $comp_flags = 0  ){} 
	/** @return bool */
    function setExternalAttributesIndex( int $index , int $opsys , int $attr , int $flags  ){} 
	/** @return bool */
    function setExternalAttributesName( string $name , int $opsys , int $attr , int $flags  ){} 
	/** @return bool */
	public  function setPassword( string $password ){} 
	/** @return array */
    function statIndex( int $index , int $flags  ){} 
	/** @return array */
    function statName( string $name , int $flags  ){} 
	/** @return bool */
    function unchangeAll(){} 
	/** @return bool */
    function unchangeArchive(){} 
	/** @return bool */
    function unchangeIndex( int $index ){} 
	/** @return bool */
    function unchangeName( string $name ){} 
}
abstract  class SplType {
    /* Constants */
	/** @var NULL */
    const  __default = null ;
    /* 方法 */
	/** @return void */
    function __construct( mixed $initial_value , bool $strict  ){} 
}
class SplInt extends SplType {
    /* Constants */
	/** @var integer */
    const  __default = 0 ;
}

class SplFloat extends SplType {
    /* Constants */
	/** @var float */
    const  __default = 0 ;
}

class SplEnum extends SplType {
    /* Constants */
	/** @var NULL */
    const  __default = null ;
    /* 方法 */
	/** @return array */
	public  function getConstList( bool $include_default = false  ){} 
}

class SplBool extends SplEnum {
    /* Constants */
	/** @var boolean */
    const  __default = false ;
	/** @var boolean */
    const  false = false ;
	/** @var boolean */
    const  true = true ;
}

class SplString extends SplType {
    /* Constants */
	/** @var string */
    const  __default = '' ;
}

class SimpleXMLElement implements Traversable {
/* 方法 */
	/** @return void */
	final public  function __construct( string $data , int $options = 0 , bool $data_is_url = false , string $ns = "" , bool $is_prefix = false  ){} 
	/** @return void */
	public  function addAttribute( string $name , string $value , string $namespace  ){} 
	/** @return SimpleXMLElement */
	public  function addChild( string $name , string $value , string $namespace  ){} 
	/** @return mixed */
	public  function asXML( string $filename  ){} 
	/** @return SimpleXMLElement */
	public  function attributes( string $ns = NULL , bool $is_prefix = false  ){} 
	/** @return SimpleXMLElement */
	public  function children( string $ns , bool $is_prefix = false  ){} 
	/** @return int */
	public  function count(){} 
	/** @return array */
	public  function getDocNamespaces( bool $recursive = false , bool $from_root = true  ){} 
	/** @return string */
	public  function getName(){} 
	/** @return array */
	public  function getNamespaces( bool $recursive = false  ){} 
	/** @return bool */
	public  function registerXPathNamespace( string $prefix , string $ns ){} 
	/** @return string */
	public  function __toString(){} 
	/** @return array */
	public  function xpath( string $path ){} 
}

class SimpleXMLIterator extends SimpleXMLElement implements RecursiveIterator , Countable {
/* 方法 */
	/** @return mixed */
	public  function current(){} 
	/** @return SimpleXMLIterator */
	public  function getChildren(){} 
	/** @return bool */
	public  function hasChildren(){} 
	/** @return mixed */
	public  function key(){} 
	/** @return void */
	public  function next(){} 
	/** @return void */
	public  function rewind(){} 
	/** @return bool */
	public  function valid(){} 
}

class XMLReader {
/* 常量 */
	/** @var int */
	 const  NONE = 0 ;
	/** @var int */
	 const  ELEMENT = 1 ;
	/** @var int */
	 const  ATTRIBUTE = 2 ;
	/** @var int */
	 const  TEXT = 3 ;
	/** @var int */
	 const  CDATA = 4 ;
	/** @var int */
	 const  ENTITY_REF = 5 ;
	/** @var int */
	 const  ENTITY = 6 ;
	/** @var int */
	 const  PI = 7 ;
	/** @var int */
	 const  COMMENT = 8 ;
	/** @var int */
	 const  DOC = 9 ;
	/** @var int */
	 const  DOC_TYPE = 10 ;
	/** @var int */
	 const  DOC_FRAGMENT = 11 ;
	/** @var int */
	 const  NOTATION = 12 ;
	/** @var int */
	 const  WHITESPACE = 13 ;
	/** @var int */
	 const  SIGNIFICANT_WHITESPACE = 14 ;
	/** @var int */
	 const  END_ELEMENT = 15 ;
	/** @var int */
	 const  END_ENTITY = 16 ;
	/** @var int */
	 const  XML_DECLARATION = 17 ;
	/** @var int */
	 const  LOADDTD = 1 ;
	/** @var int */
	 const  DEFAULTATTRS = 2 ;
	/** @var int */
	 const  VALIDATE = 3 ;
	/** @var int */
	 const  SUBST_ENTITIES = 4 ;
/* 属性 */
	/** @var int */
	 public  $attributeCount ;

	/** @var int */
	 public  $depth ;
	/** @var bool */
	 public  $hasAttributes ;
	/** @var bool */
	 public  $hasValue ;
	/** @var bool */
	 public  $isDefault ;
	/** @var bool */
	 public  $isEmptyElement ;
	/** @var string */
	 public  $localName ;
	/** @var string */
	 public  $name ;
	/** @var string */
	 public  $namespaceURI ;
	/** @var int */
	 public  $nodeType ;
	/** @var string */
	 public  $prefix ;
	/** @var string */
	 public  $value ;
	/** @var string */
	 public  $xmlLang ;
/* 方法 */
	/** @return bool */
	public  function close(){} 
	/** @return DOMNode */
	public  function expand( DOMNode $basenode  ){} 
	/** @return string */
	public  function getAttribute( string $name ){} 
	/** @return string */
	public  function getAttributeNo( int $index ){} 
	/** @return string */
	public  function getAttributeNs( string $localName , string $namespaceURI ){} 
	/** @return bool */
	public  function getParserProperty( int $property ){} 
	/** @return bool */
	public  function isValid(){} 
	/** @return string */
	public  function lookupNamespace( string $prefix ){} 
	/** @return bool */
	public  function moveToAttribute( string $name ){} 
	/** @return bool */
	public  function moveToAttributeNo( int $index ){} 
	/** @return bool */
	public  function moveToAttributeNs( string $localName , string $namespaceURI ){} 
	/** @return bool */
	public  function moveToElement(){} 
	/** @return bool */
	public  function moveToFirstAttribute(){} 
	/** @return bool */
	public  function moveToNextAttribute(){} 
	/** @return bool */
	public  function next( string $localname  ){} 
	/** @return bool */
	public  function open( string $URI , string $encoding , int $options = 0  ){} 
	/** @return bool */
	public  function read(){} 
	/** @return string */
	public  function readInnerXML(){} 
	/** @return string */
	public  function readOuterXML(){} 
	/** @return string */
	public  function readString(){} 
	/** @return bool */
	public  function setParserProperty( int $property , bool $value ){} 
	/** @return bool */
	public  function setRelaxNGSchema( string $filename ){} 
	/** @return bool */
	public  function setRelaxNGSchemaSource( string $source ){} 
	/** @return bool */
	public  function setSchema( string $filename ){} 
	/** @return bool */
	public  function xml( string $source , string $encoding , int $options = 0  ){} 
}
class Memcache {
	/** @return bool */
	 function add( string $key , mixed $var , int $flag , int $expire  ){} 
	/** @return bool */
	 function addServer( string $host , int $port = 11211 , bool $persistent , int $weight , int $timeout , int $retry_interval , bool $status , callback $failure_callback , int $timeoutms  ){} 
	/** @return bool */
	 function close(){} 
	/** @return bool */
	 function connect( string $host , int $port , int $timeout  ){} 
	/** @return int */
	 function decrement( string $key , int $value = 1  ){} 
	/** @return bool */
	 function delete( string $key , int $timeout = 0  ){} 
	/** @return bool */
	 function flush(){} 
	/** @return string */
	 function get( string $key , int &$flags  ){} 
	/** @return array */
	 function getExtendedStats( string $type , int $slabid , int $limit = 100  ){} 
	/** @return int */
	 function getServerStatus( string $host , int $port = 11211  ){} 
	/** @return array */
	 function getStats( string $type , int $slabid , int $limit = 100  ){} 
	/** @return string */
	 function getVersion(){} 
	/** @return int */
	 function increment( string $key , int $value = 1  ){} 
	/** @return mixed */
	 function pconnect( string $host , int $port , int $timeout  ){} 
	/** @return bool */
	 function replace( string $key , mixed $var , int $flag , int $expire  ){} 
	/** @return bool */
	 function set( string $key , mixed $var , int $flag , int $expire  ){} 
	/** @return bool */
	 function setCompressThreshold( int $threshold , float $min_savings  ){} 
	/** @return bool */
	 function setServerParams( string $host , int $port = 11211 , int $timeout , int $retry_interval = false , bool $status , callback $failure_callback  ){} 
}
class HttpDeflateStream {
	/** @var int */
	 const  TYPE_GZIP 	=0;
	/** @var int */
	 const  TYPE_ZLIB =0;
	/** @var int */
	 const  TYPE_RAW =0;
	/** @var int */
	 const  LEVEL_DEF=0;
	/** @var int */
	 const  LEVEL_MIN=0;
	/** @var int */
	 const  LEVEL_MAX =0;
	/** @var int */
	 const  STRATEGY_DEF 	=0;
	/** @var int */
	 const  STRATEGY_FILT=0;
	/** @var int */
	 const  STRATEGY_HUFF=0;
	/** @var int */
	 const  STRATEGY_RLE =0;
	/** @var int */
	 const  STRATEGY_FIXED=0;
	/** @var int */
	 const  FLUSH_NONE 	=0;
	/** @var int */
	 const  FLUSH_SYNC =0;
	/** @var int */
	 const  FLUSH_FULL=0;

	/** @return void */
	public  function __construct( int $flags = 0  ){} 
	/** @return HttpDeflateStream */
	static public  function factory( int $flags = 0 , string $class_name = "HttpDeflateStream"  ){} 
	/** @return string */
	public  function finish( string $data  ){} 
	/** @return string */
	public  function flush( string $data  ){} 
	/** @return string */
	public  function update( string $data ){} 
}

class HttpInflateStream {
	/** @var int */
	 const  FLUSH_NONE =0;
	/** @var int */
	 const  FLUSH_SYNC=0;
	/** @var int */
	 const  FLUSH_FULL=0;

	/** @return void */
	public  function __construct( int $flags = 0  ){} 
	/** @return HttpInflateStream */
	public  function factory( int $flags = 0 , string $class_name = "HttpInflateStream"  ){} 
	/** @return string */
	public  function finish( string $data  ){} 
	/** @return string */
	public  function flush( string $data  ){} 
	/** @return string */
	public  function update( string $data ){} 
}
class HttpMessage implements Iterator , Countable , Serializable {

	/** @var int */
	 const  TYPE_NONE 	=0;
	/** @var int */
	 const  TYPE_REQUEST 	=0;
	/** @var int */
	 const  TYPE_RESPONSE 	=0;

	/** @var int */
	 protected  $type;
	/** @var string */
	 protected  $body ;
	/** @var float */
	 protected  $httpVersion;
	/** @var array */
	 protected  $headers ;
	/** @var string */
	 protected  $requestMethod ;
	/** @var string */
	 protected  $requestUrl ;
	/** @var int */
	 protected  $responseCode ;
	/** @var string */
	 protected  $responseStatus;
	/** @var HttpMessage */
	 protected  $parentMessage ;

	/** @return void */
	public  function addHeaders( array $headers , bool $append = false  ){} 
	/** @return void */
	public  function __construct( string $message  ){} 
	/** @return HttpMessage */
	public  function detach(){} 
	/** @return HttpMessage */
	static public  function factory( string $raw_message , string $class_name = "HttpMessage"  ){} 
	/** @return HttpMessage */
	static public  function fromEnv( int $message_type , string $class_name = "HttpMessage"  ){} 
	/** @return HttpMessage */
	static public  function fromString( string $raw_message , string $class_name = "HttpMessage"  ){} 
	/** @return string */
	public  function getBody(){} 
	/** @return string */
	public  function getHeader( string $header ){} 
	/** @return array */
	public  function getHeaders(){} 
	/** @return string */
	public  function getHttpVersion(){} 
	/** @return HttpMessage */
	public  function getParentMessage(){} 
	/** @return string */
	public  function getRequestMethod(){} 
	/** @return string */
	public  function getRequestUrl(){} 
	/** @return int */
	public  function getResponseCode(){} 
	/** @return string */
	public  function getResponseStatus(){} 
	/** @return int */
	public  function getType(){} 
	/** @return string */
	public  function guessContentType( string $magic_file , int $magic_mode = MAGIC_MIME  ){} 
	/** @return void */
	public  function prepend( HttpMessage $message , bool $top = true  ){} 
	/** @return HttpMessage */
	public  function reverse(){} 
	/** @return bool */
	public  function send(){} 
	/** @return void */
	public  function setBody( string $body ){} 
	/** @return void */
	public  function setHeaders( array $headers ){} 
	/** @return bool */
	public  function setHttpVersion( string $version ){} 
	/** @return bool */
	public  function setRequestMethod( string $method ){} 
	/** @return bool */
	public  function setRequestUrl( string $url ){} 
	/** @return bool */
	public  function setResponseCode( int $code ){} 
	/** @return bool */
	public  function setResponseStatus( string $status ){} 
	/** @return void */
	public  function setType( int $type ){} 
	/** @return HttpRequest|HttpResponse */
	public  function toMessageTypeObject(){} 
	/** @return string */
	public  function toString( bool $include_parent = false  ){} 
}


class HttpMessage implements Iterator , Countable , Serializable {

	/** @var int */
	 protected  $type;
	/** @var string */
	 protected  $body;
	/** @var float */
	 protected  $httpVersion;
	/** @var array */
	 protected  $headers;
	/** @var string */
	 protected  $requestMethod;
	/** @var requestUrl */
	 protected  $string;
	/** @var int */
	 protected  $responseCode;
	/** @var string */
	 protected  $responseStatus;
	/** @var HttpMessage */
	 protected  $parentMessage;

	/** @var int */
	 const  TYPE_NONE=0;
	/** @var int */
	 const  TYPE_REQUEST=0;
	/** @var int */
	 const  TYPE_RESPONSE=0;


	/** @return void */
	public  function addHeaders( array $headers , bool $append = false  ){} 
	/** @return void */
	public  function __construct( string $message  ){} 
	/** @return HttpMessage */
	public  function detach(){} 
	/** @return HttpMessage */
	static public  function factory( string $raw_message , string $class_name = "HttpMessage"  ){} 
	/** @return HttpMessage */
	static public  function fromEnv( int $message_type , string $class_name = "HttpMessage"  ){} 
	/** @return HttpMessage */
	static public  function fromString( string $raw_message , string $class_name = "HttpMessage"  ){} 
	/** @return string */
	public  function getBody(){} 
	/** @return string */
	public  function getHeader( string $header ){} 
	/** @return array */
	public  function getHeaders(){} 
	/** @return string */
	public  function getHttpVersion(){} 
	/** @return HttpMessage */
	public  function getParentMessage(){} 
	/** @return string */
	public  function getRequestMethod(){} 
	/** @return string */
	public  function getRequestUrl(){} 
	/** @return int */
	public  function getResponseCode(){} 
	/** @return string */
	public  function getResponseStatus(){} 
	/** @return int */
	public  function getType(){} 
	/** @return string */
	public  function guessContentType( string $magic_file , int $magic_mode = MAGIC_MIME  ){} 
	/** @return void */
	public  function prepend( HttpMessage $message , bool $top = true  ){} 
	/** @return HttpMessage */
	public  function reverse(){} 
	/** @return bool */
	public  function send(){} 
	/** @return void */
	public  function setBody( string $body ){} 
	/** @return void */
	public  function setHeaders( array $headers ){} 
	/** @return bool */
	public  function setHttpVersion( string $version ){} 
	/** @return bool */
	public  function setRequestMethod( string $method ){} 
	/** @return bool */
	public  function setRequestUrl( string $url ){} 
	/** @return bool */
	public  function setResponseCode( int $code ){} 
	/** @return bool */
	public  function setResponseStatus( string $status ){} 
	/** @return void */
	public  function setType( int $type ){} 
	/** @return HttpRequest|HttpResponse */
	public  function toMessageTypeObject(){} 
	/** @return string */
	public  function toString( bool $include_parent = false  ){} 
}

class HttpQueryString implements ArrayAccess , Serializable {

	/** @var int */
	 const  TYPE_BOOL=0;
	/** @var int */
	 const  TYPE_INT=0;
	/** @var int */
	 const  TYPE_FLOAT=0;
	/** @var int */
	 const  TYPE_STRING=0;
	/** @var int */
	 const  TYPE_ARRAY=0;
	/** @var int */
	 const  TYPE_OBJECT=0;

	/** @return void */
	final public  function __construct( bool $global = true , mixed $add  ){} 
	/** @return mixed */
	public  function get( string $key , mixed $type = 0 , mixed $defval = NULL , bool $delete = false  ){} 
	/** @return HttpQueryString */
	public  function mod( mixed $params ){} 
	/** @return string */
	public  function set( mixed $params ){} 
	/** @return HttpQueryString */
	static public  function singleton( bool $global = true  ){} 
	/** @return array */
	public  function toArray(){} 
	/** @return string */
	public  function toString(){} 
	/** @return bool */
	public  function xlate( string $ie , string $oe ){} 

}

class HttpRequest {

	/** @var integer */
	 const  METH_GET=0;
	/** @var integer */
	 const  METH_HEAD=0;
	/** @var integer */
	 const  METH_POST=0;
	/** @var integer */
	 const  METH_PUT=0;
	/** @var integer */
	 const  METH_DELETE=0;
	/** @var integer */
	 const  METH_OPTIONS=0;
	/** @var integer */
	 const  METH_TRACE=0;
	/** @var integer */
	 const  METH_CONNECT=0;
	/** @var integer */
	 const  METH_PROPFIND=0;
	/** @var integer */
	 const  METH_PROPPATCH=0;
	/** @var integer */
	 const  METH_MKCOL=0;
	/** @var integer */
	 const  METH_COPY=0;
	/** @var integer */
	 const  METH_MOVE=0;
	/** @var integer */
	 const  METH_LOCK=0;
	/** @var integer */
	 const  METH_UNLOCK=0;
	/** @var integer */
	 const  METH_VERSION_CONTROL=0;
	/** @var integer */
	 const  METH_REPORT=0;
	/** @var integer */
	 const  METH_CHECKOUT=0;
	/** @var integer */
	 const  METH_CHECKIN=0;
	/** @var integer */
	 const  METH_UNCHECKOUT=0;
	/** @var integer */
	 const  METH_MKWORKSPACE=0;
	/** @var integer */
	 const  METH_UPDATE=0;
	/** @var integer */
	 const  METH_LABEL=0;
	/** @var integer */
	 const  METH_MERGE=0;
	/** @var integer */
	 const  METH_BASELINE_CONTROL=0;
	/** @var integer */
	 const  METH_MKACTIVITY=0;
	/** @var integer */
	 const  METH_ACL=0;
	/** @var integer */
	 const  VERSION_1_0=0;
	/** @var integer */
	 const  VERSION_1_1=0;
	/** @var integer */
	 const  VERSION_ANY=0;
	/** @var integer */
	 const  AUTH_BASIC=0;
	/** @var integer */
	 const  AUTH_DIGEST=0;
	/** @var integer */
	 const  AUTH_NTLM=0;
	/** @var integer */
	 const  AUTH_GSSNEG=0;
	/** @var integer */
	 const  AUTH_ANY=0;
	/** @var integer */
	 const  PROXY_SOCKS4=0;
	/** @var integer */
	 const  PROXY_SOCKS5=0;
	/** @var integer */
	 const  PROXY_HTTP=0;
	/** @var integer */
	 const  SSL_VERSION_TLSv1=0;
	/** @var integer */
	 const  SSL_VERSION_SSLv2=0;
	/** @var integer */
	 const  SSL_VERSION_SSLv3=0;
	/** @var integer */
	 const  SSL_VERSION_ANY=0;
	/** @var integer */
	 const  IPRESOLVE_V4=0;
	/** @var integer */
	 const  IPRESOLVE_V6=0;
	/** @var integer */
	 const  IPRESOLVE_ANY=0;

	/** @var boolean */
	 public  $recordHistory;

	/** @return bool */
	public  function addCookies( array $cookies ){} 
	/** @return bool */
	public  function addHeaders( array $headers ){} 
	/** @return bool */
	public  function addPostFields( array $post_data ){} 
	/** @return bool */
	public  function addPostFile( string $name , string $file , string $content_type = "application/x-octetstream"  ){} 
	/** @return bool */
	public  function addPutData( string $put_data ){} 
	/** @return bool */
	public  function addQueryData( array $query_params ){} 
	/** @return bool */
	public  function addRawPostData( string $raw_post_data ){} 
	/** @return bool */
	public  function addSslOptions( array $options ){} 
	/** @return void */
	public  function clearHistory(){} 
	/** @return void */
	public  function __construct( string $url , int $request_method = HTTP_METH_GET , array $options  ){} 
	/** @return bool */
	public  function enableCookies(){} 
	/** @return string */
	public  function getContentType(){} 
	/** @return array */
	public  function getCookies(){} 
	/** @return array */
	public  function getHeaders(){} 
	/** @return HttpMessage */
	public  function getHistory(){} 
	/** @return int */
	public  function getMethod(){} 
	/** @return array */
	public  function getOptions(){} 
	/** @return array */
	public  function getPostFields(){} 
	/** @return array */
	public  function getPostFiles(){} 
	/** @return string */
	public  function getPutData(){} 
	/** @return string */
	public  function getPutFile(){} 
	/** @return string */
	public  function getQueryData(){} 
	/** @return string */
	public  function getRawPostData(){} 
	/** @return string */
	public  function getRawRequestMessage(){} 
	/** @return string */
	public  function getRawResponseMessage(){} 
	/** @return HttpMessage */
	public  function getRequestMessage(){} 
	/** @return string */
	public  function getResponseBody(){} 
	/** @return int */
	public  function getResponseCode(){} 
	/** @return array */
	public  function getResponseCookies( int $flags = 0 , array $allowed_extras  ){} 
	/** @return array */
	public  function getResponseData(){} 
	/** @return mixed */
	public  function getResponseHeader( string $name  ){} 
	/** @return mixed */
	public  function getResponseInfo( string $name  ){} 
	/** @return HttpMessage */
	public  function getResponseMessage(){} 
	/** @return string */
	public  function getResponseStatus(){} 
	/** @return array */
	public  function getSslOptions(){} 
	/** @return string */
	public  function getUrl(){} 
	/** @return bool */
	public  function resetCookies( bool $session_only = false  ){} 
	/** @return HttpMessage */
	public  function send(){} 
	/** @return bool */
	 function setBody( string $request_body_data  ){} 
	/** @return bool */
	public  function setContentType( string $content_type ){} 
	/** @return bool */
	public  function setCookies( array $cookies  ){} 
	/** @return bool */
	public  function setHeaders( array $headers  ){} 
	/** @return bool */
	public  function setMethod( int $request_method ){} 
	/** @return bool */
	public  function setOptions( array $options  ){} 
	/** @return bool */
	public  function setPostFields( array $post_data ){} 
	/** @return bool */
	public  function setPostFiles( array $post_files ){} 
	/** @return bool */
	public  function setPutData( string $put_data  ){} 
	/** @return bool */
	public  function setPutFile( string $file = ""  ){} 
	/** @return bool */
	public  function setQueryData( mixed $query_data ){} 
	/** @return bool */
	public  function setRawPostData( string $raw_post_data  ){} 
	/** @return bool */
	public  function setSslOptions( array $options  ){} 
	/** @return bool */
	public  function setUrl( string $url ){} 
}

class HttpRequestPool implements Iterator , Countable {

	/** @return bool */
	public  function attach( HttpRequest $request ){} 
	/** @return void */
	public  function __construct( HttpRequest $request , HttpRequest $__args__  ){} 
	/** @return void */
	 function __destruct(){} 
	/** @return bool */
	 function detach( HttpRequest $request ){} 
	/** @return array */
	 function getAttachedRequests(){} 
	/** @return array */
	 function getFinishedRequests(){} 
	/** @return void */
	 function reset(){} 
	/** @return bool */
	 function send(){} 
	/** @return bool */
	protected  function socketPerform(){} 
	/** @return bool */
	protected  function socketSelect( float $timeout = 0  ){} 
}

class HttpResponse {

	/** @var boolean */
	 protected  $cache;
	/** @var boolean */
	 protected  $gzip;
	/** @var string */
	 protected  $eTag;
	/** @var integer */
	 protected  $lastModified;
	/** @var string */
	 protected  $cacheControl;
	/** @var string */
	 protected  $contentType;
	/** @var string */
	 protected  $contentDisposition;
	/** @var integer */
	 protected  $bufferSize;
	/** @var double */
	 protected  $throttleDelay;


	/** @var integer */
	 const  REDIRECT=0;
	/** @var integer */
	 const  REDIRECT_PERM=0;
	/** @var integer */
	 const  REDIRECT_FOUND=0;
	/** @var integer */
	 const  REDIRECT_POST=0;
	/** @var integer */
	 const  REDIRECT_PROXY=0;
	/** @var integer */
	 const  REDIRECT_TEMP=0;

	/** @return void */
	static  function capture(){} 
	/** @return int */
	static  function getBufferSize(){} 
	/** @return bool */
	static  function getCache(){} 
	/** @return string */
	static  function getCacheControl(){} 
	/** @return string */
	static  function getContentDisposition(){} 
	/** @return string */
	static  function getContentType(){} 
	/** @return string */
	static  function getData(){} 
	/** @return string */
	static  function getETag(){} 
	/** @return string */
	static  function getFile(){} 
	/** @return bool */
	static  function getGzip(){} 
	/** @return mixed */
	static  function getHeader( string $name  ){} 
	/** @return int */
	static  function getLastModified(){} 
	/** @return string */
	static  function getRequestBody(){} 
	/** @return resource */
	static  function getRequestBodyStream(){} 
	/** @return array */
	static  function getRequestHeaders(){} 
	/** @return resource */
	static  function getStream(){} 
	/** @return float */
	static  function getThrottleDelay(){} 
	/** @return string */
	static  function guessContentType( string $magic_file , int $magic_mode = MAGIC_MIME  ){} 
	/** @return void */
	static  function redirect( string $url , array $params , bool $session = false , int $status  ){} 
	/** @return bool */
	static  function send( bool $clean_ob = true  ){} 
	/** @return bool */
	static  function setBufferSize( int $bytes ){} 
	/** @return bool */
	static  function setCache( bool $cache ){} 
	/** @return bool */
	static  function setCacheControl( string $control , int $max_age = 0 , bool $must_revalidate = true  ){} 
	/** @return bool */
	static  function setContentDisposition( string $filename , bool $inline = false  ){} 
	/** @return bool */
	static  function setContentType( string $content_type ){} 
	/** @return bool */
	static  function setData( mixed $data ){} 
	/** @return bool */
	static  function setETag( string $etag ){} 
	/** @return bool */
	static  function setFile( string $file ){} 
	/** @return bool */
	static  function setGzip( bool $gzip ){} 
	/** @return bool */
	static  function setHeader( string $name , mixed $value , bool $replace = true  ){} 
	/** @return bool */
	static  function setLastModified( int $timestamp ){} 
	/** @return bool */
	static  function setStream( resource $stream ){} 
	/** @return bool */
	static  function setThrottleDelay( float $seconds ){} 
	/** @return bool */
	static  function status( int $status ){} 
}

class mysqli {
/* Properties */
	/** @var int */
	 public  $affected_rows;
	/** @var string */
	 public  $client_info;
	/** @var int */
	 public  $client_version;
	/** @var int */
	 public  $connect_errno;
	/** @var string */
	 public  $connect_error;
	/** @var int */
	 public  $errno;
	/** @var array */
	 public  $error_list;
	/** @var string */
	 public  $error;
	/** @var int */
	 public  $field_count;
	/** @var int */
	 public  $client_version;
	/** @var string */
	 public  $host_info;
	/** @var string */
	 public  $protocol_version;
	/** @var string */
	 public  $server_info;
	/** @var int */
	 public  $server_version;
	/** @var string */
	 public  $info;
	/** @var mixed */
	 public  $insert_id;
	/** @var string */
	 public  $sqlstate;
	/** @var int */
	 public  $thread_id;
	/** @var int */
	 public  $warning_count;
/* Methods */
	/** @return void */
	 function __construct( string $host = 'ini_get("mysqli.default_host")' , string $username = 'ini_get("mysqli.default_user")' , string $passwd = 'ini_get("mysqli.default_pw")' , string $dbname = "" , int $port = 'ini_get("mysqli.default_port")' , string $socket = 'ini_get("mysqli.default_socket")'  ){} /** @return bool */
	 function autocommit( bool $mode ){} 
	/** @return bool */
	 function change_user( string $user , string $password , string $database ){} 
	/** @return string */
	 function character_set_name(){} 
	/** @return bool */
	 function close(){} 
	/** @return bool */
	 function commit( int $flags , string $name  ){} 
	/** @return bool */
	 function debug( string $message ){} 
	/** @return bool */
	 function dump_debug_info(){} 
	/** @return object */
	 function get_charset(){} 
	/** @return string */
	 function get_client_info(){} 
	/** @return bool */
	 function get_connection_stats(){} 
	/** @return mysqli_warning */
	 function get_warnings(){} 
	/** @return mysqli */
	 function init(){} 
	/** @return bool */
	 function kill( int $processid ){} 
	/** @return bool */
	 function more_results(){} 
	/** @return bool */
	 function multi_query( string $query ){} 
	/** @return bool */
	 function next_result(){} 
	/** @return bool */
	 function options( int $option , mixed $value ){} 
	/** @return bool */
	 function ping(){} 
	/** @return int */
	public static  function poll( array &$read , array &$error , array &$reject , int $sec , int $usec  ){} 
	/** @return mysqli_stmt */
	 function prepare( string $query ){} 
	/** @return mixed */
	 function query( string $query , int $resultmode = MYSQLI_STORE_RESULT  ){} 
	/** @return bool */
	 function real_connect( string $host , string $username , string $passwd , string $dbname , int $port , string $socket , int $flags  ){} 
	/** @return string */
	 function escape_string( string $escapestr ){} 
	/** @return bool */
	 function real_query( string $query ){} 
	/** @return mysqli_result */
	public  function reap_async_query(){} 
	/** @return bool */
	public  function refresh( int $options ){} 
	/** @return bool */
	 function rollback( int $flags , string $name  ){} 
	/** @return int */
	 function rpl_query_type( string $query ){} 
	/** @return bool */
	 function select_db( string $dbname ){} 
	/** @return bool */
	 function send_query( string $query ){} 
	/** @return bool */
	 function set_charset( string $charset ){} 
	/** @return bool */
	 function set_local_infile_handler( mysqli $link , callable $read_func ){} 
	/** @return bool */
	 function ssl_set( string $key , string $cert , string $ca , string $capath , string $cipher ){} 
	/** @return string */
	 function stat(){} 
	/** @return mysqli_stmt */
	 function stmt_init(){} 
	/** @return mysqli_result */
	 function store_result( int $option  ){} 
	/** @return mysqli_result */
	 function use_result(){} 
}
class mysqli_stmt {
/* Properties */
	/** @var int */
	 public  $affected_rows;
	/** @var int */
	 public  $errno;
	/** @var array */
	 public  $error_list;
	/** @var string */
	 public  $error;
	/** @var int */
	 public  $field_count;
	/** @var int */
	 public  $insert_id;
	/** @var int */
	 public  $num_rows;
	/** @var int */
	 public  $param_count;
	/** @var string */
	 public  $sqlstate;
/* Methods */
	/** @return void */
	 function __construct( mysqli $link , string $query  ){} 
	/** @return int */
	 function attr_get( int $attr ){} 
	/** @return bool */
	 function attr_set( int $attr , int $mode ){} 
	/** @return bool */
	 function bind_param( string $types , mixed &$var1 , mixed $__args__ ){} 
	/** @return bool */
	 function bind_result( mixed &$var1 , mixed $__args__  ){} 
	/** @return bool */
	 function close(){} 
	/** @return void */
	 function data_seek( int $offset ){} 
	/** @return bool */
	 function execute(){} 
	/** @return bool */
	 function fetch(){} 
	/** @return void */
	 function free_result(){} 
	/** @return mysqli_result */
	 function get_result(){} 
	/** @return object */
	 function get_warnings( mysqli_stmt $stmt ){} 
	/** @return mixed */
	 function prepare( string $query ){} 
	/** @return bool */
	 function reset(){} 
	/** @return mysqli_result */
	 function result_metadata(){} 
	/** @return bool */
	 function send_long_data( int $param_nr , string $data ){} 
	/** @return bool */
	 function store_result(){} 
}
class mysqli_result implements Traversable {
/* Properties */
	/** @var int */
	 public  $current_field ;
	/** @var int */
	 public  $field_count;
	/** @var array */
	 public  $lengths;
	/** @var int */
	 public  $num_rows;
/* Methods */
	/** @return bool */
	 function data_seek( int $offset ){} 
	/** @return mixed */
	 function fetch_all( int $resulttype = MYSQLI_NUM  ){} 
	/** @return mixed */
	 function fetch_array( int $resulttype = MYSQLI_BOTH  ){} 
	/** @return array */
	 function fetch_assoc(){} 
	/** @return object */
	 function fetch_field_direct( int $fieldnr ){} 
	/** @return object */
	 function fetch_field(){} 
	/** @return array */
	 function fetch_fields(){} 
	/** @return object */
	 function fetch_object( string $class_name = "stdClass" , array $params  ){} 
	/** @return mixed */
	 function fetch_row(){} 
	/** @return bool */
	 function field_seek( int $fieldnr ){} 
	/** @return void */
	 function free(){} 
}
class  mysqli_driver {
/* Properties */
	/** @var string */
	 public  $client_info ;
	/** @var string */
	 public  $client_version ;
	/** @var string */
	 public  $driver_version ;
	/** @var string */
	 public  $embedded ;
	/** @var bool */
	 public  $reconnect ;
	/** @var int */
	 public  $report_mode ;
/* Methods */
	/** @return void */
	 function embedded_server_end(){} 
	/** @return bool */
	 function embedded_server_start( bool $start , array $arguments , array $groups ){} 
}


class mysqli_warning {
/* Properties */
	/** @var string */
	 public  $message ;
	/** @var int */
	 public  $sqlstate ;
	/** @var int */
	 public  $errno ;
/* Methods */
	/** @return void */
	public  function __construct(){} 
	/** @return void */
	public  function next(){} 
}

class mysqli_sql_exception extends RuntimeException {
	/** @var string */
	 protected  $sqlstate ;
}
class SQLite3 {
/* Methods */
	/** @return bool */
	public  function busyTimeout( int $msecs ){} 
	/** @return int */
	public  function changes(){} 
	/** @return bool */
	public  function close(){} 
	/** @return void */
	public  function __construct( string $filename , int $flags , string $encryption_key  ){} 
	/** @return bool */
	public  function createAggregate( string $name , mixed $step_callback , mixed $final_callback , int $argument_count = -1  ){} 
	/** @return bool */
	public  function createCollation( string $name , callable $callback ){} 
	/** @return bool */
	public  function createFunction( string $name , mixed $callback , int $argument_count = -1  ){} 
	/** @return string */
	public static  function escapeString( string $value ){} 
	/** @return bool */
	public  function exec( string $query ){} 
	/** @return int */
	public  function lastErrorCode(){} 
	/** @return string */
	public  function lastErrorMsg(){} 
	/** @return int */
	public  function lastInsertRowID(){} 
	/** @return bool */
	public  function loadExtension( string $shared_library ){} 
	/** @return void */
	public  function open( string $filename , int $flags = SQLITE3_OPEN_READWRITE | SQLITE3_OPEN_CREATE , string $encryption_key  ){} 
	/** @return SQLite3Stmt */
	public  function prepare( string $query ){} 
	/** @return SQLite3Result */
	public  function query( string $query ){} 
	/** @return mixed */
	public  function querySingle( string $query , bool $entire_row = false  ){} 
	/** @return array */
	public static  function version(){} 
}

class SQLite3Stmt {
/* Methods */
	/** @return bool */
	public  function bindParam( string $sql_param , mixed &$param , int $type  ){} 
	/** @return bool */
	public  function bindValue( string $sql_param , mixed $value , int $type  ){} 
	/** @return bool */
	public  function clear(){} 
	/** @return bool */
	public  function close(){} 
	/** @return SQLite3Result */
	public  function execute(){} 
	/** @return int */
	public  function paramCount(){} 
	/** @return bool */
	public  function reset(){} 
}


class SQLite3Result {
/* Methods */
	/** @return string */
	public  function columnName( int $column_number ){} 
	/** @return int */
	public  function columnType( int $column_number ){} 
	/** @return array */
	public  function fetchArray( int $mode = SQLITE3_BOTH  ){} 
	/** @return bool */
	public  function finalize(){} 
	/** @return int */
	public  function numColumns(){} 
	/** @return bool */
	public  function reset(){} 
}
class PDO {
	/** @return void */
	public  function __construct( string $dsn , string $username , string $password , array $options  ){} 
	/** @return bool */
	public  function beginTransaction(){} 
	/** @return bool */
	public  function commit(){} 
	/** @return mixed */
	public  function errorCode(){} 
	/** @return array */
	public  function errorInfo(){} 
	/** @return int */
	public  function exec( string $statement ){} 
	/** @return mixed */
	public  function getAttribute( int $attribute ){} 
	/** @return array */
	public static  function getAvailableDrivers(){} 
	/** @return bool */
	public  function inTransaction(){} 
	/** @return string */
	public  function lastInsertId( string $name = NULL  ){} 
	/** @return PDOStatement */
	public  function prepare( string $statement , array $driver_options = array()  ){} 
	/** @return PDOStatement */
	public  function query( string $statement ){} 
	/** @return string */
	public  function quote( string $string , int $parameter_type = PDO::PARAM_STR  ){} 
	/** @return bool */
	public  function rollBack(){} 
	/** @return bool */
	public  function setAttribute( int $attribute , mixed $value ){} 
}

class PDOStatement implements Traversable {
/* Properties */
	/** @var string */
	 public  $queryString;
/* Methods */
	/** @return bool */
	public  function bindColumn( mixed $column , mixed &$param , int $type , int $maxlen , mixed $driverdata  ){} 
	/** @return bool */
	public  function bindParam( mixed $parameter , mixed &$variable , int $data_type = PDO::PARAM_STR , int $length , mixed $driver_options  ){} 
	/** @return bool */
	public  function bindValue( mixed $parameter , mixed $value , int $data_type = PDO::PARAM_STR  ){} 
	/** @return bool */
	public  function closeCursor(){} 
	/** @return int */
	public  function columnCount(){} 
	/** @return void */
	public  function debugDumpParams(){} 
	/** @return string */
	public  function errorCode(){} 
	/** @return array */
	public  function errorInfo(){} 
	/** @return bool */
	public  function execute( array $input_parameters  ){} 
	/** @return mixed */
	public  function fetch( int $fetch_style , int $cursor_orientation = PDO::FETCH_ORI_NEXT , int $cursor_offset = 0  ){} 
	/** @return array */
	public  function fetchAll( int $fetch_style , mixed $fetch_argument , array $ctor_args = array()  ){} 
	/** @return mixed */
	public  function fetchColumn( int $column_number = 0  ){} 
	/** @return mixed */
	public  function fetchObject( string $class_name = "stdClass" , array $ctor_args  ){} 
	/** @return mixed */
	public  function getAttribute( int $attribute ){} 
	/** @return array */
	public  function getColumnMeta( int $column ){} 
	/** @return bool */
	public  function nextRowset(){} 
	/** @return int */
	public  function rowCount(){} 
	/** @return bool */
	public  function setAttribute( int $attribute , mixed $value ){} 
	/** @return bool */
	public  function setFetchMode( int $mode ){} 
}

class PDOException extends RuntimeException {
/* Properties */
	/** @var array */
	 public  $errorInfo ;
	/** @var string */
	 protected  $code ;
}
class DateTime implements DateTimeInterface {
/* 常量 */
	/** @var string */
	 const  ATOM = "Y-m-d\TH:i:sP" ;
	/** @var string */
	 const  COOKIE = "l, d-M-Y H:i:s T" ;
	/** @var string */
	 const  ISO8601 = "Y-m-d\TH:i:sO" ;
	/** @var string */
	 const  RFC822 = "D, d M y H:i:s O" ;
	/** @var string */
	 const  RFC850 = "l, d-M-y H:i:s T" ;
	/** @var string */
	 const  RFC1036 = "D, d M y H:i:s O" ;
	/** @var string */
	 const  RFC1123 = "D, d M Y H:i:s O" ;
	/** @var string */
	 const  RFC2822 = "D, d M Y H:i:s O" ;
	/** @var string */
	 const  RFC3339 = "Y-m-d\TH:i:sP" ;
	/** @var string */
	 const  RSS = "D, d M Y H:i:s O" ;
	/** @var string */
	 const  W3C = "Y-m-d\TH:i:sP" ;
/* 方法 */
	/** @return void */
	public  function __construct( string $time = "now" , DateTimeZone $timezone = NULL  ){} 
	/** @return DateTime */
	public  function add( DateInterval $interval ){} 
	/** @return DateTime */
	public static  function createFromFormat( string $format , string $time , DateTimeZone $timezone  ){} 
	/** @return array */
	public static  function getLastErrors(){} 
	/** @return DateTime */
	public  function modify( string $modify ){} 
	/** @return DateTime */
	public static  function __set_state( array $array ){} 
	/** @return DateTime */
	public  function setDate( int $year , int $month , int $day ){} 
	/** @return DateTime */
	public  function setISODate( int $year , int $week , int $day = 1  ){} 
	/** @return DateTime */
	public  function setTime( int $hour , int $minute , int $second = 0  ){} 
	/** @return DateTime */
	public  function setTimestamp( int $unixtimestamp ){} 
	/** @return DateTime */
	public  function setTimezone( DateTimeZone $timezone ){} 
	/** @return DateTime */
	public  function sub( DateInterval $interval ){} 
	/** @return DateInterval */
	public  function diff( DateTimeInterface $datetime2 , bool $absolute = false  ){} 
	/** @return string */
	public  function format( string $format ){} 
	/** @return int */
	public  function getOffset(){} 
	/** @return int */
	public  function getTimestamp(){} 
	/** @return DateTimeZone */
	public  function getTimezone(){} 
	/** @return void */
	public  function __wakeup(){} 
}

class DateTimeImmutable implements DateTimeInterface {
/* 方法 */
	/** @return void */
	public  function __construct( string $time = "now" , DateTimeZone $timezone = NULL  ){} 
	/** @return DateTimeImmutable */
	public  function add( DateInterval $interval ){} 
	/** @return DateTimeImmutable */
	public static  function createFromFormat( string $format , string $time , DateTimeZone $timezone  ){} 
	/** @return DateTimeImmutable */
	public static  function createFromMutable( DateTime $datetime ){} 
	/** @return array */
	public static  function getLastErrors(){} 
	/** @return DateTimeImmutable */
	public  function modify( string $modify ){} 
	/** @return DateTimeImmutable */
	public static  function __set_state( array $array ){} 
	/** @return DateTimeImmutable */
	public  function setDate( int $year , int $month , int $day ){} 
	/** @return DateTimeImmutable */
	public  function setISODate( int $year , int $week , int $day = 1  ){} 
	/** @return DateTimeImmutable */
	public  function setTime( int $hour , int $minute , int $second = 0  ){} 
	/** @return DateTimeImmutable */
	public  function setTimestamp( int $unixtimestamp ){} 
	/** @return DateTimeImmutable */
	public  function setTimezone( DateTimeZone $timezone ){} 
	/** @return DateTimeImmutable */
	public  function sub( DateInterval $interval ){} 
	/** @return DateInterval */
	public  function diff( DateTimeInterface $datetime2 , bool $absolute = false  ){} 
	/** @return string */
	public  function format( string $format ){} 
	/** @return int */
	public  function getOffset(){} 
	/** @return int */
	public  function getTimestamp(){} 
	/** @return DateTimeZone */
	public  function getTimezone(){} 
	/** @return void */
	public  function __wakeup(){} 
}
class DateTimeInterface {
/* 方法 */
	/** @return DateInterval */
	public  function diff( DateTimeInterface $datetime2 , bool $absolute = false  ){} 
	/** @return string */
	public  function format( string $format ){} 
	/** @return int */
	public  function getOffset(){} 
	/** @return int */
	public  function getTimestamp(){} 
	/** @return DateTimeZone */
	public  function getTimezone(){} 
	/** @return void */
	public  function __wakeup(){} 
}
class DateTimeZone {
/* 常量 */
	/** @var integer */
	 const  AFRICA = 1 ;
	/** @var integer */
	 const  AMERICA = 2 ;
	/** @var integer */
	 const  ANTARCTICA = 4 ;
	/** @var integer */
	 const  ARCTIC = 8 ;
	/** @var integer */
	 const  ASIA = 16 ;
	/** @var integer */
	 const  ATLANTIC = 32 ;
	/** @var integer */
	 const  AUSTRALIA = 64 ;
	/** @var integer */
	 const  EUROPE = 128 ;
	/** @var integer */
	 const  INDIAN = 256 ;
	/** @var integer */
	 const  PACIFIC = 512 ;
	/** @var integer */
	 const  UTC = 1024 ;
	/** @var integer */
	 const  ALL = 2047 ;
	/** @var integer */
	 const  ALL_WITH_BC = 4095 ;
	/** @var integer */
	 const  PER_COUNTRY = 4096 ;
/* 方法 */
	/** @return void */
	public  function __construct( string $timezone ){} 
	/** @return array */
	public  function getLocation(){} 
	/** @return string */
	public  function getName(){} 
	/** @return int */
	public  function getOffset( DateTime $datetime ){} 
	/** @return array */
	public  function getTransitions( int $timestamp_begin , int $timestamp_end  ){} 
	/** @return array */
	public static  function listAbbreviations(){} 
	/** @return array */
	public static  function listIdentifiers( int $what = DateTimeZone::ALL , string $country = NULL  ){} 
}

class DateInterval {
/* 属性 */
	/** @var integer */
	 public  $y ;
	/** @var integer */
	 public  $m ;
	/** @var integer */
	 public  $d ;
	/** @var integer */
	 public  $h ;
	/** @var integer */
	 public  $i ;
	/** @var integer */
	 public  $s ;
	/** @var integer */
	 public  $invert ;
	/** @var mixed */
	 public  $days ;
/* 方法 */
	/** @return void */
	public  function __construct( string $interval_spec ){} 
	/** @return DateInterval */
	public static  function createFromDateString( string $time ){} 
	/** @return string */
	public  function format( string $format ){} 
}
class DatePeriod implements Traversable {
/* 常量 */
	/** @var integer */
	 const  EXCLUDE_START_DATE = 1 ;
/* 方法 */
	/** @return void */
	public  function __construct( DateTimeInterface $start , DateInterval $interval , int $recurrences , int $options  ){} 
	/** @return void */
	public  function __construct( DateTimeInterface $start , DateInterval $interval , DateTimeInterface $end , int $options  ){} 
	/** @return void */
	public  function __construct( string $isostr , int $options  ){} 
}

class Imagick implements Iterator {
	/** @return bool */
	 function adaptiveBlurImage( float $radius , float $sigma , int $channel = Imagick::CHANNEL_DEFAULT  ){} 
	/** @return bool */
	 function adaptiveResizeImage( int $columns , int $rows , bool $bestfit = false  ){} 
	/** @return bool */
	 function adaptiveSharpenImage( float $radius , float $sigma , int $channel = Imagick::CHANNEL_DEFAULT  ){} 
	/** @return bool */
	 function adaptiveThresholdImage( int $width , int $height , int $offset ){} 
	/** @return bool */
	 function addImage( Imagick $source ){} 
	/** @return bool */
	 function addNoiseImage( int $noise_type , int $channel = Imagick::CHANNEL_DEFAULT  ){} 
	/** @return bool */
	 function affineTransformImage( ImagickDraw $matrix ){} 
	/** @return bool */
	 function animateImages( string $x_server ){} 
	/** @return bool */
	 function annotateImage( ImagickDraw $draw_settings , float $x , float $y , float $angle , string $text ){} 
	/** @return Imagick */
	 function appendImages( bool $stack = false ){} 
	/** @return void */
	public  function autoLevelImage( string $CHANNEL = Imagick::CHANNEL_DEFAULT  ){} 
	/** @return Imagick */
	 function averageImages(){} 
	/** @return bool */
	 function blackThresholdImage( mixed $threshold ){} 
	/** @return void */
	public  function blueShiftImage( float $factor = 1.5  ){} 
	/** @return bool */
	 function blurImage( float $radius , float $sigma , int $channel  ){} 
	/** @return bool */
	 function borderImage( mixed $bordercolor , int $width , int $height ){} 
	/** @return void */
	public  function brightnessContrastImage( string $brightness , string $contrast , string $CHANNEL = Imagick::CHANNEL_DEFAULT  ){} 
	/** @return bool */
	 function charcoalImage( float $radius , float $sigma ){} 
	/** @return bool */
	 function chopImage( int $width , int $height , int $x , int $y ){} 
	/** @return void */
	public  function clampImage( string $CHANNEL = Imagick::CHANNEL_DEFAULT  ){} 
	/** @return bool */
	 function clear(){} 
	/** @return bool */
	 function clipImage(){} 
	/** @return void */
	public  function clipImagePath( string $pathname , string $inside ){} 
	/** @return bool */
	 function clipPathImage( string $pathname , bool $inside ){} 
	/** @return Imagick */
	 function clone_(){} 
	/** @return bool */
	 function clutImage( Imagick $lookup_table , float $channel = Imagick::CHANNEL_DEFAULT  ){} 
	/** @return Imagick */
	 function coalesceImages(){} 
	/** @return bool */
	 function colorFloodfillImage( mixed $fill , float $fuzz , mixed $bordercolor , int $x , int $y ){} 
	/** @return bool */
	 function colorizeImage( mixed $colorize , mixed $opacity ){} 
	/** @return void */
	public  function colorMatrixImage( string $color_matrix = Imagick::CHANNEL_DEFAULT ){} 
	/** @return Imagick */
	 function combineImages( int $channelType ){} 
	/** @return bool */
	 function commentImage( string $comment ){} 
	/** @return array */
	 function compareImageChannels( Imagick $image , int $channelType , int $metricType ){} 
	/** @return Imagick */
	 function compareImageLayers( int $method ){} 
	/** @return array */
	 function compareImages( Imagick $compare , int $metric ){} 
	/** @return bool */
	 function compositeImage( Imagick $composite_object , int $composite , int $x , int $y , int $channel = Imagick::CHANNEL_ALL  ){} 
	/** @return void */
	 function __construct( mixed $files ){} 
	/** @return bool */
	 function contrastImage( bool $sharpen ){} 
	/** @return bool */
	 function contrastStretchImage( float $black_point , float $white_point , int $channel = Imagick::CHANNEL_ALL  ){} 
	/** @return bool */
	 function convolveImage( array $kernel , int $channel = Imagick::CHANNEL_ALL  ){} 
	/** @return void */
	public  function count( string $mode  ){} 
	/** @return bool */
	 function cropImage( int $width , int $height , int $x , int $y ){} 
	/** @return bool */
	 function cropThumbnailImage( int $width , int $height ){} 
	/** @return Imagick */
	 function current(){} 
	/** @return bool */
	 function cycleColormapImage( int $displace ){} 
	/** @return bool */
	 function decipherImage( string $passphrase ){} 
	/** @return Imagick */
	 function deconstructImages(){} 
	/** @return bool */
	 function deleteImageArtifact( string $artifact ){} 
	/** @return void */
	public  function deleteImageProperty( string $name ){} 
	/** @return bool */
	public  function deskewImage( float $threshold ){} 
	/** @return bool */
	 function despeckleImage(){} 
	/** @return bool */
	 function destroy(){} 
	/** @return bool */
	 function displayImage( string $servername ){} 
	/** @return bool */
	 function displayImages( string $servername ){} 
	/** @return bool */
	 function distortImage( int $method , array $arguments , bool $bestfit ){} 
	/** @return bool */
	 function drawImage( ImagickDraw $draw ){} 
	/** @return bool */
	 function edgeImage( float $radius ){} 
	/** @return bool */
	 function embossImage( float $radius , float $sigma ){} 
	/** @return bool */
	 function encipherImage( string $passphrase ){} 
	/** @return bool */
	 function enhanceImage(){} 
	/** @return bool */
	 function equalizeImage(){} 
	/** @return bool */
	 function evaluateImage( int $op , float $constant , int $channel = Imagick::CHANNEL_ALL  ){} 
	/** @return array */
	public  function exportImagePixels( int $x , int $y , int $width , int $height , string $map , int $STORAGE ){} 
	/** @return bool */
	 function extentImage( int $width , int $height , int $x , int $y ){} 
	/** @return void */
	public  function filter( ImagickKernel $ImagickKernel , int $CHANNEL = Imagick::CHANNEL_DEFAULT  ){} 
	/** @return Imagick */
	 function flattenImages(){} 
	/** @return bool */
	 function flipImage(){} 
	/** @return bool */
	 function floodFillPaintImage( mixed $fill , float $fuzz , mixed $target , int $x , int $y , bool $invert , int $channel = Imagick::CHANNEL_DEFAULT  ){} 
	/** @return bool */
	 function flopImage(){} 
	/** @return void */
	public  function forwardFourierTransformimage( bool $magnitude ){} 
	/** @return bool */
	 function frameImage( mixed $matte_color , int $width , int $height , int $inner_bevel , int $outer_bevel ){} 
	/** @return bool */
	public  function functionImage( int $function , array $arguments , int $channel = Imagick::CHANNEL_DEFAULT  ){} 
	/** @return Imagick */
	 function fxImage( string $expression , int $channel = Imagick::CHANNEL_ALL  ){} 
	/** @return bool */
	 function gammaImage( float $gamma , int $channel = Imagick::CHANNEL_ALL  ){} 
	/** @return bool */
	 function gaussianBlurImage( float $radius , float $sigma , int $channel = Imagick::CHANNEL_ALL  ){} 
	/** @return int */
	 function getColorspace(){} 
	/** @return int */
	 function getCompression(){} 
	/** @return int */
	 function getCompressionQuality(){} 
	/** @return string */
	 function getCopyright(){} 
	/** @return string */
	 function getFilename(){} 
	/** @return string */
	 function getFont(){} 
	/** @return string */
	 function getFormat(){} 
	/** @return int */
	 function getGravity(){} 
	/** @return string */
	 function getHomeURL(){} 
	/** @return Imagick */
	 function getImage(){} 
	/** @return int */
	 function getImageAlphaChannel(){} 
	/** @return string */
	 function getImageArtifact( string $artifact ){} 
	/** @return string */
	public  function getImageAttribute( string $key ){} 
	/** @return ImagickPixel */
	 function getImageBackgroundColor(){} 
	/** @return string */
	 function getImageBlob(){} 
	/** @return array */
	 function getImageBluePrimary(){} 
	/** @return ImagickPixel */
	 function getImageBorderColor(){} 
	/** @return int */
	 function getImageChannelDepth( int $channel ){} 
	/** @return float */
	 function getImageChannelDistortion( Imagick $reference , int $channel , int $metric ){} 
	/** @return float */
	 function getImageChannelDistortions( Imagick $reference , int $metric , int $channel = Imagick::CHANNEL_DEFAULT  ){} 
	/** @return array */
	 function getImageChannelExtrema( int $channel ){} 
	/** @return array */
	public  function getImageChannelKurtosis( int $channel = Imagick::CHANNEL_DEFAULT  ){} 
	/** @return array */
	 function getImageChannelMean( int $channel ){} 
	/** @return array */
	 function getImageChannelRange( int $channel ){} 
	/** @return array */
	 function getImageChannelStatistics(){} 
	/** @return Imagick */
	 function getImageClipMask(){} 
	/** @return ImagickPixel */
	 function getImageColormapColor( int $index ){} 
	/** @return int */
	 function getImageColors(){} 
	/** @return int */
	 function getImageColorspace(){} 
	/** @return int */
	 function getImageCompose(){} 
	/** @return int */
	 function getImageCompression(){} 
	/** @return int */
	 function getImageCompressionQuality(){} 
	/** @return int */
	 function getImageDelay(){} 
	/** @return int */
	 function getImageDepth(){} 
	/** @return int */
	 function getImageDispose(){} 
	/** @return float */
	 function getImageDistortion( MagickWand $reference , int $metric ){} 
	/** @return array */
	 function getImageExtrema(){} 
	/** @return string */
	 function getImageFilename(){} 
	/** @return string */
	 function getImageFormat(){} 
	/** @return float */
	 function getImageGamma(){} 
	/** @return array */
	 function getImageGeometry(){} 
	/** @return int */
	 function getImageGravity(){} 
	/** @return array */
	 function getImageGreenPrimary(){} 
	/** @return int */
	 function getImageHeight(){} 
	/** @return array */
	 function getImageHistogram(){} 
	/** @return int */
	 function getImageIndex(){} 
	/** @return int */
	 function getImageInterlaceScheme(){} 
	/** @return int */
	 function getImageInterpolateMethod(){} 
	/** @return int */
	 function getImageIterations(){} 
	/** @return int */
	 function getImageLength(){} 
	/** @return string */
	 function getImageMagickLicense(){} 
	/** @return bool */
	 function getImageMatte(){} 
	/** @return ImagickPixel */
	 function getImageMatteColor(){} 
	/** @return string */
	public  function getImageMimeType(){} 
	/** @return int */
	 function getImageOrientation(){} 
	/** @return array */
	 function getImagePage(){} 
	/** @return ImagickPixel */
	 function getImagePixelColor( int $x , int $y ){} 
	/** @return string */
	 function getImageProfile( string $name ){} 
	/** @return array */
	 function getImageProfiles( string $pattern = "*" , bool $only_names = true  ){} 
	/** @return array */
	 function getImageProperties( string $pattern = "*" , bool $only_names = true  ){} 
	/** @return string */
	 function getImageProperty( string $name ){} 
	/** @return array */
	 function getImageRedPrimary(){} 
	/** @return Imagick */
	 function getImageRegion( int $width , int $height , int $x , int $y ){} 
	/** @return int */
	 function getImageRenderingIntent(){} 
	/** @return array */
	 function getImageResolution(){} 
	/** @return string */
	 function getImagesBlob(){} 
	/** @return int */
	 function getImageScene(){} 
	/** @return string */
	 function getImageSignature(){} 
	/** @return int */
	 function getImageSize(){} 
	/** @return int */
	 function getImageTicksPerSecond(){} 
	/** @return float */
	 function getImageTotalInkDensity(){} 
	/** @return int */
	 function getImageType(){} 
	/** @return int */
	 function getImageUnits(){} 
	/** @return int */
	 function getImageVirtualPixelMethod(){} 
	/** @return array */
	 function getImageWhitePoint(){} 
	/** @return int */
	 function getImageWidth(){} 
	/** @return int */
	 function getInterlaceScheme(){} 
	/** @return int */
	 function getIteratorIndex(){} 
	/** @return int */
	 function getNumberImages(){} 
	/** @return string */
	 function getOption( string $key ){} 
	/** @return string */
	 function getPackageName(){} 
	/** @return array */
	 function getPage(){} 
	/** @return ImagickPixelIterator */
	 function getPixelIterator(){} 
	/** @return ImagickPixelIterator */
	 function getPixelRegionIterator( int $x , int $y , int $columns , int $rows ){} 
	/** @return float */
	 function getPointSize(){} 
	/** @return int */
	public static  function getQuantum(){} 
	/** @return array */
	 function getQuantumDepth(){} 
	/** @return array */
	 function getQuantumRange(){} 
	/** @return string */
	public static  function getRegistry( string $key ){} 
	/** @return string */
	 function getReleaseDate(){} 
	/** @return int */
	 function getResource( int $type ){} 
	/** @return int */
	 function getResourceLimit( int $type ){} 
	/** @return array */
	 function getSamplingFactors(){} 
	/** @return array */
	 function getSize(){} 
	/** @return int */
	 function getSizeOffset(){} 
	/** @return array */
	 function getVersion(){} 
	/** @return bool */
	public  function haldClutImage( Imagick $clut , int $channel = Imagick::CHANNEL_DEFAULT  ){} 
	/** @return bool */
	 function hasNextImage(){} 
	/** @return bool */
	 function hasPreviousImage(){} 
	/** @return string|false */
	public  function identifyFormat( string $embedText ){} 
	/** @return array */
	 function identifyImage( bool $appendRawOutput = false  ){} 
	/** @return bool */
	 function implodeImage( float $radius ){} 
	/** @return bool */
	public  function importImagePixels( int $x , int $y , int $width , int $height , string $map , int $storage , array $pixels ){} 
	/** @return void */
	public  function inverseFourierTransformImage( string $complement , string $magnitude ){} 
	/** @return bool */
	 function labelImage( string $label ){} 
	/** @return bool */
	 function levelImage( float $blackPoint , float $gamma , float $whitePoint , int $channel = Imagick::CHANNEL_ALL  ){} 
	/** @return bool */
	 function linearStretchImage( float $blackPoint , float $whitePoint ){} 
	/** @return bool */
	 function liquidRescaleImage( int $width , int $height , float $delta_x , float $rigidity ){} 
	/** @return array */
	public static  function listRegistry(){} 
	/** @return bool */
	 function magnifyImage(){} 
	/** @return bool */
	 function mapImage( Imagick $map , bool $dither ){} 
	/** @return bool */
	 function matteFloodfillImage( float $alpha , float $fuzz , mixed $bordercolor , int $x , int $y ){} 
	/** @return bool */
	 function medianFilterImage( float $radius ){} 
	/** @return Imagick */
	 function mergeImageLayers( int $layer_method ){} 
	/** @return bool */
	 function minifyImage(){} 
	/** @return bool */
	 function modulateImage( float $brightness , float $saturation , float $hue ){} 
	/** @return Imagick */
	 function montageImage( ImagickDraw $draw , string $tile_geometry , string $thumbnail_geometry , int $mode , string $frame ){} 
	/** @return Imagick */
	 function morphImages( int $number_frames ){} 
	/** @return void */
	public  function morphology( int $morphologyMethod , int $iterations , ImagickKernel $ImagickKernel , string $CHANNEL  ){} 
	/** @return Imagick */
	 function mosaicImages(){} 
	/** @return bool */
	 function motionBlurImage( float $radius , float $sigma , float $angle , int $channel = Imagick::CHANNEL_DEFAULT  ){} 
	/** @return bool */
	 function negateImage( bool $gray , int $channel = Imagick::CHANNEL_ALL  ){} 
	/** @return bool */
	 function newImage( int $cols , int $rows , mixed $background , string $format  ){} 
	/** @return bool */
	 function newPseudoImage( int $columns , int $rows , string $pseudoString ){} 
	/** @return bool */
	 function nextImage(){} 
	/** @return bool */
	 function normalizeImage( int $channel = Imagick::CHANNEL_ALL  ){} 
	/** @return bool */
	 function oilPaintImage( float $radius ){} 
	/** @return bool */
	 function opaquePaintImage( mixed $target , mixed $fill , float $fuzz , bool $invert , int $channel = Imagick::CHANNEL_DEFAULT  ){} 
	/** @return bool */
	 function optimizeImageLayers(){} 
	/** @return bool */
	 function orderedPosterizeImage( string $threshold_map , int $channel = Imagick::CHANNEL_ALL  ){} 
	/** @return bool */
	 function paintFloodfillImage( mixed $fill , float $fuzz , mixed $bordercolor , int $x , int $y , int $channel = Imagick::CHANNEL_ALL  ){} 
	/** @return bool */
	 function paintOpaqueImage( mixed $target , mixed $fill , float $fuzz , int $channel = Imagick::CHANNEL_ALL  ){} 
	/** @return bool */
	 function paintTransparentImage( mixed $target , float $alpha , float $fuzz ){} 
	/** @return bool */
	 function pingImage( string $filename ){} 
	/** @return bool */
	 function pingImageBlob( string $image ){} 
	/** @return bool */
	 function pingImageFile( resource $filehandle , string $fileName  ){} 
	/** @return bool */
	 function polaroidImage( ImagickDraw $properties , float $angle ){} 
	/** @return bool */
	 function posterizeImage( int $levels , bool $dither ){} 
	/** @return bool */
	 function previewImages( int $preview ){} 
	/** @return bool */
	 function previousImage(){} 
	/** @return bool */
	 function profileImage( string $name , string $profile ){} 
	/** @return bool */
	 function quantizeImage( int $numberColors , int $colorspace , int $treedepth , bool $dither , bool $measureError ){} 
	/** @return bool */
	 function quantizeImages( int $numberColors , int $colorspace , int $treedepth , bool $dither , bool $measureError ){} 
	/** @return array */
	 function queryFontMetrics( ImagickDraw $properties , string $text , bool $multiline  ){} 
	/** @return array */
	 function queryFonts( string $pattern = "*"  ){} 
	/** @return array */
	 function queryFormats( string $pattern = "*"  ){} 
	/** @return bool */
	 function radialBlurImage( float $angle , int $channel = Imagick::CHANNEL_ALL  ){} 
	/** @return bool */
	 function raiseImage( int $width , int $height , int $x , int $y , bool $raise ){} 
	/** @return bool */
	 function randomThresholdImage( float $low , float $high , int $channel = Imagick::CHANNEL_ALL  ){} 
	/** @return bool */
	 function readImage( string $filename ){} 
	/** @return bool */
	 function readImageBlob( string $image , string $filename  ){} 
	/** @return bool */
	 function readImageFile( resource $filehandle , string $fileName = null  ){} 
	/** @return Imagick */
	public  function readImages( string $filenames ){} 
	/** @return bool */
	 function recolorImage( array $matrix ){} 
	/** @return bool */
	 function reduceNoiseImage( float $radius ){} 
	/** @return bool */
	public  function remapImage( Imagick $replacement , int $DITHER ){} 
	/** @return bool */
	 function removeImage(){} 
	/** @return string */
	 function removeImageProfile( string $name ){} 
	/** @return bool */
	 function render(){} 
	/** @return bool */
	 function resampleImage( float $x_resolution , float $y_resolution , int $filter , float $blur ){} 
	/** @return bool */
	 function resetImagePage( string $page ){} 
	/** @return bool */
	 function resizeImage( int $columns , int $rows , int $filter , float $blur , bool $bestfit = false  ){} 
	/** @return bool */
	 function rollImage( int $x , int $y ){} 
	/** @return bool */
	 function rotateImage( mixed $background , float $degrees ){} 
	/** @return void */
	public  function rotationalBlurImage( string $angle , string $CHANNEL = Imagick::CHANNEL_DEFAULT  ){} 
	/** @return bool */
	 function roundCorners( float $x_rounding , float $y_rounding , float $stroke_width = 10 , float $displace = 5 , float $size_correction = -6  ){} 
	/** @return bool */
	 function sampleImage( int $columns , int $rows ){} 
	/** @return bool */
	 function scaleImage( int $cols , int $rows , bool $bestfit = false  ){} 
	/** @return bool */
	public  function segmentImage( int $COLORSPACE , float $cluster_threshold , float $smooth_threshold , bool $verbose = false  ){} 
	/** @return void */
	public  function selectiveBlurImage( float $radius , float $sigma , float $threshold , int $CHANNEL ){} 
	/** @return bool */
	 function separateImageChannel( int $channel ){} 
	/** @return bool */
	 function sepiaToneImage( float $threshold ){} 
	/** @return bool */
	 function setBackgroundColor( mixed $background ){} 
	/** @return bool */
	 function setColorspace( int $COLORSPACE ){} 
	/** @return bool */
	 function setCompression( int $compression ){} 
	/** @return bool */
	 function setCompressionQuality( int $quality ){} 
	/** @return bool */
	 function setFilename( string $filename ){} 
	/** @return bool */
	 function setFirstIterator(){} 
	/** @return bool */
	 function setFont( string $font ){} 
	/** @return bool */
	 function setFormat( string $format ){} 
	/** @return bool */
	 function setGravity( int $gravity ){} 
	/** @return bool */
	 function setImage( Imagick $replace ){} 
	/** @return bool */
	 function setImageAlphaChannel( int $mode ){} 
	/** @return bool */
	 function setImageArtifact( string $artifact , string $value ){} 
	/** @return void */
	public  function setImageAttribute( string $key , string $value ){} 
	/** @return bool */
	 function setImageBackgroundColor( mixed $background ){} 
	/** @return bool */
	 function setImageBias( float $bias ){} 
	/** @return void */
	public  function setImageBiasQuantum( string $bias ){} 
	/** @return bool */
	 function setImageBluePrimary( float $x , float $y ){} 
	/** @return bool */
	 function setImageBorderColor( mixed $border ){} 
	/** @return bool */
	 function setImageChannelDepth( int $channel , int $depth ){} 
	/** @return bool */
	 function setImageClipMask( Imagick $clip_mask ){} 
	/** @return bool */
	 function setImageColormapColor( int $index , ImagickPixel $color ){} 
	/** @return bool */
	 function setImageColorspace( int $colorspace ){} 
	/** @return bool */
	 function setImageCompose( int $compose ){} 
	/** @return bool */
	 function setImageCompression( int $compression ){} 
	/** @return bool */
	 function setImageCompressionQuality( int $quality ){} 
	/** @return bool */
	 function setImageDelay( int $delay ){} 
	/** @return bool */
	 function setImageDepth( int $depth ){} 
	/** @return bool */
	 function setImageDispose( int $dispose ){} 
	/** @return bool */
	 function setImageExtent( int $columns , int $rows ){} 
	/** @return bool */
	 function setImageFilename( string $filename ){} 
	/** @return bool */
	 function setImageFormat( string $format ){} 
	/** @return bool */
	 function setImageGamma( float $gamma ){} 
	/** @return bool */
	 function setImageGravity( int $gravity ){} 
	/** @return bool */
	 function setImageGreenPrimary( float $x , float $y ){} 
	/** @return bool */
	 function setImageIndex( int $index ){} 
	/** @return bool */
	 function setImageInterlaceScheme( int $interlace_scheme ){} 
	/** @return bool */
	 function setImageInterpolateMethod( int $method ){} 
	/** @return bool */
	 function setImageIterations( int $iterations ){} 
	/** @return bool */
	 function setImageMatte( bool $matte ){} 
	/** @return bool */
	 function setImageMatteColor( mixed $matte ){} 
	/** @return bool */
	 function setImageOpacity( float $opacity ){} 
	/** @return bool */
	 function setImageOrientation( int $orientation ){} 
	/** @return bool */
	 function setImagePage( int $width , int $height , int $x , int $y ){} 
	/** @return bool */
	 function setImageProfile( string $name , string $profile ){} 
	/** @return bool */
	 function setImageProperty( string $name , string $value ){} 
	/** @return bool */
	 function setImageRedPrimary( float $x , float $y ){} 
	/** @return bool */
	 function setImageRenderingIntent( int $rendering_intent ){} 
	/** @return bool */
	 function setImageResolution( float $x_resolution , float $y_resolution ){} 
	/** @return bool */
	 function setImageScene( int $scene ){} 
	/** @return bool */
	 function setImageTicksPerSecond( int $ticks_per_second ){} 
	/** @return bool */
	 function setImageType( int $image_type ){} 
	/** @return bool */
	 function setImageUnits( int $units ){} 
	/** @return bool */
	 function setImageVirtualPixelMethod( int $method ){} 
	/** @return bool */
	 function setImageWhitePoint( float $x , float $y ){} 
	/** @return bool */
	 function setInterlaceScheme( int $interlace_scheme ){} 
	/** @return bool */
	 function setIteratorIndex( int $index ){} 
	/** @return bool */
	 function setLastIterator(){} 
	/** @return bool */
	 function setOption( string $key , string $value ){} 
	/** @return bool */
	 function setPage( int $width , int $height , int $x , int $y ){} 
	/** @return bool */
	 function setPointSize( float $point_size ){} 
	/** @return void */
	public  function setProgressMonitor( callable $callback ){} 
	/** @return void */
	public static  function setRegistry( string $key , string $value ){} 
	/** @return bool */
	 function setResolution( float $x_resolution , float $y_resolution ){} 
	/** @return bool */
	 function setResourceLimit( int $type , int $limit ){} 
	/** @return bool */
	 function setSamplingFactors( array $factors ){} 
	/** @return bool */
	 function setSize( int $columns , int $rows ){} 
	/** @return bool */
	 function setSizeOffset( int $columns , int $rows , int $offset ){} 
	/** @return bool */
	 function setType( int $image_type ){} 
	/** @return bool */
	 function shadeImage( bool $gray , float $azimuth , float $elevation ){} 
	/** @return bool */
	 function shadowImage( float $opacity , float $sigma , int $x , int $y ){} 
	/** @return bool */
	 function sharpenImage( float $radius , float $sigma , int $channel = Imagick::CHANNEL_ALL  ){} 
	/** @return bool */
	 function shaveImage( int $columns , int $rows ){} 
	/** @return bool */
	 function shearImage( mixed $background , float $x_shear , float $y_shear ){} 
	/** @return bool */
	 function sigmoidalContrastImage( bool $sharpen , float $alpha , float $beta , int $channel = Imagick::CHANNEL_ALL  ){} 
	/** @return bool */
	 function sketchImage( float $radius , float $sigma , float $angle ){} 
	/** @return Imagick */
	public  function smushImages( string $stack , string $offset ){} 
	/** @return bool */
	 function solarizeImage( int $threshold ){} 
	/** @return bool */
	public  function sparseColorImage( int $SPARSE_METHOD , array $arguments , int $channel = Imagick::CHANNEL_DEFAULT  ){} 
	/** @return bool */
	 function spliceImage( int $width , int $height , int $x , int $y ){} 
	/** @return bool */
	 function spreadImage( float $radius ){} 
	/** @return void */
	public  function statisticImage( int $type , int $width , int $height , string $CHANNEL = Imagick::CHANNEL_DEFAULT  ){} 
	/** @return Imagick */
	 function steganoImage( Imagick $watermark_wand , int $offset ){} 
	/** @return bool */
	 function stereoImage( Imagick $offset_wand ){} 
	/** @return bool */
	 function stripImage(){} 
	/** @return Imagick */
	public  function subImageMatch( Imagick $Imagick , array &$offset , float &$similarity  ){} 
	/** @return bool */
	 function swirlImage( float $degrees ){} 
	/** @return bool */
	 function textureImage( Imagick $texture_wand ){} 
	/** @return bool */
	 function thresholdImage( float $threshold , int $channel = Imagick::CHANNEL_ALL  ){} 
	/** @return bool */
	 function thumbnailImage( int $columns , int $rows , bool $bestfit = false , bool $fill = false  ){} 
	/** @return bool */
	 function tintImage( mixed $tint , mixed $opacity ){} 
	/** @return string */
	 function __toString(){} 
	/** @return Imagick */
	 function transformImage( string $crop , string $geometry ){} 
	/** @return bool */
	 function transformImageColorspace( int $colorspace ){} 
	/** @return bool */
	 function transparentPaintImage( mixed $target , float $alpha , float $fuzz , bool $invert ){} 
	/** @return bool */
	 function transposeImage(){} 
	/** @return bool */
	 function transverseImage(){} 
	/** @return bool */
	 function trimImage( float $fuzz ){} 
	/** @return bool */
	 function uniqueImageColors(){} 
	/** @return bool */
	 function unsharpMaskImage( float $radius , float $sigma , float $amount , float $threshold , int $channel = Imagick::CHANNEL_ALL  ){} 
	/** @return bool */
	 function valid(){} 
	/** @return bool */
	 function vignetteImage( float $blackPoint , float $whitePoint , int $x , int $y ){} 
	/** @return bool */
	 function waveImage( float $amplitude , float $length ){} 
	/** @return bool */
	 function whiteThresholdImage( mixed $threshold ){} 
	/** @return bool */
	 function writeImage( string $filename = NULL  ){} 
	/** @return bool */
	 function writeImageFile( resource $filehandle ){} 
	/** @return bool */
	 function writeImages( string $filename , bool $adjoin ){} 
	/** @return bool */
	 function writeImagesFile( resource $filehandle ){} 
}

