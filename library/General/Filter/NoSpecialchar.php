<?php
/**
 * Replace any special char by it equivalent with specialty
 *
 * @category  General
 * @package   General\Filter
 * @author    David Dattée <david.dattee@gmail.com>
 * @copyright 2016 David Dattée
 * @license   MIT License (MIT)
 */

namespace General\Filter;

use Zend\Filter\FilterInterface;

class NoSpecialchar implements FilterInterface
{
    protected $specialChars = [
        "/À/", "/Á/", "/Â/", "/Ã/", "/Ä/", "/Å/", "/à/", "/á/", "/â/", "/ã/", "/ä/", "/å/",
        "/Ò/", "/Ó/", "/Ô/", "/Õ/", "/Ö/", "/Ø/", "/ò/", "/ó/", "/ô/", "/õ/", "/ö/", "/ø/",
        "/È/", "/É/", "/Ê/", "/Ë/", "/è/", "/é/", "/ê/", "/ë/",
        "/Ç/", "/ç/",
        "/Ì/", "/Í/", "/Î/", "/Ï/", "/ì/", "/í/", "/î/", "/ï/",
        "/Ù/", "/Ú/", "/Û/", "/Ü/", "/ù/", "/ú/", "/û/", "/ü/",
        "/ÿ/",
        "/Ñ/", "/ñ/"
    ];

    protected $standardCars = [
        "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a",
        "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o", "o",
        "e", "e", "e", "e", "e", "e", "e", "e",
        "c", "c",
        "i", "i", "i", "i", "i", "i", "i", "i",
        "u", "u", "u", "u", "u", "u", "u", "u",
        "y",
        "n", "n"
    ];

    /**
     * Returns the string $value, removing all accents, on lower case and remove special caracteres
     *
     * @param  string $chaine
     *
     * @return string
     */
    public function filter($chaine)
    {

        //Remplace les caracteres a accent
        $cleaned = preg_replace($this->specialChars, $this->standardCars, $chaine);

        //Remplace les caracteres speciaux
        $in = array('/ /', '/\?/', '/\!/', '/\,/', '/\:/', "/\'/", '/\&/', '/\(/', '/\)/', '#\\\{1,}#', '#/#');
        $out = array('-', '', '', '', '', '-', 'and', '', '', '-', '-');
        $cleaned = preg_replace($in, $out, $cleaned);

        //Remplace les double tirets qui ont pu apparaitre
        $cleaned = preg_replace('/-{2,}/', '-', $cleaned);

        return $cleaned;
    }
}
