# webapp-installers

Simple PHP helper scripts to install common webapps without shell access

## Scripts

- **```install-typo3.php```**: Typo3 6.2.x installer script

## Usage

### Typo3 installer

This installer supports the recommended installation method as decribed in [INSTALLING TYPO3: If SSH and symlinks are possible](https://github.com/TYPO3/TYPO3.CMS/blob/TYPO3_6-2/INSTALL.md#if-ssh-and-symlinks-are-possible).

Simply upload both the installer script ```install-typo3.php``` and the Typo3 ```.tar.gz``` source package. The installer script must be placed in your webroot, the Typo3 archive below:

```
public_html/www/
├── public
│   └── install-typo3.php
└── typo3_src-6.2.15.tar.gz
```

Set your webroot to the ```public/``` directory. Changing your webroot should be possible via the controlpanel/administration interface of your [favorite webhoster](https://www.onlime.ch). Then, run the installer in your browser, e.g.:

http://www.example.com/install-typo3.php

You may also override the default version via GET parameter:

http://www.example.com/install-typo3.php?version=6.2.1

The Typo3 source package will be unpacked and all necessary symlinks will be created unter ```public/```:

```
[INFO] decompressed ../typo3_src-6.2.15.tar.gz to ../typo3_src-6.2.15
[INFO] created symlink typo3_src -> ../typo3_src-6.2.15
[INFO] created symlink index.php -> typo3_src/index.php
[INFO] created symlink typo3 -> typo3_src/typo3
[INFO] copied typo3_src/_.htaccess to .htaccess
[INFO] created FIRST_INSTALL
[INFO] done. Sucessfully installed Typo3 6.2.15.
```

If you run the installer over an already existing Typo3 installation (e.g. to upgrade to a newer version), this is perfectly fine. You will get output like this:

```
[NOTICE] unlinked existing symlink typo3_src
[INFO] created symlink typo3_src -> ../typo3_src-6.2.15
[NOTICE] unlinked existing symlink index.php
[INFO] created symlink index.php -> typo3_src/index.php
[NOTICE] unlinked existing symlink typo3
[INFO] created symlink typo3 -> typo3_src/typo3
[INFO] copied typo3_src/_.htaccess to .htaccess
[INFO] created FIRST_INSTALL
[INFO] done. Sucessfully installed Typo3 6.2.15.
```

After a successful installation, your directory structure will look as follows:

```
public_html/www/
├── public
│   ├── FIRST_INSTALL
│   ├── .htaccess
│   ├── index.php -> typo3_src/index.php
│   ├── install-typo3.php
│   ├── typo3 -> typo3_src/typo3
│   └── typo3_src -> ../typo3_src-6.2.15
├── typo3_src-6.2.15
│   ├── ChangeLog
│   ├── composer.json
│   ├── GPL.txt
│   ├── _.htaccess
│   ├── index.php
│   ├── INSTALL.md
│   ├── LICENSE.txt
│   ├── NEWS.md
│   ├── README.md
│   └── typo3
└── typo3_src-6.2.15.tar.gz
```

You can now run the Typo3 setup directly via your URL, e.g. http://www.example.com/
