<?php namespace text\unittest;

use unittest\Assert;
use unittest\{Ignore, Test, TestCase};

/**
 * Abstract base class for different tokenizer tests
 *
 * @see   xp://text.Tokenizer
 * @see   xp://net.xp_framework.unittest.text.StringTokenizerTest
 * @see   xp://net.xp_framework.unittest.text.StreamTokenizerTest
 */
abstract class AbstractTokenizerTest {

  /**
   * Retrieve a tokenizer instance
   *
   * @param   string $source
   * @param   string $delimiters
   * @param   bool $returnDelims
   * @return  text.Tokenizer
   */
  protected abstract function tokenizerInstance($source, $delimiters= ' ', $returnDelims= false);

  /**
   * Returns all tokens
   *
   * @param   string input
   * @param   string delim
   * @return  string[] tokens
   */
  protected function allTokens($input, $delim) {
    $t= $this->tokenizerInstance($input, $delim, true);
    $tokens= [];
    while ($t->hasMoreTokens()) {
      $token= $t->nextToken();
      if ('/' === $token) {
        $next= $t->nextToken();
        if ('/' === $next) {
          $token.= $next.$t->nextToken("\n");
        } else {
          $t->pushBack($next);
        }
      }
      $tokens[]= $token;
    }
    return $tokens;
  }

  #[Test]
  public function testSimpleString() {
    $t= $this->tokenizerInstance("Hello World!\nThis is an example", " \n");
    Assert::equals('Hello', $t->nextToken());
    Assert::equals('World!', $t->nextToken());
    Assert::equals('This', $t->nextToken());
    Assert::equals('is', $t->nextToken());
    Assert::equals('an', $t->nextToken());
    Assert::equals('example', $t->nextToken());
    Assert::false($t->hasMoreTokens());
  }

  #[Test]
  public function testSimpleStringWithDelims() {
    $t= $this->tokenizerInstance("Hello World!\nThis is an example", " \n", true);
    Assert::equals('Hello', $t->nextToken());
    Assert::equals(' ', $t->nextToken());
    Assert::equals('World!', $t->nextToken());
    Assert::equals("\n", $t->nextToken());
    Assert::equals('This', $t->nextToken());
    Assert::equals(' ', $t->nextToken());
    Assert::equals('is', $t->nextToken());
    Assert::equals(' ', $t->nextToken());
    Assert::equals('an', $t->nextToken());
    Assert::equals(' ', $t->nextToken());
    Assert::equals('example', $t->nextToken());
    Assert::false($t->hasMoreTokens());
  }
  
  #[Test]
  public function repetetiveDelimiters() {
    $t= $this->tokenizerInstance("Hello \nWorld!", " \n");
    Assert::equals('Hello', $t->nextToken());
    Assert::equals('', $t->nextToken());
    Assert::equals('World!', $t->nextToken());
    Assert::false($t->hasMoreTokens());
  }

  #[Test]
  public function repetetiveDelimitersWithDelims() {
    $t= $this->tokenizerInstance("Hello \nWorld!", " \n", true);
    Assert::equals('Hello', $t->nextToken());
    Assert::equals(' ', $t->nextToken());
    Assert::equals("\n", $t->nextToken());
    Assert::equals('World!', $t->nextToken());
    Assert::false($t->hasMoreTokens());
  }
  
  #[Test]
  public function forIteration() {
    $r= [];
    for ($t= $this->tokenizerInstance('A B C', ' '); $t->hasMoreTokens(); ) {
      $r[]= $t->nextToken();
    }
    Assert::equals(range('A', 'C'), $r);
  }

  #[Test]
  public function whileIteration() {
    $r= [];
    $t= $this->tokenizerInstance('A B C', ' ');
    while ($t->hasMoreTokens()) {
      $r[]= $t->nextToken();
    }
    Assert::equals(range('A', 'C'), $r);
  }

  #[Test]
  public function foreachIteration() {
    $r= [];
    foreach ($this->tokenizerInstance('A B C', ' ') as $token) {
      $r[]= $token;
    }
    Assert::equals(range('A', 'C'), $r);
  }

  #[Test]
  public function reset() {
    $t= $this->tokenizerInstance('A B C', ' ');
    Assert::true($t->hasMoreTokens());
    Assert::equals('A', $t->nextToken());
    $t->reset();
    Assert::true($t->hasMoreTokens());
    Assert::equals('A', $t->nextToken());
  }

