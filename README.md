# Infinite WP List Tables

Infinite scroll support for WP List Tables in the WordPress admin panel.

__Contributors:__ [Brady Vercher](https://twitter.com/bradyvercher)
__Requires:__ 4.0
__Tested up to:__ 4.1
__License:__ [GPL-2.0+](http://www.gnu.org/licenses/gpl-2.0.html)

Supports list tables for posts, pages, comments, users and most custom post types. Taxonomies (categories, tags, etc) should also be supported.

## Installation

### Upload

1. Download the [latest release](https://github.com/cedaro/infinite-wp-list-tables/archive/master.zip) from GitHub.
2. Go to the _Plugins &rarr; Add New_ screen in your WordPress admin panel and click the __Upload__ button at the top next to the "Add Plugins" title.
3. Upload the zipped archive.
4. Click the __Activate Plugin__ link after installation completes.

### Manual

1. Download the [latest release](https://github.com/cedaro/infinite-wp-list-tables/archive/master.zip) from GitHub.
2. Unzip the archive.
3. Copy the folder to `/wp-content/plugins/`.
4. Go to the _Plugins &rarr; Installed Plugins_ screen in your WordPress admin panel and click the __Activate__ link under the _Infinite WP List Tables_ item.

Read the Codex for more information about [installing plugins manually](http://codex.wordpress.org/Managing_Plugins#Manual_Plugin_Installation).

### Git

Clone this repository in `/wp-content/plugins/`:

`git clone git@github.com:cedaro/infinite-wp-list-tables.git`

Then go to the _Plugins &rarr; Installed Plugins_ screen in your WordPress admin panel and click the __Activate__ link under the _Infinite WP List Tables_ item.

## Changelog

### 2.0.0

* Rewrote the plugin to add support for the comment list table and BuddyPress.
* Added a filter to make it easier for plugins with custom list tables to add integration.
* Added support for loading translation files.
* Bundled the unminified version of jquery.infinitescroll.js for use when `SCRIPT_DEBUG` is enabled.
* Ensure the pagination links aren't hidden to more easily navigate many pages.

### 1.0.0

* Initial release.
