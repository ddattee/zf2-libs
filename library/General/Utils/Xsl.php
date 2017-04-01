<?php
/**
 * Xsl utilities functions
 *
 * @category  General
 * @package   General\Utils
 * @author    David Dattée <david.dattee@gmail.com>
 * @copyright 2016 David Dattée
 * @license   MIT License (MIT)
 */

namespace General\Utils;

class Xsl
{
    /**
     * Transform the given Xml with Xsl stylesheet
     *
     * @param string $xml              Can be a file path or Xml as a string
     * @param string $xsl              Can be a file path or Xsl as a string
     * @param array  $params           Parameters to pass to the XSL transformation
     * @param string $destination_file File to right the result to, if not provided return the result as a string
     *
     * @return string|int|false The XML or if the file has been written the number of bite written or FALSE
     */
    public static function xslTransform($xml, $xsl, $params = array(), $destination_file = null)
    {
        //Set XML/XSL load function
        $xml_load_func = (file_exists($xml) ? 'load' : 'loadXML');
        $xsl_load_func = (file_exists($xsl) ? 'load' : 'loadXML');

        $xsl_doc = new DOMDocument();
        $xsl_doc->$xsl_load_func($xsl, LIBXML_COMPACT);
        $proc = new XSLTProcessor();
        $proc->importStylesheet($xsl_doc);
        if (!empty($params)) {
            foreach ($params as $key => $value) {
                $proc->setParameter('', $key, $value);
            }
        }

        //Load XML
        $xml_doc = new DOMDocument();
        $xml_doc->$xml_load_func($xml);

        //Transform XML
        if ($destination_file && (file_exists($destination_file) || @touch($destination_file))) {
            return file_put_contents($destination_file, $proc->transformToXml($xml_doc));
        } else {
            $result = $proc->transformToXml($xml_doc);
            return $result;
        }
    }
}
