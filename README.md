# Child Theme Library

A configuration based drop-in library for extending Genesis child themes. See an example of how to integrate the library [here](https://github.com/seothemes/genesis-starter-theme) or check out the [live demo](https://demo.seothemes.com/genesis-starter). 

### Why was the Child Theme Library built?

The main purpose of the Child Theme Library is to provide a shareable codebase for commercial Genesis child themes. This is achieved by using configuration-based architecture to separate the theme's reusable logic from it's configuration. Using this approach, we are able to use a single codebase which can be heavily customized by passing in different configs.


### Requirements

<table width="100%">
	<thead>
		<tr>
			<th align="left" width="25%">Requirement</th>
			<th align="left" width="25%">How to Check</th>
			<th align="left" width="50%">How to Install</th>
		</tr>
	</thead>
	<tbody>
		<tr>
			<td>PHP >= 5.3</td>
			<td><code>php -v</code></td>
			<td><a href="http://php.net/manual/en/install.php" target="_blank">php.net</a></td>
		</tr>
		<tr>
            <td>WordPress >= 4.8</td>
            <td><code>Admin Footer</code></td>
            <td><a href="https://codex.wordpress.org/Installing_WordPress" target="_blank">wordpress.org</a></td>
        </tr>
        <tr>
            <td>Genesis >= 2.6</td>
            <td><code>Theme Page</code></td>
            <td><a href="http://www.shareasale.com/r.cfm?b=346198&u=1459023&m=28169&urllink=&afftrack=" target="_blank">studiopress.com</a></td>
        </tr>
        <tr>
			<td>Composer >= 1.5.0</td>
			<td><code>composer --version</code></td>
			<td><a href="https://getcomposer.org/doc/00-intro.md#installation-linux-unix-osx" target="_blank">getcomposer.org</a></td>
		</tr>
	</tbody>
</table>

## Installation

### Composer (recommended)

Include the package and the custom directory installer package in your child theme's `composer.json` file

```json
"require":{
  "mnsami/composer-custom-directory-installer": "1.1.*",
  "seothemes/child-theme-library": "dev-master"
}
```

In the `extra` section define the custom directory you want the package to be installed in:

```json
"extra":{
  "installer-paths":{
    "./lib/": ["seothemes/child-theme-library"]
  }
},
```

While the child theme library is in beta, you will also need to add the repository details:

```json
"repositories": [
  {
    "type": "git",
    "url": "https://github.com/seothemes/child-theme-library.git"
  }
],
```

An example `composer.json` file can be found [here](https://github.com/seothemes/genesis-starter-theme/composer.json)

### Git

The Child Theme Library can be installed as a Git Submodule. This allows the library to receive future updates with ease. If you are not familiar with Git Submodules please read [this article](https://gist.github.com/gitaarik/8735255).

From the terminal, navigate to your project directory:

```sh
cd wp-content/themes/my-theme
```

Clone from Github into the `lib` directory. This creates a submodule:

```sh
git submodule add https://github.com/seothemes/child-theme-library.git lib
```

Include the library from your `functions.php` file by placing the following line **after** the Genesis Framework has loaded:

```php
// Load Child Theme Library (do not remove).
require_once get_stylesheet_directory() . '/lib/init.php';
```

### Manually

Download the zip file from Github [here](https://github.com/seothemes/child-theme-library/archive/master.zip).

Upload the file to your theme's main directory and unzip the contents.

Include the library from your `functions.php` file, before any custom code is loaded e.g:

```php
// Load child theme's lib (do not remove).
require_once get_stylesheet_directory() . '/lib/init.php';
```

## Setup

Once the library has been included in your theme, it is ready to accept your config file. By default, this should be placed in `./config/config.php`, however this location can be changed by using the config path filter, e.g:

```php
add_filter( 'child_theme_config', get_stylesheet_directory() . 'my-config.php' );
```

A working example of the config file with all of the possible settings can be found [here](https://github.com/seothemes/genesis-starter-theme/composer.json).

## Structure

The Child Theme Library loosely resembles the current Genesis Framework file structure:

```sh
lib/
├── admin/
│   ├── customizer-output.php
│   └── customizer-settings.php
├── classes/
│   ├── class-rgba-customizer-control.php
│   └── class-tgm-plugin-activation.php
├── css/
│   ├── customizer.css
│   └── load-styles.php
├── functions/
│   ├── attributes.php
│   ├── defaults.php
│   ├── demo.php
│   ├── general.php
│   ├── hero.php
│   ├── layout.php
│   ├── markup.php
│   ├── plugins.php
│   ├── setup.php
│   ├── templates.php
│   ├── upgrade.php
│   └── utilities.php
├── js/
│   ├── customizer.js
│   ├── menu.js
│   └── load-scripts.php
├── languages/
│   └── child-theme-library.pot
├── shortcodes/
│   └── footer.php
├── structure/
│   ├── footer.php
│   ├── header.php
│   └── menu.php
├── views/
│   ├── page-blog.php
│   ├── page-boxed.php
│   ├── page-contact.php
│   ├── page-full.php
│   ├── page-landing.php
│   └── page-sitemap.php
├── widgets/
│   ├── widget-areas.php
│   └── widgets.php
├── .gitattributes
├── .gitmodules
├── composer.json
├── LICENSE.md
├── README.md
├── autoload.php
└── init.php
```

## Support

Please visit https://github.com/seothemes/child-theme-library/issues/ to open a new issue.

## Authors

- **Lee Anthony** - [SEO Themes](https://seothemes.com/)

See also the list of [contributors](https://github.com/seothemes/child-theme-library/graphs/contributors) who participated in this project.

## License

This project is licensed under the GNU General Public License - see the LICENSE.md file for details.

## Acknowledgments

A shout out to anyone who's code was used in or provided inspiration to this project:

<a href="https://github.com/garyjones/" target="_blank">Gary Jones</a>, 
<a href="https://github.com/craigsimps/" target="_blank">Craig Simpson</a>, 
<a href="https://github.com/christophherr/" target="_blank">Christoph Herr</a>, 
<a href="https://github.com/timothyjensen/" target="_blank">Tim Jensen</a>, 
<a href="https://github.com/billerickson/" target="_blank">Bill Erickson</a>, 
<a href="https://github.com/srikat/" target="_blank">Sridhar Katakam</a>, 
<a href="https://github.com/cpaul007/" target="_blank">Chinmoy Paul</a>, 
<a href="https://github.com/nathanrice/" target="_blank">Nathan Rice</a>, 
<a href="https://github.com/bgardner/" target="_blank">Brian Gardner</a>
