<?php
/**
 * Ftp utilities functions
 *
 * @category  General
 * @package   General\Utils\Filesystem
 * @author    David Dattée <david.dattee@gmail.com>
 * @copyright 2016 David Dattée
 * @license   MIT License (MIT)
 */

namespace General\Utils\Filesystem;

class Ftp
{
    private $_params;
    private $_connection_id;

    /**
     * Initialize FTP connection and login on the FTP server
     *
     * @param array $params array('server' => 'HOST', 'login' => 'username', 'password' => 'password')
     * @param int $timeout
     * @return resource
     * @throws Ftp_Exception
     */
    public function connect($params, $timeout = 600)
    {
        $this->_params = $params;
        // Mise en place d'une connexion basique
        $this->_connection_id = ftp_connect($params['server']);
        if ($this->_connection_id == false) {
            throw new Ftp_Exception("La connexion n'a pu être initialisée !");
        }

        // Définition du délai de connexion à 10 secondes
        ftp_set_option($this->_connection_id, FTP_TIMEOUT_SEC, $timeout);

        // Identification avec un nom d'utilisateur et un mot de passe
        $login_result = ftp_login($this->_connection_id, $params['login'], $params['password']);
        if ($login_result == false) {
            throw new Ftp_Exception("<h1>Couple login/password incorrect !</h1>");
        }

        // Activation du mode passif
        ftp_pasv($this->_connection_id, true);

        return $this->_connection_id;
    }

    /**
     * Close current FTP connection
     */
    public function close()
    {
        if (is_resource($this->_connection_id)) {
            // Fermeture de la connexion
            return ftp_close($this->_connection_id);
        }
        return false;
    }

    /**
     * Retourne La list des fichier du Dossier passé en paramètre
     *
     * @param string $dir
     * @return array
     * @throws Ftp_Exception
     */
    public function listFiles($dir = '.')
    {
        // Tentative de téléchargement du fichier $remote_file et sauvegarde dans le fichier $local_file
        if (($response = ftp_nlist($this->_connection_id, $dir)) == false) {
            throw new Ftp_Exception(implode('<br>', error_get_last()));
        }
        return $response;
    }

    /**
     * Retrieve a remote file from ftp server and stores it as local file
     *
     * @param string $remote_file The path to the file located on the remote ftp server
     * @param string $local_file The local destination file path
     * @return bool
     * @throws Ftp_Exception
     */
    public function download($remote_file, $local_file)
    {
        // Tentative de téléchargement du fichier $remote_file et sauvegarde dans le fichier $local_file
        if (ftp_get($this->_connection_id, $local_file, $remote_file, FTP_BINARY)) {
            $response = true;
        } else {
            throw new Ftp_Exception(implode('<br>', error_get_last()));
        }
        return $response;
    }

    /**
     * Upload a local file to a ftp server
     *
     * @param string $local_file The local source file path
     * @param string $remote_file The path to the file located on the remote ftp server
     * @return boolean Whether the file hasbeen uploaded or not
     */
    public function upload($local_file, $remote_file)
    {
        //Vérifie que le dossier de destination existe sinon le créé
        $path = substr($remote_file, 0, strrpos($remote_file, '/'));

        if (!is_dir('ftp://' . $this->_params['login'] . ':' . $this->_params['password'] . '@' . $this->_params['server'] . '/' . $path)) {
            FTP::ftp_mksubdirs($this->_connection_id, './', $path);
        }

        // Tentative de téléchargement du fichier $local_file vers le serveur ftp sous $remote_file
        $response = ftp_put($this->_connection_id, $remote_file, $local_file, FTP_BINARY);
        return $response;
    }

    /**
     * Renome un fichier du server ftp
     *
     * @param string $oldname
     * @param string $newname
     * @return bool
     * @throws Ftp_Exception
     */
    public function rename($oldname, $newname)
    {
        // Tentative de téléchargement du fichier $remote_file et sauvegarde dans le fichier $local_file
        if (($response = ftp_rename($this->_connection_id, $oldname, $newname)) == false) {
            throw new Ftp_Exception(implode('<br>', error_get_last()));
        }
        return $response;
    }

    /**
     *  Renome un fichier du server ftp
     *
     * @param string $oldname
     * @param string $newname
     * @param array $params
     * @param int $timeout
     * @return bool
     * @throws Ftp_Exception
     */
    public static function renameFile($oldname, $newname, $params, $timeout = 600)
    {
        // Mise en place d'une connexion basique
        $conn_id = ftp_connect($params['server']);
        if ($conn_id == false) {
            throw new Ftp_Exception("<h1>La connexion n'a pu être initialisée !</h1>");
        }

        // Définition du délai de connexion à 10 secondes
        ftp_set_option($conn_id, FTP_TIMEOUT_SEC, $timeout);

        // Récupération du délai de connexion du flux FTP courant
        $timeout = ftp_get_option($conn_id, FTP_TIMEOUT_SEC);

        // Identification avec un nom d'utilisateur et un mot de passe
        $login_result = ftp_login($conn_id, $params['login'], $params['password']);
        if ($login_result == false) {
            throw new Ftp_Exception("<h1>Couple login/password incorrect !</h1>");
        }

        // Activation du mode passif
        ftp_pasv($conn_id, true);

        // Tentative de téléchargement du fichier $remote_file et sauvegarde dans le fichier $local_file
        if (($response = ftp_rename($conn_id, $oldname, $newname)) == false) {
            throw new Ftp_Exception(implode('<br>', error_get_last()));
        }

        // Fermeture de la connexion
        ftp_close($conn_id);

        return $response;
    }

