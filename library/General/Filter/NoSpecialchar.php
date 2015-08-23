<?php

/**
 * Description of General_Filter_DomainName
 *
 * @author ddattee
 */

namespace General\Filter;

use Zend\Filter\FilterInterface;

class NoSpecialchar implements FilterInterface
{

	/**
	 * Returns the string $value, removing all accents, on lower case and remove special caracteres
	 *
	 * @param  string $value
	 * @return string
	 */
	public function filter($chaine)
	{

		//Remplace les caracteres a accent
		$patterns = array(
			"/À/",
			"/Á/",
			"/Â/",
			"/Ã/",
			"/Ä/",
			"/Å/",
			"/à/",
			"/á/",
			"/â/",
			"/ã/",
			"/ä/",
			"/å/",
			"/Ò/",
			"/Ó/",
			"/Ô/",
			"/Õ/",
			"/Ö/",
			"/Ø/",
			"/ò/",
			"/ó/",
			"/ô/",
			"/õ/",
			"/ö/",
			"/ø/",
			"/È/",
			"/É/",
			"/Ê/",
			"/Ë/",
			"/è/",
			"/é/",
			"/ê/",
			"/ë/",
			"/Ç/",
			"/ç/",
			"/Ì/",
			"/Í/",
			"/Î/",
			"/Ï/",
			"/ì/",
			"/í/",
			"/î/",
			"/ï/",
			"/Ù/",
			"/Ú/",
			"/Û/",
			"/Ü/",
			"/ù/",
			"/ú/",
			"/û/",
			"/ü/",
			"/ÿ/",
			"/Ñ/",
			"/ñ/"
		);
		$replacements = array(
			"a",
			"a",
			"a",
			"a",
			"a",
			"a",
			"a",
			"a",
			"a",
			"a",
			"a",
			"a",
			"o",
			"o",
			"o",
			"o",
			"o",
			"o",
			"o",
			"o",
			"o",
			"o",
			"o",
			"o",
			"e",
			"e",
			"e",
			"e",
			"e",
			"e",
			"e",
			"e",
			"c",
			"c",
			"i",
			"i",
			"i",
			"i",
			"i",
			"i",
			"i",
			"i",
			"u",
			"u",
			"u",
			"u",
			"u",
			"u",
			"u",
			"u",
			"y",
			"n",
			"n"
		);
		$cleaned = preg_replace($patterns, $replacements, $chaine);

		//Remplace les caracteres speciaux
		$in = array('/ /', '/\?/', '/\!/', '/\,/', '/\:/', "/\'/", '/\&/', '/\(/', '/\)/', '#\\\{1,}#', '#/#');
		$out = array('-', '', '', '', '', '-', 'et', '', '', '-', '-');
		$cleaned = preg_replace($in, $out, $cleaned);

		//Remplace les double tirets qui ont pu apparaitre
		$cleaned = preg_replace('/-{2,}/', '-', $cleaned);

		return $cleaned;
	}

}