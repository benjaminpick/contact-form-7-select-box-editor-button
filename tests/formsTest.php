<?php

require_once(dirname(__FILE__) . '/PluginTestTemplate.php');

class FormsTest extends PluginTestTemplate
{
	function testExtractAdresses()
	{
		$text = '[select* recipient id:recipient "John Doe|jondoe@example.org" "Max Mustermann|maxmustermann@example.org"]';
		$this->assertCount(2, $this->pluginObject->getAdressesFromFormText($text));

		$text = '[select* recipient id:recipient "John Doe|jondoe@example.org" ]';
		$this->assertCount(1, $this->pluginObject->getAdressesFromFormText($text), "One w/ space");
		
		$text = '[select* recipient id:recipient "John Doe|jondoe@example.org"]';
		$this->assertCount(1, $this->pluginObject->getAdressesFromFormText($text), "One");
		
		// Skip when not an email adress
		$text = '[select* recipient id:recipient "John Doe|jondoeexample.org" "Max Mustermann|maxmustermann@example.org"]';
		$this->assertCount(1, $this->pluginObject->getAdressesFromFormText($text), "Skip when not an email adress");
		
		// Email adress only
		$text = '[select* recipient id:recipient "jondoe@example.org" "maxmustermann@example.org"]';
		$this->assertCount(2, $this->pluginObject->getAdressesFromFormText($text), "Email adresses only");
	}
	
	function testFormTextValidFormatValid()
	{
		// From documentation
		$text = '[select* recipient id:recipient "John Doe|jondoe@example.org" "Max Mustermann|maxmustermann@example.org"]';
		$this->assertTrue(is_array($this->pluginObject->getAdressesFromFormText($text)), "From Documentation");

		// More options
		$text = '[select* recipient class:test id:recipient tabindex:3 some_other_option "John Doe|jondoe@example.org" "Max Mustermann|maxmustermann@example.org"]';
		$this->assertTrue(is_array($this->pluginObject->getAdressesFromFormText($text)), "More options");
		
		// Different name
		$text = '[select* differentname id:recipient "John Doe|jondoe@example.org" "Max Mustermann|maxmustermann@example.org"]';
		$this->assertTrue(is_array($this->pluginObject->getAdressesFromFormText($text)), "Different Name");

		// Select not required
		$text = '[select recipient id:recipient "John Doe|jondoe@example.org" "Max Mustermann|maxmustermann@example.org"]';
		$this->assertTrue(is_array($this->pluginObject->getAdressesFromFormText($text)), "Select not required");

		// Spaces
		$text = '[select*   recipient     id:recipient   "John Doe|jondoe@example.org"   "Max Mustermann|maxmustermann@example.org"   ]';
		$this->assertTrue(is_array($this->pluginObject->getAdressesFromFormText($text)), "Spaces");

		// Email adress only
		$text = '[select* recipient id:recipient "jondoe@example.org" "maxmustermann@example.org"]';
		$this->assertTrue(is_array($this->pluginObject->getAdressesFromFormText($text)), "Email adresses only");
	}

	function testFormTextValidFormatInvalid()
	{
		// missing id:recipient
		$text = '[select* recipient "John Doe|jondoe@example.org" "Max Mustermann|maxmustermann@example.org"]';
		$this->assertInternalType('string', $this->pluginObject->getAdressesFromFormText($text), "id:recipient is missing, but no error was thrown");

		// wrong id
		$text = '[select* recipient id:wrongid "John Doe|jondoe@example.org" "Max Mustermann|maxmustermann@example.org"]';
		$this->assertInternalType('string', $this->pluginObject->getAdressesFromFormText($text), "id:wrongid is working, but it shouldn't!");
		
		// Empty select
		$text = '[select recipient id:recipient]';
		$this->assertInternalType('string', $this->pluginObject->getAdressesFromFormText($text)	, "Empty select");

		// id:recipient at wrong place
		$text = '<p>Recipient: [select* id:recipient recipient "Second Form|test@d.org" "Second Form 2|test@d.org"]</p>';
		$this->assertInternalType('string', $this->pluginObject->getAdressesFromFormText($text), "id:recipient is at wrong place, but no error was thrown");
	}
	
}