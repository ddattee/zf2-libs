<?php
/**
 * Created by PhpStorm.
 * User: ddattee
 * Date: 30/06/2015
 * Time: 11:15
 */

namespace General\Utils;

class Git
{
    /**
     * @var string Remote name
     */
    protected $remoteName = 'origin';

    /**
     * @var string Remote branch to pull from
     */
    protected $remoteBranch = 'master';

    /**
     * @var string Local branch to update
     */
    protected $localBranch  = 'master';

    /**
     * Try to find git repo path
     * Assume it is just up to vendor
     *
     * @return string
     */
    protected function getRepoPath()
    {
        $path = '.';
        if (strstr(__DIR__, 'vendor')) {
            $path = substr(__DIR__, 0, strpos(__DIR__, '/vendor'));
        }
        return $path;
    }

    /**
     * Try to pull from current repository
     *
     * @param string &$output Command output
     * @param string &$errors Command error return
     * @param null   $cwd     Path to run the command into
     *
     * @return int
     */
    public function pull(&$output = '', &$errors = '', $cwd = null)
    {
        //Locate the repository
        $cwd = !$cwd ? $this->getRepoPath() : $cwd;
        //Set the command to call
        $cmd = "sudo /usr/bin/git pull";
        //Git pull params
        $cmd .= ' ' . $this->remoteName . ' ' . $this->remoteBranch . ':' . $this->localBranch;
        //Run the command
        $descriptorspec = array(1 => array('pipe', 'w'), 2 => array('pipe', 'a'));
        $resource = proc_open($cmd, $descriptorspec, $pipes, $cwd);
        if (is_resource($resource)) {
            $status = proc_get_status($resource);
            $output = stream_get_contents($pipes[1]);
            $errors = stream_get_contents($pipes[2]);
            fclose($pipes[1]);
            fclose($pipes[2]);
            proc_close($resource);
        }

        return $status['running'] === false ? $status['exitcode'] : $status['running'];
    }
}