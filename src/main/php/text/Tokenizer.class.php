<?php namespace text;

use Traversable, IteratorAggregate;

/**
 * A tokenizer splits input strings into tokens.
 * 
 * @see   text.StringTokenizer
 * @see   text.StreamTokenizer
 */
abstract class Tokenizer implements IteratorAggregate {
  public $delimiters;
  public $returnDelims;
  protected $source;
  
  /**
   * Constructor
   *
   * @param  var $source
   * @param  string $delimiters default ' '
   * @param  bool $returnDelims default FALSE
   */
  public function __construct($source, $delimiters= ' ', $returnDelims= false) {
    $this->delimiters= $delimiters;
    $this->returnDelims= $returnDelims;
    $this->source= $source;
    $this->reset();
  }
  
  /** Returns an iterator for use in foreach() */
  public function getIterator(): Traversable {
    while ($this->hasMoreTokens()) {
      yield $this->nextToken();
    }
  }

  /**
   * Push back a string
   *
   * @param  string $str
   * @return void
   */
  public abstract function pushBack($str);
  
  /**
   * Reset this tokenizer
   *
   * @return void
   */
  public abstract function reset();
  
  /**
   * Tests if there are more tokens available
   *
   * @return bool
   */
  public abstract function hasMoreTokens();
  
  /**
   * Returns the next token from this tokenizer's string
   *
   * @param  ?string $delimiters
   * @return string
   */
  public abstract function nextToken($delimiters= null);
}