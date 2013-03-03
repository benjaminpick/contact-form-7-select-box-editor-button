<?php

require_once(dirname(__FILE__) . '/PluginTestTemplate.php');

function test_formatValues($name, $email)
{
	return array('name' => $name, 'email' => $email);
}

class Wpcf7SimpleRegexParserTest extends PluginTestTemplate
{
	function setUp()
	{
		parent::setUp();
		$this->parser = new Wpcf7_SelectBoxEditorButton_SimpleRegexParser('test_formatValues');
	}
	
	function testExtractAdresses()
	{
		$text = '[select* recipient id:recipient "John Doe|jondoe@example.org" "Max Mustermann|maxmustermann@example.org"]';
		$parsed = array(
				array('name' => 'John Doe', 'email' => 'jondoe@example.org'),
				array('name' => 'Max Mustermann', 'email' => 'maxmustermann@example.org'),
		);
		$this->assertSame($parsed, $this->parser->getAdressesFromFormText($text));
	}
	
	function testExtractAdressesCount()
	{
		$text = '[select* recipient id:recipient "John Doe|jondoe@example.org" "Max Mustermann|maxmustermann@example.org"]';
		$this->assertCount(2, $this->parser->getAdressesFromFormText($text));

		$text = '[select* recipient id:recipient "Jöhn Dœe|jondoe@example.org" "Mäx Mußtermann|maxmustermann@example.org"]';
		$this->assertCount(2, $this->parser->getAdressesFromFormText($text), "UTF-8");
		
		$text = '[select* recipient id:recipient "John Doe|jondoe@example.org" ]';
		$this->assertCount(1, $this->parser->getAdressesFromFormText($text), "One w/ space");
		
		$text = '[select* recipient id:recipient "John Doe|jondoe@example.org"]';
		$this->assertCount(1, $this->parser->getAdressesFromFormText($text), "One");
		
		// Skip when not an email adress
		$text = '[select* recipient id:recipient "John Doe|jondoeexample.org" "Max Mustermann|maxmustermann@example.org"]';
		$this->assertCount(1, $this->parser->getAdressesFromFormText($text), "Skip when not an email adress");
	}
	
	function testFormTextValidFormatValid()
	{
		// From documentation
		$text = '[select* recipient id:recipient "John Doe|jondoe@example.org" "Max Mustermann|maxmustermann@example.org"]';
		$this->assertTrue(is_array($this->parser->getAdressesFromFormText($text)), "From Documentation");

		// More options
		$text = '[select* recipient class:test id:recipient tabindex:3 some_other_option "John Doe|jondoe@example.org" "Max Mustermann|maxmustermann@example.org"]';
		$this->assertTrue(is_array($this->parser->getAdressesFromFormText($text)), "More options");
		
		// Different name
		$text = '[select* differentname id:recipient "John Doe|jondoe@example.org" "Max Mustermann|maxmustermann@example.org"]';
		$this->assertTrue(is_array($this->parser->getAdressesFromFormText($text)), "Different Name");

		// Select not required
		$text = '[select recipient id:recipient "John Doe|jondoe@example.org" "Max Mustermann|maxmustermann@example.org"]';
		$this->assertTrue(is_array($this->parser->getAdressesFromFormText($text)), "Select not required");

		// Spaces
		$text = '[select*   recipient     id:recipient   "John Doe|jondoe@example.org"   "Max Mustermann|maxmustermann@example.org"   ]';
		$this->assertTrue(is_array($this->parser->getAdressesFromFormText($text)), "Spaces");

	}

