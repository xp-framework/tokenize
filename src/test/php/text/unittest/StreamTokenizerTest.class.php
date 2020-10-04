<?php namespace text\unittest;

use io\streams\MemoryInputStream;
use text\StreamTokenizer;

class StreamTokenizerTest extends AbstractTokenizerTest {

  /**
   * Retrieve a tokenizer instance
   *
   * @param   string source
   * @param   string delimiters default ' '
   * @param   bool returnDelims default FALSE
   * @return  text.Tokenizer
   */
  protected function tokenizerInstance($source, $delimiters= ' ', $returnDelims= false) {
    return new StreamTokenizer(new MemoryInputStream($source), $delimiters, $returnDelims);
  }
}