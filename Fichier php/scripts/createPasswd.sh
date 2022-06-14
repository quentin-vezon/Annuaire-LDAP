#!/bin/bash                                                                                                                                                            
#passwd_asExpected

###
# Generates new credentials (and updates the data-bases)
# @version 6
# @return One string corresponfing to a password
# @see /var/www/alkaid/scripts/passwdpool
# @need /var/www/alkaid/scripts/passwdpool non-empty, with at least "999" inside
# Summary
#   Functions
#       genPasswd
#       checksPasswd
#       updatePool
#   Process
###
########################## FUNCTIONS ###################################


###........................................................genPasswd
# Generates a login
# Increments last used passwd
# @see ./passwdpool
# @return An integer 
# @need Non-empty ./passwdpool 
###
function genPasswd {
    #Getting the last passwd from the login pool
        lastPasswd=$(tail -n 1 /var/www/alkaid/scripts/passwdpool)

    #Incrementing it
        newPasswd=$((lastPasswd - 1))

    echo $newPasswd
}


###........................................................checksPasswd
# Checks if the password already exists (in the associate pool of used passwords)
# If it does (i), the function is called recursively in order to try a new password
# If it does not (ii), the password is directed to the standard output
# @param $1 Expecting an integer (which will be a password)
# @see passwdpool
# @return The number given in parameters, returned in the standard output
###
function checksPasswd { 
        
    myPasswd=$1
                
    if grep -Fqx '$myPasswd' /var/www/alkaid/scripts/passwdpool
    then
        checksPasswd $(genPasswd)  /var/www/alkaid/scripts/passwdpool  # i
    else
        echo $myPasswd                            # ii
    fi
}

###........................................................updatePool
# Update the password pool
# @param $1 Expecting the new valid password
###
function updatePool {
    newpassword=$1
    echo $newpassword >> /var/www/alkaid/scripts/passwdpool
}


########################## PROCESS ###################################

    newpassword=$(checksPasswd $(genPasswd))

    updatePool $newpassword

    echo $newpassword  
