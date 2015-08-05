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
