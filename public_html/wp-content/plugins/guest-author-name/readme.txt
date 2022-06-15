=== Plugin Name ===
Contributors: nomadcoder, seancjones
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=FTBD2UDXFJDB6
Tags: Guest Author Name, Override Author Name, Author
Requires at least: 4.1
Tested up to: 5.7
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html


Create a post and override the author name with one or more names or text. You can also create a link for the author name field

== Description ==
Version 4.32

Free

 Quickly and easily add a guest author to a post and link to the authors blog
 Display guest author name in posts
 Link author avatar
 Quick Edit

Create a post and override the author name with one or more names or text. You can also create a link for the author name field, add a description and an email address for the gravatar.

Premium
Sorry, we do not have the resources to manage sales and support right now. Our premium plugin should be available again in July 2020.

Additional Features:
1) Re-use & save guest authors
2) Upload guest author image
3) Guest author archives
4) Bulk edit guest authors in posts
5) Add guest authors to custom posts and pages
6) Easy Conversion process from our free version
7) Still supports gravatar and custom urls
8) Author list & Grid shortcodes
9) Supports Custom posts and author in searches
10) Elementor author archives
11) Author box
12) Filter posts by guest author
13) Now with multiple byline authors (coauthors)!
14) Now with shortcodes for author name, author link and author avatar



For quicker support, please visit the <a href="http://www.shooflysolutions.com/software/guest-author-name/">plugin page on the Shoofly Solutions web page</a>.

http://www.shooflysolutions.com/software/guest-author-name/
Donations for extended support are appreciated but are never required!

Please be kind and rate this plugin. Everything helps!
== Installation ==

Download the Guest Author Name plugin

How to install this plugin

###Method 1:
Install this plugin using the built-in plugin installer:
Go to Plugins > Add New.
Under Search, type "Guest Author Name"
Click Install Now.
A popup window will ask you to confirm your wish to install the Plugin.
Click Proceed to continue with the installation. The resulting installation screen will list the installation as successful or note any problems during the install.
If successful, click Activate Plugin to activate it, or Return to Plugin Installer for further actions.

###Method 2:
Download the plugin. In the WordPress admin panel, click on Plugins. Select Add New to get to the "Install Plugins" page. Click on browse and choose the downloaded file.

Click on the "Install Now" button to install the plugin. Once the plugin is installed, select "Activate Plugin".

###Method 3: (Advanced Users):

    Unzip the file. Using FTP, upload the guest-author folder to the contents/plugins folder in your wordpress directory.



    == Frequently Asked Questions ==

= How can I stop Guest Author posts from showing up on my posts feed?

As of 4.0, your guest author posts should no longer show up on your posts feed. If you still have this issue:

While the author link ideally should go to the authors web page, your guest author posts will show up as one of your posts. You can get around the list problem by creating a new user called Guest Author. Create your guest author posts under this user or use an author switch plugin to change the registered author. That way, guest author posts will show up under the user "Guest Authors" instead of your account.

Please visit the FAQ page on our site at <a href="http://www.shooflysolutions.com/faq/">http://www.shooflysolutions.com/faq/</a>

Our premium version handles this seamlessly.

= This plugin used to substitute Title Name with Author Name when using Jetpack Publicize. How do I get it back?

This was a bug, but if you were using it as a feature, then you can use this code below.

    add_filter('jetpack_open_graph_tags', function( $og_tags ) {
        $id = $this->get_post_id();
        $author = get_post_meta( $id, 'sfly_guest_author_names', true );
        if ( $author && is_singular() )  {

            $og_tags['og:title']           =   $author;
            // any other tags you want to add here
            // for more examples see https://gist.github.com/natebot/6323846
        }
        return $og_tags;
    });


== Screenshots ==

1. Override the post Author
2. Post with Guest Author
3. Settings Page
== Changelog ==
= 4.32 =
Fix avatar image for commente
Keep existing avatar url structure (should fix amp image width issue)
= 4.31 =
Update for AMP
Fix avatar image size
Move inline script to external script
= 4.30 =
Add code to disable guest author in comment section on posts
Add code to open guest author link in a new window
= 4.25 =
Add automerge
= 4.20 =
Update
= 4.12 =
Update notices, update readme description
= 4.11 =
= Attempt to fix Yoast canonical in paged archive/blog when a guest author is the first author in the list.
= Correct wording in settings =
= 4.10 =
= Fix errors saving post in guttenberg editor =
= 4.03 =
= Fix 4.0 beta to handle empty values
= 4.02 =
= Change in 4.00 is now beta +
= 4.01 =
= Beta version to test change in 4.00
= 4.00 =
= Filter guest authors out of author archive  =
= 3.99 =
= Fix for abspath warning message =
= 3.98
= Fix for doing ajax - guest author name should display while doing ajax
= 3.97
Don't display notifications for non admin users when they are logged in
= 3.96
= Reverse 3.95
= 3.95
= Don't display notifications for non admin users
= 3.92
= Add option to allow html in author description.
= 3.91
= Add option to display author name instead of base author
= 3.9 Fix links in nags.
      Remove author name replacement from admin (Under post list, original base author should be displayed not the guest author).
      Display avatars on archive pages
      Fix avatar for commenters (was picking up guest author avatar)
= 3.8 Add notice
= 3.7 Update tested date
= 3.6 Guest authors now populate the global author scope for better interoperability with expanded biographies.
= 3.5 Add option to enable Guest Author Name fields for quick edit.
= 3.4 Removed jetpack filter. For details on how to make author name the title, check "Frequently Asked Questions"
= 3.3 Fix undefined variable error on line 96 that would have caused the description not to be loaded.
= 3.2 Version upgrade
= 3.1 change priority to work with Pretty author box
= 3.0
* Fix code to work with Jetpack Subscriptions & Open Graph Tags. Known issue: The author link for posts sent to subscribers will link to the actual post author, not the guest author. This appears to be a possible limitation of Jetpack.
* 2.0
* Add code to manage author description/bio and gravatar for guest authors
* Add new fields for author bio and gravatar email address
* 1.1
* Fix for blank author link
* 1.0
* Initial Release

== Need More? ==

Need more? Customization is available. Contact sales@shooflysolutions.com for more information.
