=== TukuToi ShortCodes ===
Contributors: bedas
Donate link: https://www.tukutoi.com/
Tags: shortcodes, classicpress
Requires at least: 1.0.0
Tested up to: 4.9.99
Stable tag: 1.6
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A library of indispensable ShortCodes for ClassicPress (and WordPress without Blocks) Websites.

== Description ==

This plugin is currently under development.
Known issues.
- in Excerpts the ShortCodes do not work, thus on archives they do not render.
- shortcodes do not insert at mouse position, instead, append to text, when we edit in text mode
- Conditional shortcode does not automatically autoclose when inserting, we need to manually add `[/tkt_scs_conditional]`

TukuToi ShortCodes provides you with a bunch of ShortCodes useful for dynamic webdevelopment.
Basically the entire WordPress API has been "ShortCode-ified" in this Plugin. You can display any kind of site, post, user, taxonomy or else Information dynamically.

Have a look at *some* of the possible Output...

```
[tkt_scs_bloginfo show="language" filter="raw" sanitize="text_field"]</br>

[tkt_scs_bloginfo show="version" filter="raw" sanitize="text_field"]</br>

[tkt_scs_bloginfo show="html_type" filter="raw" sanitize="text_field"]</br>

[tkt_scs_bloginfo show="charset" filter="raw" sanitize="text_field"]</br>

[tkt_scs_bloginfo show="admin_email" filter="raw" sanitize="text_field"]</br>

[tkt_scs_bloginfo show="template_url" filter="raw" sanitize="text_field"]</br>

[tkt_scs_bloginfo show="stylesheet_directory" filter="raw" sanitize="text_field"]</br>

[tkt_scs_bloginfo show="stylesheet_url" filter="raw" sanitize="text_field"]</br>

[tkt_scs_bloginfo show="pingback_url" filter="raw" sanitize="text_field"]</br>

[tkt_scs_bloginfo show="comments_rss2_url" filter="raw" sanitize="text_field"]</br>

[tkt_scs_bloginfo show="comments_atom_url" filter="raw" sanitize="text_field"]</br>

[tkt_scs_bloginfo show="atom_url" filter="raw" sanitize="text_field"]</br>

[tkt_scs_bloginfo show="rss2_url" filter="raw" sanitize="text_field"]</br>

[tkt_scs_bloginfo show="rss_url" filter="raw" sanitize="text_field"]</br>

[tkt_scs_bloginfo show="rdf_url" filter="raw" sanitize="text_field"]</br>

[tkt_scs_bloginfo show="description" filter="raw" sanitize="text_field"]</br>

[tkt_scs_bloginfo show="wpurl" filter="raw" sanitize="text_field"]</br>

[tkt_scs_bloginfo show="url" filter="raw" sanitize="text_field"]</br>

[tkt_scs_bloginfo show="name" filter="raw" sanitize="text_field"]</br>

[tkt_scs_postinfo item="" show="post_name" filter="raw" sanitize="text_field"]</br>
[tkt_scs_postinfo item="" show="ID" filter="raw" sanitize="text_field"]</br>
[tkt_scs_postinfo item="" show="post_author" filter="raw" sanitize="text_field"]</br>
[tkt_scs_postinfo item="" show="post_date" filter="raw" sanitize="text_field"]</br>
[tkt_scs_postinfo item="" show="post_date_gmt" filter="raw" sanitize="text_field"]</br>
[tkt_scs_postinfo item="" show="post_content" filter="raw" sanitize="text_field"]</br>
[tkt_scs_postinfo item="" show="post_title" filter="raw" sanitize="text_field"]</br>
[tkt_scs_postinfo item="" show="post_excerpt" filter="raw" sanitize="text_field"]</br>
[tkt_scs_postinfo item="" show="post_status" filter="raw" sanitize="text_field"]</br>
[tkt_scs_postinfo item="" show="comment_status" filter="raw" sanitize="text_field"]</br>
[tkt_scs_postinfo item="" show="ping_status" filter="raw" sanitize="text_field"]</br>
[tkt_scs_postinfo item="" show="post_password" filter="raw" sanitize="text_field"]</br>
[tkt_scs_postinfo item="" show="post_name" filter="raw" sanitize="text_field"]</br>
[tkt_scs_postinfo item="" show="to_ping" filter="raw" sanitize="text_field"]</br>
[tkt_scs_postinfo item="" show="pinged" filter="raw" sanitize="text_field"]</br>
[tkt_scs_postinfo item="" show="post_modified" filter="raw" sanitize="text_field"]</br>
[tkt_scs_postinfo item="" show="post_modified_gmt" filter="raw" sanitize="text_field"]</br>
[tkt_scs_postinfo item="" show="post_content_filtered" filter="raw" sanitize="text_field"]</br>
[tkt_scs_postinfo item="" show="post_parent" filter="raw" sanitize="text_field"]</br>
[tkt_scs_postinfo item="" show="guid" filter="raw" sanitize="text_field"]</br>
[tkt_scs_postinfo item="" show="menu_order" filter="raw" sanitize="text_field"]</br>
[tkt_scs_postinfo item="" show="post_type" filter="raw" sanitize="text_field"]</br>
[tkt_scs_postinfo item="" show="post_mime_type" filter="raw" sanitize="text_field"]</br>
[tkt_scs_postinfo item="" show="comment_count" filter="raw" sanitize="text_field"]</br>
[tkt_scs_postinfo item="" show="filter" filter="raw" sanitize="text_field"]</br>


[tkt_scs_userinfo item="" field="id" value="" show="ID" sanitize="text_field"]</br>
[tkt_scs_userinfo item="" field="id" value="" show="user_login" sanitize="text_field"]</br>
[tkt_scs_userinfo item="" field="id" value="" show="user_pass" sanitize="text_field"]</br>
[tkt_scs_userinfo item="" field="id" value="" show="user_nicename" sanitize="text_field"]</br>
[tkt_scs_userinfo item="" field="id" value="" show="user_email" sanitize="text_field"]</br>
[tkt_scs_userinfo item="" field="id" value="" show="user_url" sanitize="text_field"]</br>
[tkt_scs_userinfo item="" field="id" value="" show="user_registered" sanitize="text_field"]</br>
[tkt_scs_userinfo item="" field="id" value="" show="user_activation_key" sanitize="text_field"]</br>
[tkt_scs_userinfo item="" field="id" value="" show="user_status" sanitize="text_field"]</br>
[tkt_scs_userinfo item="" field="id" value="" show="display_name" sanitize="text_field"]</br>
[tkt_scs_userinfo item="" field="id" value="" show="caps" sanitize="text_field"]</br>
[tkt_scs_userinfo item="" field="id" value="" show="cap_key" sanitize="text_field"]</br>
[tkt_scs_userinfo item="" field="id" value="" show="roles" sanitize="text_field"]</br>
[tkt_scs_userinfo item="" field="id" value="" show="allcaps" sanitize="text_field"]</br>
[tkt_scs_userinfo item="" field="id" value="" show="filter" sanitize="text_field"]</br>

[tkt_scs_terminfo item="1" show="term_id" filter="raw" sanitize="text_field"]</br>
[tkt_scs_terminfo item="1" show="name" filter="raw" sanitize="text_field"]</br>
[tkt_scs_terminfo item="1" show="slug" filter="raw" sanitize="text_field"]</br>
[tkt_scs_terminfo item="1" show="term_group" filter="raw" sanitize="text_field"]</br>
[tkt_scs_terminfo item="1" show="term_taxonomy_id" filter="raw" sanitize="text_field"]</br>
[tkt_scs_terminfo item="1" show="taxonomy" filter="raw" sanitize="text_field"]</br>
[tkt_scs_terminfo item="1" show="description" filter="raw" sanitize="text_field"]</br>
[tkt_scs_terminfo item="1" show="parent" filter="raw" sanitize="text_field"]</br>
[tkt_scs_terminfo item="1" show="count" filter="raw" sanitize="text_field"]</br>
[tkt_scs_terminfo item="1" show="filter" filter="raw" sanitize="text_field"]</br>

[tkt_scs_post_termsinfo item="" taxonomy="category" show="term_id" delimiter=", " sanitize="text_field"]</br>
[tkt_scs_post_termsinfo item="" taxonomy="category" show="name" delimiter=", " sanitize="text_field"]</br>
[tkt_scs_post_termsinfo item="" taxonomy="category" show="slug" delimiter=", " sanitize="text_field"]</br>
[tkt_scs_post_termsinfo item="" taxonomy="category" show="term_group" delimiter=", " sanitize="text_field"]</br>
[tkt_scs_post_termsinfo item="" taxonomy="category" show="term_taxonomy_id" delimiter=", " sanitize="text_field"]</br>
[tkt_scs_post_termsinfo item="" taxonomy="category" show="taxonomy" delimiter=", " sanitize="text_field"]</br>
[tkt_scs_post_termsinfo item="" taxonomy="category" show="description" delimiter=", " sanitize="text_field"]</br>
[tkt_scs_post_termsinfo item="" taxonomy="category" show="parent" delimiter=", " sanitize="text_field"]</br>
[tkt_scs_post_termsinfo item="" taxonomy="category" show="count" delimiter=", " sanitize="text_field"]</br>
[tkt_scs_post_termsinfo item="" taxonomy="category" show="filter" delimiter=", " sanitize="text_field"]</br>

[tkt_scs_usermeta item="" key="first_name" single="true" delimiter="" sanitize="text_field"]</br>
[tkt_scs_usermeta item="" key="last_name" single="true" delimiter="" sanitize="text_field"]

[tkt_scs_termmeta item="3" key="mikes"  delimiter="" sanitize="text_field"]

[tkt_scs_postmeta item="" key="testing_the_field" single="true" delimiter="" filter="raw" sanitize="text_field"]

[tkt_scs_conditional left="[tkt_scs_postinfo item="" show="ID" filter="raw" sanitize="text_field"]" right="1" operator="eq" else="no true!"][tkt_scs_postinfo item="" show="post_name" filter="raw" sanitize="text_field"][/tkt_scs_conditional]
```

