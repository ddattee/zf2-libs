<?php
/**
 * Created by PhpStorm.
 * User: ddattee
 * Date: 30/06/2015
 * Time: 11:16
 */

namespace General\Utils;

class Xsl
{
	/**
	 * Transform the given Xml with Xsl stylesheet
	 *
	 * @param string $xml Can be a file path or Xml as a string
	 * @param string $xsl Can be a file path or Xsl as a string
	 * @param string $params Parameters to pass to the XSL transformation
	 * @param string $destination_file File to right the result to, if not provided return the result as a string
	 * @return string|int|false The XML or if the file has been written the number of bite written or FALSE
	 */
	public static function xslTransform($xml, $xsl, $params = array(), $destination_file = false, &$notification = false)
	{
		//Set XML/XSL load function
		$xml_load_func = (file_exists($xml) ? 'load' : 'loadXML');
		$xsl_load_func = (file_exists($xsl) ? 'load' : 'loadXML');
		//Load XSL
		if ($notification) {
			$notification->addComment('Chargement du XSL ' . (file_exists($xsl) ? $xsl : 'envoyé.') . '<br>', '', true);
		}
		$xsl_doc = new DOMDocument();
		$xsl_doc->$xsl_load_func($xsl, LIBXML_COMPACT);
		$proc = new XSLTProcessor();
		$proc->importStylesheet($xsl_doc);
		if (!empty($params)) {
			foreach ($params as $key => $value) {
				$proc->setParameter('', $key, $value);
			}
		}
		if ($notification) {
			$notification->addComment('XSL chargé<br>', '', true);
			$notification->addComment('Chargement du XML ' . (file_exists($xml) ? $xml : 'envoyé.') . '<br>', '', true);
		}
		//Load XML
		$xml_doc = new DOMDocument();
		$xml_doc->$xml_load_func($xml);
		if ($notification) {
			$notification->addComment('XML chargé<br>', '', true);
			$notification->addComment('Application de la transformation XSL.<br>', '', true);
		}

		//Transform XML
		if ($destination_file != false && (file_exists($destination_file) || @touch($destination_file))) {
			if ($notification) {
				$notification->addComment('Le resultat sera produit dans le fichier ' . $destination_file . '<br>.', '', true);
			}
			return file_put_contents($destination_file, $proc->transformToXml($xml_doc));
		} else {
			$result = $proc->transformToXml($xml_doc);
			if ($notification) {
				$notification->addComment('Transformation terminé.<br>', '', true);
			}
			return $result;
		}
	}

}