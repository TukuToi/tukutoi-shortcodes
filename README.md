# tukutoi-shortcodes
 Indispensable ShortCodes for ClassicPress (and WordPress without Blocks) Websites.

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