  #[Test]
  public function pushBackTokens() {
    $t= $this->tokenizerInstance('1,2,5', ',');
    Assert::equals('1', $t->nextToken());
    Assert::equals('2', $t->nextToken());
    $t->pushBack('3,4,');
    Assert::equals('3', $t->nextToken());
    Assert::equals('4', $t->nextToken());
    Assert::equals('5', $t->nextToken());
  }

  #[Test]
  public function pushBackOrder() {
    $t= $this->tokenizerInstance('1,2,5', ',');
    Assert::equals('1', $t->nextToken());
    Assert::equals('2', $t->nextToken());
    $t->pushBack('4,');
    $t->pushBack('3,');
    Assert::equals('3', $t->nextToken());
    Assert::equals('4', $t->nextToken());
    Assert::equals('5', $t->nextToken());
  }

  #[Test]
  public function pushBackDelimiterAtEnd() {
    $t= $this->tokenizerInstance("One\nTwo", "\n");
    Assert::equals('One', $t->nextToken());
    Assert::equals('Two', $t->nextToken());
    $t->pushBack("Two\n");
    Assert::equals('Two', $t->nextToken());
  }

  #[Test]
  public function pushBackDelimiter() {
    Assert::equals(
      ['// This is a one-line comment', "\n", 'a', '=', ' ', 'b', ' ', '/', ' ', 'c', ';'],
      $this->allTokens("// This is a one-line comment\na= b / c;", "/\n =;", "/\n =;")
    );
  }

  #[Test]
  public function pushBackRegex() {
    Assert::equals(
      ['var', ' ', 'pattern', ' ', '=', ' ', '/', '0?([0-9]+)\.0?([0-9]+)(\.0?([0-9]+))?', '/', ';'],
      $this->allTokens('var pattern = /0?([0-9]+)\.0?([0-9]+)(\.0?([0-9]+))?/;', "/\n =;")
    );
  }

  #[Test]
  public function pushBackAfterHavingReadUntilEnd() {
    $t= $this->tokenizerInstance('1,2,', ',');
    Assert::equals('1', $t->nextToken());
    Assert::equals('2', $t->nextToken());
    Assert::false($t->hasMoreTokens(), 'Should be at end');
    $t->pushBack('6,7');
    Assert::true($t->hasMoreTokens(), 'Should have tokens after pushing back');
    Assert::equals('6', $t->nextToken(), 'Should yield token pushed back');
    Assert::equals('7', $t->nextToken(), 'Should yield token pushed back');
    Assert::false($t->hasMoreTokens(), 'Should be at end again');
  }

  #[Test]
  public function pushBackWithDelimitersAfterHavingReadUntilEnd() {
    $t= $this->tokenizerInstance('1,2,', ',', true);
    Assert::equals('1', $t->nextToken());
    Assert::equals(',', $t->nextToken());
    Assert::equals('2', $t->nextToken());
    Assert::equals(',', $t->nextToken());
    Assert::false($t->hasMoreTokens(), 'Should be at end');
    $t->pushBack('6,7');
    Assert::true($t->hasMoreTokens(), 'Should have tokens after pushing back');
    Assert::equals('6', $t->nextToken(), 'Should yield token pushed back');
    Assert::equals(',', $t->nextToken());
    Assert::equals('7', $t->nextToken(), 'Should yield token pushed back');
    Assert::false($t->hasMoreTokens(), 'Should be at end again');
  }

  #[Test, Ignore('Remove ignore annotation to test performance')]
  public function performance() {
  
    // Create a string with 10000 tokens
    $input= '';
    for ($i= 0; $i < 10000; $i++) {
      $input.= str_repeat('*', rand(0, 76))."\n";
    }
    
    // Tokenize it
    $t= $this->tokenizerInstance($input, "\n", false);
    while ($t->hasMoreTokens()) {
      $token= $t->nextToken();
    }
  }

  #[Test]
  public function reading_past_end_returns_null() {
    $t= $this->tokenizerInstance('Test', "\n", false);
    while ($t->hasMoreTokens()) {
      $t->nextToken();
    }
    Assert::equals([null, null], [$t->nextToken(), $t->nextToken()]);
  }
}