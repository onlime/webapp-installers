# webapp-installers

Simple PHP helper scripts to install common webapps without shell access

## Scripts

- **```install-typo3.php```**: Typo3 6.2.x installer script

## Usage

### Typo3 installer

Simply upload both the installer script ```install-typo3.php``` and the Typo3 ```.tar.gz``` source package. The installer script must be placed in your webroot, the Typo3 archive below:

```
public_html/www/
├── public
│   └── install-typo3.php
└── typo3_src-6.2.0.tar.gz
```

Set your webroot to the ```public/``` directory and call the installer via browser, e.g.:

http://www.example.com/install-typo3.php

You may also override the default version via GET parameter:

http://www.example.com/install-typo3.php?version=6.2.1

The Typo3 source package will be unpacked and all necessary symlinks will be created unter ```public/```:

```
[INFO] decompressed ../typo3_src-6.2.0.tar.gz to ../typo3_src-6.2.0
[INFO] created symlink typo3_src -> ../typo3_src-6.2.0
[INFO] created symlink index.php -> typo3_src/index.php
[INFO] created symlink typo3 -> typo3_src/typo3
[INFO] done. Sucessfully installed Typo3 6.2.0.
```

After a successful installation, your directory structure will look as follows:

```
public_html/www/
├── public
│   ├── FIRST_INSTALL
│   ├── index.php -> typo3_src/index.php
│   ├── install-typo3.php
│   ├── typo3 -> typo3_src/typo3
│   └── typo3_src -> ../typo3_src-6.2.0
├── typo3_src-6.2.0
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
└── typo3_src-6.2.0.tar.gz
```

You can now run the Typo3 setup directly via your URL, e.g. http://www.example.com/
