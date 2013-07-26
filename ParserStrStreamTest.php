<?php

require('ParserStrStream.php');

class ParserStrStreamTest extends PHPUnit_Framework_TestCase {
	public function testMultiByteLength() {
		$str = new ParserStrStream('â');
		$this->assertEquals(1, $str->len());
	}
	
	public function eatUntilChar() {
		$str = new ParserStrStream('âêîôû!');
		$trash = $str->eatUntilChar('û');
		$this->assertEquals('âêîô', $trash);
		$this->assertEquals('!', $str->cur());
	}
	
	public function testNextPrevBoundsHandling() {
		$str = new ParserStrStream('âêîôû');
		$this->assertEquals(false, $str->prev());
		for ($i=0; $i<$str->len(); $i++) {
			$this->assertEquals(true, $str->next() !== false);
		}
		$this->assertEquals(false, $str->next());
	}
	
	public function testRefCopying() {
		$str = 'test test test';
		$old = new ParserStrStream($str);
		$new = ParserStrStream::createRefCopy($old);
		
		do {
			$this->assertEquals($old->cur(), $new->cur());
		} while($old->moveNext() && $new->moveNext());
	}
}