The ShortCodes can be nested inside each other, where it makes sense, the ShortCodes can be used both as enclosed or not encosing ShortCodes and take ShortCodes as attributes as well.

One of the most powerful features in the Plugin is a "conditional" ShortCode allowing you to write "if/else/elseif" statements directly in your favourite WordPress Text Editor like so:
```
[tkt_scs_conditional left="The past is WP" right="The Future is CP" operator="eqv" else="The Compared values where not true!"]
  The Compared values where true!
[/tkt_scs_conditional]
```

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
Conditional ShortCode [tkt_scs_conditional left="val" right="val" operator="eqv" else="val"]Anything[/tkt_scs_conditional]

All ShortCodes take exactly the same arguments as the functions.
All ShortCodes can be inserted in the Post Editors using a Dymamic GUI that lets you compose the ShortCode attributes, with custom values or where appropriate with existing "object properties".


== Installation ==

Just like any other Plugin.

== Screenshots ==

1. This screen shot description corresponds to screenshot-1.(png|jpg|jpeg|gif). Note that the screenshot is taken from
the /assets directory or the directory that contains the stable readme.txt (tags or trunk). Screenshots in the /assets
directory take precedence. For example, `/assets/screenshot-1.png` would win over `/tags/4.3/screenshot-1.png`
(or jpg, jpeg, gif).
2. This is the second screen shot

== Changelog ==

= 1.6.0 =
* [Fixed] All Shortcode are now producing healthy and useful output
* [Fixed] Added warnings when inserting Post Content Shortcode in a current post
* [Fixed] Full handling of User Object now possible
* [Fixed] All ShortCodes in GUI now have explanation where applicable 
* [Fixed] In Text mode now shortcodes append to content instead of replacing content
* [Fixed] Now text_direction (even if retardedly handled by WP/CP) uses is_rtl properly
* [Changed] Added more meaningful debug logs
* [Changed] Added custom jQuery UI Theme
 

= 1.5.0 =
* [Added] Full class management for all GUI elements
* [Fixed] Issue where shortcodes inserted with memorized attributes
* [Changed] full class management for validation,sanitization,error handling, declarations
* [Changed] Version number and readme
* [Changed] Also did a full test round and refactor/code style polish.

= 1.4.0 =
* [Added] Added ShortCodeGUI

= 1.3.0 =
* [Added] Added Conditional ShortCode

= 1.2.0 =
* [Added] Added Inner and Nested ShortCodes

= 1.1.0 =
* [Added] Added Post, User and Term plus respective meta ShortCodes

= 1.0.0 =
* Initial Commit

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