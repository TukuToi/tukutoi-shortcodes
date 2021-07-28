=== TukuToi ShortCodes ===
Contributors: bedas
Donate link: https://www.tukutoi.com/
Tags: shortcodes, classicpress
Requires at least: 1.0.0
Tested up to: 5.8
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A library of indispensable ShortCodes for ClassicPress (and WordPress without Blocks) Websites.

== Description ==

TukuToi ShortCodes provides you with a bunch of ShortCodes useful for dynamic webdevelopment.
Basically the entire WordPress API has been "ShortCode-ified" in this Plugin. You can display any kind of site, post, user, taxonomy or else Information dynamically.

The ShortCodes can be nested inside each other, where it makes sense, the ShortCodes can be used both as enclosed or not encosing ShortCodes and take ShortCodes as attributes as well.

One of the most powerful features in the Plugin is a "conditional" ShortCode allowing you to write "if/else/elseif" statements directly in your favourite WordPress Text Editor.

You can easily register your own ShortCodes as well, and even pass new Attributes to existing ShortCodes. 

Documentation lives direclty inside the ShortCodes, as with a special parameter passed to any of the ShortCodes, each attribute will be shown on the site with its expected content type.

This is like a Page builder, just that you will use HTML to build your layouts and then make them dynamic with ShortCodes.

ShortCodes available so far:

Blog Info [tkt_scs_bloginfo]
Post Info [tkt_scs_postinfo]
User Info [tkt_scs_userinfo]
Term Info [tkt_scs_terminfo]
Post Terms Info [tkt_scs_post_termsinfo]
User Meta Data [tkt_scs_usermeta key="first_name"]
Term Meta Data [tkt_scs_termmeta item="3" key="mikes"]
Post Meta Data [tkt_scs_postmeta key="testing_the_field"]

All ShortCodes take exactly the same arguments as the functions.


== Installation ==

Just like any other Plugin.

== Screenshots ==

1. This screen shot description corresponds to screenshot-1.(png|jpg|jpeg|gif). Note that the screenshot is taken from
the /assets directory or the directory that contains the stable readme.txt (tags or trunk). Screenshots in the /assets
directory take precedence. For example, `/assets/screenshot-1.png` would win over `/tags/4.3/screenshot-1.png`
(or jpg, jpeg, gif).
2. This is the second screen shot

== Changelog ==

= 1.0 =
* A change since the previous version.
* Another change.

= 0.5 =
* List versions from most recent at top to oldest at bottom.

== Upgrade Notice ==

= 1.0 =
Upgrade notices describe the reason a user should upgrade.  No more than 300 characters.

= 0.5 =
This version fixes a security related bug.  Upgrade immediately.

== Arbitrary section ==

You may provide arbitrary sections, in the same format as the ones above.  This may be of use for extremely complicated
plugins where more information needs to be conveyed that doesn't fit into the categories of "description" or
"installation."  Arbitrary sections will be shown below the built-in sections outlined above.

== A brief Markdown Example ==

Ordered list:

1. Some feature
1. Another feature
1. Something else about the plugin

Unordered list:

* something
* something else
* third thing

Here's a link to [WordPress](https://wordpress.org/ "Your favorite software") and one to [Markdown's Syntax Documentation][markdown syntax].
Titles are optional, naturally.

[markdown syntax]: https://daringfireball.net/projects/markdown/syntax
            "Markdown is what the parser uses to process much of the readme file"

Markdown uses email style notation for blockquotes and I've been told:
> Asterisks for *emphasis*. Double it up  for **strong**.

`<?php code(); // goes in backticks ?>`

<pre><code>
<?php 
code(); // multiple line code goes into pre/code tags
code(); // multiple line code goes into pre/code tags
code(); // multiple line code goes into pre/code tags
</code></pre>