	function testFormTextValidFormatInvalid()
	{
		// missing id:recipient
		$text = '[select* recipient "John Doe|jondoe@example.org" "Max Mustermann|maxmustermann@example.org"]';
		$this->assertInternalType('string', $this->parser->getAdressesFromFormText($text), "id:recipient is missing, but no error was thrown");

		// wrong id
		$text = '[select* recipient id:wrongid "John Doe|jondoe@example.org" "Max Mustermann|maxmustermann@example.org"]';
		$this->assertInternalType('string', $this->parser->getAdressesFromFormText($text), "id:wrongid is working, but it shouldn't!");
		
		// Empty select
		$text = '[select recipient id:recipient]';
		$this->assertInternalType('string', $this->parser->getAdressesFromFormText($text)	, "Empty select");

		// id:recipient at wrong place
		$text = '<p>Recipient: [select* id:recipient recipient "Second Form|test@d.org" "Second Form 2|test@d.org"]</p>';
		$this->assertInternalType('string', $this->parser->getAdressesFromFormText($text), "id:recipient is at wrong place, but no error was thrown");
	}
	
	function testEntireForm()
	{
		$text = <<<FORM
<p>Recipient: [select* recipient id:recipient "John Doe|jondoe@example.org" "Max Mustermann|maxmustermann@example.org"]</p>

<p>Your Name (required)<br />
    [text* your-name] </p>

<p>Your Email (required)<br />
    [email* your-email] </p>

<p>Subject<br />
    [text your-subject] </p>

<p>Your Message<br />
    [textarea your-message] </p>

<p>[submit "Send"]</p>
FORM;
		$parsed = $this->parser->getAdressesFromFormText($text);
		$this->assertInternalType('array', $parsed, "Error: " . $parsed);
		$this->assertCount(2, $parsed);
		
		$text = <<<FORM
<p>Favorite Meal: [select* meal id:meal "Spaggetti|Spaggetti@example.org" "Pizza|pizza@example.org"]</p>
		
<p>Recipient: [select* recipient id:recipient "John Doe|jondoe@example.org" "Max Mustermann|maxmustermann@example.org"]</p>
		
<p>Your Name (required)<br />
    [text* your-name] </p>
		
<p>Your Email (required)<br />
    [email* your-email] </p>
		
<p>Subject<br />
    [text your-subject] </p>
		
<p>Your Message<br />
    [textarea your-message] </p>
		
<p>[submit "Send"]</p>
FORM;
		$parsed = $this->parser->getAdressesFromFormText($text);
		$this->assertInternalType('array', $parsed, "2nd select Error: " . $parsed);
		$this->assertCount(2, $parsed, "2nd select");
		
		$text = <<<FORM
<p>Recipient: [select* recipient id:recipient "John Doe|jondoe@example.org" "Max Mustermann|maxmustermann@example.org"]</p>
				
<p>Favorite Meal: [select* meal id:meal "Spaggetti|Spaggetti@example.org" "Pizza|pizza@example.org"]</p>
				
<p>Your Name (required)<br />
    [text* your-name] </p>
		
<p>Your Email (required)<br />
    [email* your-email] </p>
		
<p>Subject<br />
    [text your-subject] </p>
		
<p>Your Message<br />
    [textarea your-message] </p>
		
<p>[submit "Send"]</p>
FORM;
		$parsed = $this->parser->getAdressesFromFormText($text);
		$this->assertInternalType('array', $parsed, "2nd select Error: " . $parsed);
		$this->assertCount(2, $parsed, "2nd select");
		
	}
	
}

class Wpcf7SimpleRegexWpcf7ParserTest extends Wpcf7SimpleRegexParserTest
{
	function setUp()
	{
		parent::setUp();
		$this->parser = new Wpcf7_SelectBoxEditorButton_Wpcf7_Shortcode_Parser('test_formatValues');
	}
	
	function testEmailAdressesOnly()
	{
		// Email adress only
		$text = '[select* recipient id:recipient "jondoe@example.org" "maxmustermann@example.org"]';
		$this->assertTrue(is_array($this->parser->getAdressesFromFormText($text)), "Email adresses only");
		
		// Email adress only
		$text = '[select* recipient id:recipient "jondoe@example.org" "maxmustermann@example.org"]';
		$this->assertCount(2, $this->parser->getAdressesFromFormText($text), "Email adresses only");
	}
}