<?php
/**
 * Git library
 *
 * @category  General
 * @package   General\Utils
 * @author    David Dattée <david.dattee@gmail.com>
 * @copyright 2016 David Dattée
 * @license   MIT License (MIT)
 */

namespace General\Utils;

class Git
{
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
     * Call command
     *
     * @param string $cmd     Command to call
     * @param null   $cwd     Path to run the command into
     * @param string &$output Command output
     * @param string &$errors Command error return
     *
     * @return int|mixed
     */
    protected function call($cmd, $cwd = null, &$output = '', &$errors = '') {
        //Run the command
        $descriptorspec = array(1 => array('pipe', 'w'), 2 => array('pipe', 'a'));
        $resource = proc_open($cmd, $descriptorspec, $pipes, $cwd);
        if (is_resource($resource)) {
            $output = stream_get_contents($pipes[1]);
            $errors = stream_get_contents($pipes[2]);
            fclose($pipes[1]);
            fclose($pipes[2]);
            $status = proc_get_status($resource);
            proc_close($resource);
        }

        return $status['running'] === false ? $status['exitcode'] : $status['running'];
    }

    /**
     * Try to pull from current repository
     *
     * @param string $remoteName   Remote central repositoriy name to pull from
     * @param string $remoteBranch Remote branch to pull from
     * @param string $localBranch  Local branch to update
     * @param string &$output      Command output
     * @param string &$errors      Command error return
     * @param null   $cwd          Path to run the command into
     *
     * @return int|mixed
     */
    public function pull($remoteName = 'origin', $remoteBranch = 'master', $localBranch = 'master', &$output = '', &$errors = '', $cwd = null)
    {
        //Locate the repository
        $cwd = !$cwd ? $this->getRepoPath() : $cwd;
        //Check for git dir
        if (!is_dir($cwd.'/.git')) {
            $errors .= "No git repo found.";
            return -100;
        }
        //Set the command to call
        $cmd = "/usr/bin/git pull";
        //Git pull params
        $cmd .= ' ' . $remoteName . ' ' . $remoteBranch . ':' . $localBranch;

        return $this->call($cmd, $cwd, $output, $errors);
    }

    /**
     * Try to fetch from current repository
     *
     * @param string $remoteName   Remote central repositoriy name to pull from
     * @param string $remoteBranch Remote branch to pull from
     * @param string $localBranch  Local branch to update
     * @param string &$output      Command output
     * @param string &$errors      Command error return
     * @param null   $cwd          Path to run the command into
     *
     * @return int|mixed
     */
    public function fetch($remoteName = 'origin', $remoteBranch = 'master', $localBranch = 'master', &$output = '', &$errors = '', $cwd = null)
    {
        //Locate the repository
        $cwd = !$cwd ? $this->getRepoPath() : $cwd;
        //Check for git dir
        if (!is_dir($cwd.'/.git')) {
            $errors .= "No git repo found.";
            return -100;
        }
        //Set the command to call
        $cmd = "/usr/bin/git fetch";
        //Git pull params
        $cmd .= ' ' . $remoteName . ' ' . $remoteBranch;

        return $this->call($cmd, $cwd, $output, $errors);
    }

    /**
     * Git reset
     *
     * @param bool   $hard         Reset hard if not HEAD will be used
     * @param string &$output      Command output
     * @param string &$errors      Command error return
     * @param null   $cwd          Path to run the command into
     *
     * @return int|mixed
     */
    public function reset($hard = false, &$output = '', &$errors = '', $cwd = null) {
        //Locate the repository
        $cwd = !$cwd ? $this->getRepoPath() : $cwd;
        //Check for git dir
        if (!is_dir($cwd.'/.git')) {
            $errors .= "No git repo found.";
            return -100;
        }
        //Set the command to call
        $cmd = "/usr/bin/git reset";
        //Git reset params
        $cmd .= ' ' . ($hard ? '--hard' : '--soft');

        return $this->call($cmd, $cwd, $output, $errors);
    }
}