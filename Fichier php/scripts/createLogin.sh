#!/bin/bash                                                                                                                                                            
#login_asExpected

###
# Generates a new login (and updates the data-base)
# @version 2
# @return String
# @see /var/www/alkaid/scripts/loginpool
# @need /var/www/alkaid/scripts/loginpool non-empty, with at least "100" inside
# Summary :
#   Functions
#       genLogin
#       updatePool
#   Process
###

########################## FUNCTIONS ###################################


###........................................................genLogin
# Generates a login
# Increments last used login
# @see ./loginpool
# @return An integer 
# @need Non-empty ./loginpool
###
function genLogin {
    
    #Getting the last login from the login pool
        lastLogin=$(tail -n 1 /var/www/alkaid/scripts/loginpool)
                
    #Incrementing it
        newLogin=$((lastLogin + 1))
                            
    echo $newLogin
}

###........................................................updatePool
# Update the login pool
# @param $1 Expecting the new valid login
###
function updatePool {
    newlogin=$1
    echo $newlogin >> /var/www/alkaid/scripts/loginpool
}

########################## PROCESS ###################################

    newlogin=$(genLogin)

    updatePool $newlogin

    echo $newlogin
