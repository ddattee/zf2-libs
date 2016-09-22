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
     * @var string Local branch to update
     */
    protected $localBranch  = 'master';

    /**
     * @var string Remote branch to pull from
     */
    protected $remoteBranch = 'master';

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
            $path = substr(__DIR__, 0, strpos('/vendor'));
        }
        return $path;
    }

    /**
     * Try to pull from current repository
     *
     * @return string
     */
    public function pull($cwd = null)
    {
        //Locate the repository
        $cwd = !$cwd ? $this->getRepoPath() : $cwd;
        //Set the command to call
        $cmd = "sudo /usr/bin/git pull";
        //Git pull params
        $cmd .= ' origin +refs/heads/' .
            $this->remoteBranch .
            ':refs/remotes/origin/' .
            $this->localBranch;
        //Run the command
        $descriptorspec = array(1 => array('pipe', 'w'), 2 => array('pipe', 'a'));
        $resource = proc_open($cmd, $descriptorspec, $pipes, $cwd);
        if (is_resource($resource)) {
            $output = stream_get_contents($pipes[1]);
            $errors = stream_get_contents($pipes[2]);
            fclose($pipes[1]);
            fclose($pipes[2]);
            proc_close($resource);
        }

        return $output . "\n" . $errors;
    }
}