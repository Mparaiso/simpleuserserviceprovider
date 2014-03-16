Simple User Service Provider
=============================

author MParaiso , mparaiso@online.fr

## A user service provider for silex

**SimpleUserServiceProvider** allows [Silex][1] developpers to register and authenticate users against a database ,
using a simple ServiceProvider. With **SimpleUserServiceProvider** , you no longer need to code basic registration/authentication features yourself with [silex][1].

### INSTALLATION

simpleuserserviceprovider depends on FOS user bundle.

witch composer , in composer.json :

	require:{
		"friendsofsymfony/user-bundle":"1.*",
		"mparaiso/simpleuserserviceprovider":"0.*"
	}


[1]: https://github.com/fabpot/Silex

### CHANGE LOG
0.0.12 block "content" changed to block "mp_user_content" in twig templates





