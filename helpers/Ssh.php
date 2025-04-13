<?php

    namespace app\helpers;

    class Ssh extends Helper
    {
        private static $sftpconnection;

        private static $sftp;

        private static $currentworkingdir = "";

        /*
        |--------------------------------------------------------------------------
        | server
        |--------------------------------------------------------------------------
        |
        | returns the static object
        |
        | It is the entry point for all FTP methods that will be called in chained
        |
        */

        public static function server() {
            return new static;
        }

        /*
        |--------------------------------------------------------------------------
        | connect
        |--------------------------------------------------------------------------
        |
        | returns the static arguments that are used in the chain methods
        |
        | @var array $arguments
        |
        | @example Ssh::server()->connect( [ $host, $port, $uid, $pwsd] )
        |
        | @result: Ssh Connection Successful;
        |
        */

        public static function connect(array $arguments) {

            $port = ( count($arguments)  == 4 ) ? $arguments[1] : 22;
            $host = $arguments[0];
            $uid = $arguments[2];
            $pwsd = $arguments[3];

            try {

                // Connect to SSH2 host
                static::$sftpconnection = ssh2_connect( $host, $port );
                if ( !static::$sftpconnection ) :

                    throw new Exception("Failed to connect to ${host} on port ${port}.");

                endif;

                // Authenticate to the SSH2 connection
                $authenticate = ssh2_auth_password( static::$sftpconnection, $uid, $pwsd );
                if ( !$authenticate ) :

                    throw new Exception("Failed to authenticate with username $uid " . "and password.");

                endif;

                // Initialize to the SFTP subsystem
                static::$sftp = ssh2_sftp( static::$sftpconnection );
                if ( !static::$sftp ) :

                    throw new Exception("Could not initialize SFTP subsystem.");

                endif;

            } catch (Exception $exception) {

                echo $exception->getMessage();

            }

            return static::result( __FUNCTION__ );

        }

        /*
        |--------------------------------------------------------------------------
        | currentdirectory
        |--------------------------------------------------------------------------
        |
        | show the current Directory
        |
        | @example Ssh::server()->connect([ $host, $port, $uid, $pwsd] )->currentdirectory();
        |
        | @result: Current Directory ( / );
        |
        */

        public static function currentdirectory() {

            $stream = ssh2_exec(static::$sftpconnection, 'pwd');

            stream_set_blocking($stream, true);

            echo stream_get_contents($stream);

            return static::result(__FUNCTION__);

        }

        /*
        |--------------------------------------------------------------------------
        | createdirectory
        |--------------------------------------------------------------------------
        |
        | Return the boolean value if the directory is created successfully
        |
        | Create the directory in SFTP server
        |
        | @var string $directory
        |
        | @var int $permission
        |
        | @example Ssh::server()->connect([ $host, $port, $uid, $pwsd] )->createdirectory('ftp_test_dir',0777);
        |
        | @result: Folders created Successfully on the SFTP server
        |
        */

        public static function createdirectory(string $directory, int $permission) {

            try {

                $realpath = Ssh::getsftpcurrentworkingdir($directory)."/$directory";

                if (ssh2_sftp_mkdir(static::$sftp, $realpath, $permission)) :

                    return true;

                endif;

            } catch (Exception $e) {

                echo $e->getMessage();

            }

            return false;

        }

        /*
        |--------------------------------------------------------------------------
        | changedirectory
        |--------------------------------------------------------------------------
        |
        | @var string $new_path
        |
        | @example Ssh::server()->connect([ $host, $port, $uid, $pwsd] )->changedirectory('app');
        |
        | @result: Switched to Directory ( /app );
        |
        */

        public static function changedirectory(string $new_path) {

            $stream = ssh2_exec(static::$sftpconnection, "cd $new_path/;". " pwd");

            stream_set_blocking($stream, true);

            static::$currentworkingdir = trim(stream_get_contents($stream)).'/';

            return static::result(__FUNCTION__);

        }

        /*
        |--------------------------------------------------------------------------
        | getfiles
        |--------------------------------------------------------------------------
        |
        | @var string $new_path
        |
        | @example Ssh::server()->connect([ $host, $port, $uid, $pwsd] )->getfiles(['README.md','server.php','yarn.lock'],'../../myfiles','bazar');
        |
        | @result: File downloaded in destination folder (myfiles)
        |
        */

        public static function getfiles($name_of_files, string $destination, string $source = '/') {

            try {

                $realpath = Ssh::getsftpcurrentworkingdir()."$source/";

                $files    = scandir('ssh2.sftp://' . static::$sftp . $realpath);

                if (!empty($files)) :

                    foreach ($files as $file) :

                        if (in_array($file,$name_of_files)) :

                            ssh2_scp_recv(static::$sftpconnection, "$realpath/$file", "$destination/$file");

                        endif;

                    endforeach;

                endif;

            } catch ( Exception $exception ) {

                echo $exception->getCode()." : ".$exception->getMessage();

            }

            return static::result(__FUNCTION__);
        }

        /*
        |--------------------------------------------------------------------------
        | getfile
        |--------------------------------------------------------------------------
        |
        | @var string $new_path
        |
        | @example Ssh::server()->connect([ $host, $port, $uid, $pwsd] )->getfile('package.json','../../myfiles','bazar');
        |
        | @result: File downloaded in destination folder (myfiles)
        |
        */

        public static function getfile($name_of_file, string $destination, string $source = '/') {

            try {

                $realpath = Ssh::getsftpcurrentworkingdir()."$source";

                ssh2_scp_recv(static::$sftpconnection, "$realpath/$name_of_file", "$destination/$name_of_file");

                return true;

            } catch ( Exception $exception ) {

                echo $exception->getCode()." : ".$exception->getMessage();

            }

            return static::result(__FUNCTION__);
        }

        /*
        |--------------------------------------------------------------------------
        | putfile
        |--------------------------------------------------------------------------
        |
        | @var string $name_of_file
        |
        | @var string $destination
        |
        | @var string $source
        |
        | @example Ssh::server()->connect([ $host, $port, $uid, $pwsd] )->putfile('server.php','remotefolder','../../myfiles');
        |
        | @result: File uploaded in the working directory of SFTP server in the destination directory
        |
        */

        public static function putfile($name_of_file, string $destination, string $source = "") {

            try {

                $realpath = Ssh::getsftpcurrentworkingdir()."$destination";

                ssh2_sftp_mkdir(static::$sftp, "$realpath");


                if (file_exists("$source/$name_of_file")) :

                    ssh2_scp_send(static::$sftpconnection, "$source/$name_of_file", "$realpath/$name_of_file", 0644);

                else:

                    echo "$name_of_file does not exist<br>";

                endif;

            } catch (Exception $exception) {

                echo $exception->getCode()." : ".$exception->getMessage();

            }

            return static::result(__FUNCTION__);
        }

        /*
        |--------------------------------------------------------------------------
        | putfiles
        |--------------------------------------------------------------------------
        |
        | @var array $name_of_files
        |
        | @var string $destination
        |
        | @var string $source
        |
        | @example Ssh::server()->connect([ $host, $port, $uid, $pwsd] )->putfiles(['server.php','package.json','new 10.txt'],'remotefolder','../../myfiles');
        |
        | @result: Files uploaded in the working directory of SFTP server in the destination directory
        |
        */

        public static function putfiles($name_of_files, string $destination, string $source = "") {

            foreach ($name_of_files as $name_of_file) :

                try {

                    $realpath = Ssh::getsftpcurrentworkingdir()."$destination";

                    ssh2_sftp_mkdir(static::$sftp, "$realpath");

                    if (file_exists("$source/$name_of_file")) :

                        ssh2_scp_send(static::$sftpconnection, "$source/$name_of_file", "$realpath/$name_of_file", 0644);

                    else:

                        echo "$name_of_file does not exist<br>";

                    endif;

                } catch (Exception $exception) {

                    echo $exception->getCode()." : ".$exception->getMessage();

                }

            endforeach;

            return static::result(__FUNCTION__);
        }

        /*
        |--------------------------------------------------------------------------
        | showfiles
        |--------------------------------------------------------------------------
        |
        | Show the files from the provided directory path
        |
        | @var string $directory
        |
        | @var bool $showhidden
        |
        | @example Ssh::server()->connect([ $host, $port, $uid, $pwsd] )->showfiles('public_html');
        |
        | @result: Files listed Successfully
        |
        */

        public static function showfiles(string $directory = '', $showhidden = false) {

            try {

                $realpath = Ssh::getsftpcurrentworkingdir($directory);

                $dir = "ssh2.sftp://" . static::$sftp . $realpath;

                if ($dh = opendir($dir)) :

                    while (($file = readdir($dh)) !== false) :

                        if ( !$showhidden && substr($file, 0, 1) == '.' ) :
                            continue;
                        endif;

                        $filetype = filetype($dir . $file);

                        if ($filetype == "dir" || $file == '.' || $file == '..') :
                            continue;
                        endif;

                        printf("%s\n",$file);

                    endwhile;

                endif;

            } catch ( Exception $exception ) {

                echo $exception->getCode()." : ".$exception->getMessage();

            }
        }

        /*
        |--------------------------------------------------------------------------
        | showfolders
        |--------------------------------------------------------------------------
        |
        | Show the folders from the provided directory path
        |
        | @var string $directory
        |
        | @var bool $showhidden
        |
        | @example Ssh::server()->connect([ $host, $port, $uid, $pwsd] )->showfolders('public_html');
        |
        | @result: Folders listed Successfully
        |
        */

        public static function showfolders(string $directory = '', $showhidden = false) {

            try {

                $realpath = Ssh::getsftpcurrentworkingdir($directory);

                $dir = "ssh2.sftp://" . static::$sftp . $realpath;

                if ($dh = opendir($dir)) :

                    while (($folder = readdir($dh)) !== false) :

                        if ( !$showhidden && substr($folder, 0, 1) == '.' ) :
                            continue;
                        endif;

                        $filetype = filetype($dir . $folder);

                        if ($filetype != "dir" || $folder == '.' || $folder == '..') :
                            continue;
                        endif;

                        printf("%s\n", $folder.'/');

                    endwhile;

                endif;

            } catch ( Exception $exception ) {

                echo $exception->getCode()." : ".$exception->getMessage();

            }
        }

        /*
        |--------------------------------------------------------------------------
        | showdirectory
        |--------------------------------------------------------------------------
        |
        | Print all the files and folders in the given directory
        |
        | Create the directory in FTP server
        |
        | @var string $directory
        |
        | @var bool $showhidden
        |
        | @var bool $verbose
        |
        | @example Ssh::server()->connect([ $host, $port, $uid, $pwsd] )->showdirectory('',true,true);
        |
        | @result: Files and Folders listed with the details
        |
        */

        public static function showdirectory(string $directory = '', $showhidden = false, $verbose = false) {
            try {

                $realpath = Ssh::getsftpcurrentworkingdir($directory);

                $dir = "ssh2.sftp://" . static::$sftp . $realpath;

                if ($dh = opendir($dir)) :

                    while (($file = readdir($dh)) !== false) :

                        if ( (!$showhidden && substr($file, 0, 1) == '.') || $file == '.' || $file == '..' ) :
                            continue;
                        endif;

                        $filetype = filetype($dir . $file);
                        $filestat = lstat($dir . $file);

                        echo "Name : ".$file."<br>";
                        echo "Type : ".$filetype."<br>";

                        if ($verbose) :

                            echo "Created Date : ".date('d M', strtotime($filestat['atime']))."<br>";
                            echo "Modified Date : ".date('d M', strtotime($filestat['mtime']))."<br>";
                            echo "Time : ".date("h:i:sa", $filestat['mtime'])."<br>";
                            echo "Size : ".Ssh::byteconvert($filestat['size'])."<br>";

                        endif;

                        echo "----------------------<br>";

                    endwhile;

                endif;

            } catch ( Exception $exception ) {

                echo $exception->getCode()." : ".$exception->getMessage();

            }
        }

        /*
        |--------------------------------------------------------------------------
        | byteconvert
        |--------------------------------------------------------------------------
        |
        | Return the size of file
        |
        | Create the directory in FTP server
        |
        | @var string $bytes
        |
        | @example Ssh::byteconvert(24464);
        |
        | @result: Files and Folders listed with the details
        |
        */
        public static function byteconvert(string $bytes): string {
            $symbol = array('B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
            $exp = floor(log($bytes) / log(1024));
            return sprintf('%.2f ' . $symbol[$exp], ($bytes / pow(1024, floor($exp))));
        }

        /*
        |--------------------------------------------------------------------------
        | getsftpcurrentworkingdir
        |--------------------------------------------------------------------------
        |
        | Return the current working directory
        |
        | Create the directory in FTP server
        |
        | @var string $directory
        |
        | @example Ssh::getsftpcurrentworkingdir('');
        |
        | @result: /home/u931866682/
        |
        */

        public static function getsftpcurrentworkingdir(string $directory = '') : string {

            if (empty(static::$currentworkingdir)) :

                $realpath = ssh2_sftp_realpath(static::$sftp, '')."/$directory";
            else:

                $realpath = static::$currentworkingdir;

            endif;

            return $realpath;
        }
    }