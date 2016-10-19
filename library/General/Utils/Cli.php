<?php
/**
 * Cli utilities functions
 *
 * @category  General
 * @package   General\Utils
 * @author    David Dattée <david.dattee@gmail.com>
 * @copyright 2016 David Dattée
 * @license   MIT License (MIT)
 */

namespace General\Utils;

class Cli
{
    /**
     * Execute the given command in the given folder
     * @param string $cmd Complete commande to execute
     * @param string $cwd Folder in fich the command will be executed (default: '.')
     * @param string $outupt Output of the command on the standard IO
     * @param string $errors Output of the command on the errors IO
     * @return string * @return string Command response code
     */
    public static function cmd($cmd, $cwd = '.', &$output = '', &$errors = '')
    {
        $descriptorspec = array(1 => array('pipe', 'w'), 2 => array('pipe', 'w'));
        $resource = proc_open($cmd, $descriptorspec, $pipes, $cwd);
        if (is_resource($resource)) {
            $output = stream_get_contents($pipes[1]) . "\n";
            $errors .= stream_get_contents($pipes[2]) . "\n";
            fclose($pipes[1]);
            fclose($pipes[2]);
            $resp_code = proc_close($resource);
            $output .= "Code de reponse : " . $resp_code . "\n";
            return $resp_code;
        } else {
            return "La commande " . $cmd . " n'a pu être éxecutée";
        }
        return -1;
    }

    /**
     * Verify if a command exists by trying `which $cmd`
     * @param $binary_name
     * @return mixed
     */
    public static function cmdExists($cmd)
    {
        return `which $cmd`;
    }
}
