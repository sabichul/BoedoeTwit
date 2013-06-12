<?php
	function emoticons($text) 
	{
		$array = array(
			":-)"	=> "images/fbsmile/smile.png",
			":)"	=> "images/fbsmile/smile.png",
			":]"	=> "images/fbsmile/smile.png",
			"=)"	=> "images/fbsmile/smile.png",
			":-/"	=> "images/fbsmile/unsure.png",
			":\\"	=> "images/fbsmile/unsure.png",
			":-\\"	=> "images/fbsmile/unsure.png",
			">:O"	=> "images/fbsmile/upset.png",
			">:-O"	=> "images/fbsmile/upset.png",
			">:o"	=> "images/fbsmile/upset.png",
			">:-o"	=> "images/fbsmile/upset.png",
			":v"	=> "images/fbsmile/pacman.png",
			":\'("	=> "images/fbsmile/cry.png",
			":-("	=> "images/fbsmile/frown.png",
			":("	=> "images/fbsmile/frown.png",
			":["	=> "images/fbsmile/frown.png",
			"=("	=> "images/fbsmile/frown.png",
			":-P"	=> "images/fbsmile/tounge.png",
			":P"	=> "images/fbsmile/tounge.png",
			":-p"	=> "images/fbsmile/tounge.png",
			":p"	=> "images/fbsmile/tounge.png",
			"=P"	=> "images/fbsmile/tounge.png",
			"3:)"	=> "images/fbsmile/devil.png",
			"3:-)"	=> "images/fbsmile/devil.png",
			":3"	=> "images/fbsmile/curlylips.png",
			":-D"	=> "images/fbsmile/grin.png",
			":D"	=> "images/fbsmile/grin.png",
			"=D"	=> "images/fbsmile/grin.png",
			"O:)"	=> "images/fbsmile/angel.png",
			"O:-)"	=> "images/fbsmile/angel.png",
			":|]"	=> "images/fbsmile/robot.gif",
			"(^^^)"	=> "images/fbsmile/shark.gif",
			"<(\')"	=> "images/fbsmile/penguin.gif",
			"(Y)"	=> "images/fbsmile/thumb.png",
			"(y)"	=> "images/fbsmile/thumb.png",
			":-O"	=> "images/fbsmile/gasp.png",
			":O"	=> "images/fbsmile/gasp.png",
			":-o"	=> "images/fbsmile/gasp.png",
			":o"	=> "images/fbsmile/gasp.png",
			":-*"	=> "images/fbsmile/kiss.png",
			":*"	=> "images/fbsmile/kiss.png",
			"<3"	=> "images/fbsmile/heart.png",
			";-)"	=> "images/fbsmile/wink.png",
			"8-)"	=> "images/fbsmile/glasses.png",
			"8)"	=> "images/fbsmile/glasses.png",
			"B-)"	=> "images/fbsmile/glasses.png",
			"B)"	=> "images/fbsmile/glasses.png",
			"^_^"	=> "images/fbsmile/kiki.png",
			"8-|"	=> "images/fbsmile/sunglasses.png",
			"8|"	=> "images/fbsmile/sunglasses.png",
			"B-|"	=> "images/fbsmile/sunglasses.png",
			"B|"	=> "images/fbsmile/sunglasses.png",
			"-_-"	=> "images/fbsmile/squint.png",
			">:("	=> "images/fbsmile/grumpy.png",
			">:-("	=> "images/fbsmile/grumpy.png",
			"o.O"	=> "images/fbsmile/confused.png",
			"O.o"	=> "images/fbsmile/confused.png",
			":eek:"	=> "images/fbsmile/poop.png",
		);


		foreach($array as $emoticon => $graphic) 
		{
			$text = str_replace($emoticon, "<img src='$graphic' alt='$emoticon'>", $text);
		}

		return $text;
	}