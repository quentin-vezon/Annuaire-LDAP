<?php
#==============================================================================
# LTB Self Service Password
#
# Copyright (C) 2009 Clement OUDOT
# Copyright (C) 2009 LTB-project.org
#
# This program is free software; you can redistribute it and/or
# modify it under the terms of the GNU General Public License
# as published by the Free Software Foundation; either version 2
# of the License, or (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
#
# GPL License: http://www.gnu.org/licenses/gpl.txt
#
#==============================================================================

#==============================================================================
# Configuration
#==============================================================================
# LDAP
$ldap_url = "ldap://localhost";
$ldap_binddn = "cn=admin,dc=sic,dc=montp,dc=cnrs,dc=fr";
$ldap_bindpw = "Montp,cnrs";
$ldap_base = "dc=sic,dc=montp,dc=cnrs,dc=fr";
##$ldap_filter = "(&(objectClass=person)(uid={login}))";
$ldap_filter = "(&(objectClass=person)(cn={login}))";

# Active Directory mode
# true: use unicodePwd as password field
# false: LDAPv3 standard behavior
$ad_mode = false;

# Samba mode
# true: update sambaNTpassword and sambaPwdLastSet attributes too
# false: just update the password
# Warning: this require mhash() to be installed on your system
$samba_mode = true;

# Hash mechanism for password:
# SSHA
# SHA
# SMD5
# MD5
# CRYPT
# clear (the default)
# This option is not used with ad_mode = true
$hash = "CRYPT";

# Local password policy
# This is applied before directory password policy
# Minimal length
$pwd_min_length = 12;
# Maximal length
$pwd_max_length = 0;
# Minimal lower characters
$pwd_min_lower = 1;
# Minimal upper characters
$pwd_min_upper = 1;
# Minimal digit characters
$pwd_min_digit = 1;
# Minimal special characters
$pwd_min_special = 1;
# Show policy constraints message
#$pwd_show_policy = false;
$pwd_show_policy = true;

# Who changes the password?
# user: the user itself
# manager: the above binddn
$who_change_password = "manager";

# Language
$lang ="fr";

# Logo
$logo = "style/ltb-logo.png";

# Debug mode
$debug = true;
?>