    /**
     * Retoure La list des fichier du Dossier passé en paramètre
     *
     * @param array $params
     * @param string $dir
     * @param int $timeout
     * @return array
     * @throws Ftp_Exception
     */
    public static function listFile($params, $dir = '.', $timeout = 600)
    {
        // Mise en place d'une connexion basique
        $conn_id = ftp_connect($params['server']);
        if ($conn_id == false) {
            throw new Ftp_Exception("<h1>La connexion n'a pu être initialisée !</h1>");
        }

        // Définition du délai de connexion à 10 secondes
        ftp_set_option($conn_id, FTP_TIMEOUT_SEC, $timeout);

        // Récupération du délai de connexion du flux FTP courant
        $timeout = ftp_get_option($conn_id, FTP_TIMEOUT_SEC);

        // Identification avec un nom d'utilisateur et un mot de passe
        $login_result = ftp_login($conn_id, $params['login'], $params['password']);
        if ($login_result == false) {
            throw new Ftp_Exception("<h1>Couple login/password incorrect !</h1>");
        }

        // Activation du mode passif
        ftp_pasv($conn_id, true);

        // Tentative de téléchargement du fichier $remote_file et sauvegarde dans le fichier $local_file
        if (($response = ftp_nlist($conn_id, $dir)) == false) {
            throw new Ftp_Exception(implode('<br>', error_get_last()));
        }

        // Fermeture de la connexion
        ftp_close($conn_id);

        return $response;
    }

    /**
     * Retrieve a remote file from ftp server and stores it as local file
     *
     * @param string $remote_file The path to the file located on the remote ftp server
     * @param string $local_file The local destination file path
     * @param array $params Connection parameters to the remote ftp server : ['server'=>, 'login'=>, 'password'=>]
     * @param int $timeout
     * @return bool
     * @throws Ftp_Exception
     */
    public static function getFile($remote_file, $local_file, $params, $timeout = 600)
    {
        // Mise en place d'une connexion basique
        $conn_id = ftp_connect($params['server']);
        if ($conn_id == false) {
            throw new Ftp_Exception("<h1>La connexion n'a pu être initialisée !</h1>");
        }

        // Définition du délai de connexion à 10 secondes
        ftp_set_option($conn_id, FTP_TIMEOUT_SEC, $timeout);

        // Récupération du délai de connexion du flux FTP courant
        $timeout = ftp_get_option($conn_id, FTP_TIMEOUT_SEC);

        // Identification avec un nom d'utilisateur et un mot de passe
        $login_result = ftp_login($conn_id, $params['login'], $params['password']);
        if ($login_result == false) {
            throw new Ftp_Exception("<h1>Couple login/password incorrect !</h1>");
        }

        // Activation du mode passif
        ftp_pasv($conn_id, true);

        // Tentative de téléchargement du fichier $remote_file et sauvegarde dans le fichier $local_file
        if (ftp_get($conn_id, $local_file, $remote_file, FTP_BINARY)) {
            $response = true;
        } else {
            throw new Ftp_Exception(implode('<br>', error_get_last()));
        }

        // Fermeture de la connexion
        ftp_close($conn_id);

        return $response;
    }

    /**
     * Puts a local file to a ftp server
     *
     * @param string $local_file The local source file path
     * @param string $remote_file The path to the file located on the remote ftp server
     * @param array $params Connection parameters to the remote ftp server : ['server'=>, 'login'=>, 'password'=>]
     * @param int $timeout
     * @return bool Whether the file hasbeen uploaded or not
     * @throws Ftp_Exception
     */
    public static function putFile($local_file, $remote_file, $params, $timeout = 600)
    {
        // Mise en place d'une connexion basique
        $conn_id = ftp_connect($params['server']);
        if ($conn_id == false) {
            throw new Ftp_Exception("<h1>La connexion n'a pu être initialisée !</h1>");
        }

        // Définition du délai de connexion à 10 secondes
        ftp_set_option($conn_id, FTP_TIMEOUT_SEC, $timeout);

        // Récupération du délai de connexion du flux FTP courant
        $timeout = ftp_get_option($conn_id, FTP_TIMEOUT_SEC);

        // Identification avec un nom d'utilisateur et un mot de passe
        $login_result = ftp_login($conn_id, $params['login'], $params['password']);
        if ($login_result == false) {
            throw new Ftp_Exception("<h1>Couple login/password incorrect !</h1>");
        }

        // Activation du mode passif
        ftp_pasv($conn_id, true);

        //Vérifie que le dossier de destination existe sinon le créé
        $path = substr($remote_file, 0, strrpos($remote_file, '/'));

        if (!is_dir('ftp://' . $params['login'] . ':' . $params['password'] . '@' . $params['server'] . '/' . $path)) {
            self::ftp_mksubdirs($conn_id, './', $path);
        }

        // Tentative de téléchargement du fichier $local_file vers le serveur ftp sous $remote_file
        $response = ftp_put($conn_id, $remote_file, $local_file, FTP_BINARY);

        // Fermeture de la connexion
        ftp_close($conn_id);

        return $response;
    }

    /**
     * Create subdirectories to the given path
     *
     * @param resource $ftpcon
     * @param string $ftpbasedir
     * @param string $ftpath
     */
    public static function ftp_mksubdirs($ftpcon, $ftpbasedir, $ftpath)
    {
        @ftp_chdir($ftpcon, $ftpbasedir); // /var/www/uploads
        $parts = explode('/', $ftpath); // 2013/06/11/username
        foreach ($parts as $part) {
            if (!@ftp_chdir($ftpcon, $part) && !empty($part)) {
                ftp_mkdir($ftpcon, $part);
                ftp_chdir($ftpcon, $part);
                //ftp_chmod($ftpcon, 0777, $part);
            }
        }
    }
}
