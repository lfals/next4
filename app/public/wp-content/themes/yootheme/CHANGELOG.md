# Changelog

## 2.4.17 (May 28, 2021)

### Fixed

- Fix Sql field source with ORDER BY statement (Joomla)
- Fix missing version in exported builder sections and elements 

## 2.4.16 (May 19, 2021)

### Fixed

- Fix missing NEWS.md

## 2.4.15 (May 19, 2021)

### Added

- Add menu divider option to header and mobile navs, modules/widgets and Nav element
- Add link text option for items in all multiple items elements
- Add full width option for buttons across all elements
- Add grid options to align icons vertically for Social element
- Add option to animate the element or its items to Grid and Gallery elements
- Add option to disable filter animation in Grid and Gallery elements
- Add order by post order in custom posts source (WordPress)

### Changed

- Defer registering config to allow for child themes to modify e.g. translations

### Fixed

- Fix images not being clipped for round cards in Panel, Grid and Panel Slider elements
- Fix filter navigation not inheriting section animation in Grid and Gallery elements
- Fix image without link opening an empty modal in Image element
- Fix alignment of Navbar dropdowns in RTL mode
- Fix db null date no longer show in mapped source fields (Joomla)
- Fix nav menu accordion not working in modal/offcanvas layouts
- Fix empty default values in module/widget template/theme settings
- Fix php warning on empty search term

## 2.4.14 (April 26, 2021)

### Fixed

- Fix Less update script

## 2.4.13 (April 26, 2021)

### Added

- Add navbar line slide mode `left` and `center` to style customizer
- Add navbar mode `border` and `border-always` to style customizer
- Add navbar backdrop-filter option to style customizer
- Add more box-shadow options to style customizer
- Add card transform options to style customizer
- Add nav border options to style customizer

### Changed

- Allow setting a delay for element animations in milliseconds
- Navbar text items can no longer be closed by click if in hover mode

### Fixed

- Fix link styles if whole panel is linked in panel and overlay based elements
- Fix builder toolbar not displaying after save
- Fix keyboard accessibility in Navbar component

## 2.4.12 (April 20, 2021)

### Fixed

- Fix Builder Toolbar not registering itself correctly
- Fix Customizer cookie not being removed upon closing the customizer

## 2.4.11 (April 16, 2021)

### Fixed

- Fix memory leak in customizer
- Fix compatibility issue with location field
- Fix Toolset Image field returns absolute urls (WordPress)

## 2.4.10 (April 9, 2021)

### Fixed

- Fix Toolset Date field shows current date only (WordPress)
- Fix accordion open/close icons in Summit theme
- Fix rendering issues in Unsplash library
- Fix comments text in meta template (WordPress)
- Fix widget renders empty headline tag if title is empty (WordPress)

## 2.4.9 (April 6, 2021)

### Fixed

- Fix null value prevents the color picker from opening
- Fix asset caching from builder module with caching set to progressive (Joomla)
- Fix "Prefer excerpt over intro text" in article type (Joomla)

## 2.4.8 (March 29, 2021)

### Fixed

- Fix missing return statement in ViewTrait

## 2.4.7 (March 29, 2021)

### Added

- Add order by unpublish date to custom articles source (Joomla)

### Fixed

- Fix element library search
- Fix JavaScript error thrown by Maps element with no markers  
- Fix breadcrumbs show term trail for taxonomies (WordPress)
- Fix term select fields for taxonomies containing a dash in the name (WordPress)
- Fix disabled elements are no longer saved to introtext

## 2.4.6 (March 19, 2021)

### Fixed

- Fix missing `YOOtheme Builder` button when editing in frontend with TinyMCE (Joomla)
- Fix path handling in finder component (Joomla)
- Fix post teaser field renders wrong markup if using blocks (WordPress) 

## 2.4.5 (March 17, 2021)

### Added

- Add Design-Escapes style

## 2.4.4 (March 15, 2021)

### Fixed

- Fix copying view properties for 3rd party components (Joomla)
- Fix article event type source (Joomla)

## 2.4.3 (March 12, 2021)

### Added

- Make /component.php file overridable in child theme (Joomla)

### Fixed

- Fix maps element with google maps opens wrong marker popup on iOS
- Fix article event type source (Joomla)
- Fix default setting for mobile dropdown animation
- Fix `YOOtheme Builder` button appears on content editor only (WordPress)
- Fix position of `YOOtheme Builder` in post edit view with Gutenberg editor (WordPress)

## 2.4.2 (March 10, 2021)

### Added

- Add order and direction arguments to term children source (WordPress)

### Fixed

- Fix library search
- Fix links in map marker popups not in SEF form (Joomla)
- Fix email cloaking plugin within Maps element popup (Joomla)
- Fix Breadcrumbs include term ancestors now (WordPress)
- Fix menu item active state for post type archive page (WordPress)
- Fix search widget having duplicate id (WordPress)
- Fix Bootstrap modal being behind its backdrop (Joomla)

## 2.4.1 (March 5, 2021)

### Fixed

- Fix setting default values for source prop filters and arguments
- Fix breadcrumbs element on builder page (Joomla)
- Fix boxshadow field preview

## 2.4.0 (March 04, 2021)

### Added

- Add user as custom source 
- Add tags as custom source (Joomla)
- Add non-hierarchical taxonomies as custom sources (WordPress)
- Add the current logged in user as site source
- Add guest user field to site source
- Add concatenated source fields for list and checkboxes fields (Joomla)
- Add concatenated source fields for ACF select and checkbox fields and the Toolset checkboxes field (WordPress)
- Add template support for 404 error pages
- Add template support for Tagged Items, List All Tags, Search, Smart Search and Single Contact (Joomla)
- Add template support for author, date, search and non-hierarchical taxonomy archives (WordPress)
- Add filter to load tags from the selected parent tag only (Joomla)
- Add Show Taxonomy option to Meta field (Joomla)
- Add dynamic condition filters "Starts/Ends with"
- Add theme settings import and export buttons to advanced settings
- Add download all buttons to My Layouts, My Styles and My Element Presets libraries
- Add Panel Slider element to builder
- Add Search element to builder
- Add Nav element to builder
- Add viewport height option to Map element
- Add custom marker icon to Map element 
- Add marker clustering to Map element
- Add custom cluster icons and text colors to Maps element
- Add meta, image and link fields and settings to Map element
- Add minimum zoom and maximum zoom to Maps element
- Add Location custom field (Joomla)
- Add filter animations to Grid and Gallery elements
- Add panel style option to Grid Item and Panel Slider Item elements
- Add background size options for 100% width and height to Section and Column elements
- Add visibility option for background videos to Section element
- Add selecting an image from Media Library in builder will select the alt text too (WordPress)
- Add help videos for the page builder, layout library, element library and sections
- Add support for resizing webp images
- Add multi-line border radius option to form in style customizer
- Add customizer shows error in dev tools if duplicate id attributes are found

### Changed

- Rename Slider element to Overlay Slider
- Rename Map Marker element to Map Item
- Google Maps has at most one info window open at any time in Maps element
- Split settings of item elements into content and settings tabs
- Search view no longer requires jQuery/Bootstrap (Joomla)
- Date filter no longer shows current date for empty value

### Removed

- Remove order by Id in custom posts query, use date instead (WordPress)

### Fixed

- Fix text alignment not working for table headings in Table element
- Fix background color for blending mode in Overlay Slider element
- Fix tags with special characters cause filter to break
- Fix do not show empty popups in Maps element
- Fix setting active menu item for children (WordPress)
- Fix popup position in Maps element if Leaflet is used
- Fix editor no longer strips HTML markup
- Fix filter navigation in Grid and Gallery element if first tag is a number

## 2.4.0 beta 5 (March 2, 2021)

### Added

- Add customizer shows error in dev tools if duplicate id attributes are found
- Add Show Taxonomy option to Meta field (Joomla)
- Add selecting an image from Media Library in builder will select the alt text too (WordPress)

### Changed

- Date filter no longer shows current date for empty value

### Removed

- Remove order by Id in custom posts query, use date instead (WordPress)

### Fixed

- Fix filter navigation in Grid and Gallery element if first tag is a number

## 2.4.0 beta 4 (February 26, 2021)

### Fixed

- Fix search source (Joomla)
- Fix cluster icon text color picker in Maps element
- Fix editor no longer strips HTML markup

## 2.4.0 beta 3 (February 24, 2021)

### Added

- Add download all buttons to My Layouts, My Styles and My Element Presets libraries
- Add custom cluster icons to Maps element
- Add minimum zoom and maximum zoom options to Maps element
- Add multi-line border radius option to form in style customizer
- Add additional fields to Smart Search item type (Joomla)

### Fixed

- Fix setting active menu item for children (WordPress)
- Fix width/height setting of marker icon in Maps element
- Fix popup position in Maps element if Leaflet is used
- Fix translation strings for search input placeholder

## 2.4.0-beta.2 (February 19, 2021)

### Added

- Add error field to search source (Joomla)

### Fixed

- Fix do not show empty popups in Maps element
- Fix clustering markers in Leaflet
- Fix Group/Repeater ACF fields (WordPress)
- Fix current user fields return 'false' for guest users (WordPress)
- Fix custom users source default ordering (WordPress)
- Fix quantity and order options for custom tags query source (WordPress)

## 2.4.0-beta.1 (February 18, 2021)

### Added

- Add user as custom source 
- Add tags as custom source (Joomla)
- Add non-hierarchical taxonomies as custom sources (WordPress)
- Add the current logged in user as site source
- Add guest user field to site source
- Add concatenated source fields for list and checkboxes fields (Joomla)
- Add concatenated source fields for ACF select and checkbox fields and the Toolset checkboxes field (WordPress)
- Add template support for 404 error pages
- Add template support for Tagged Items, List All Tags, Search, Smart Search and Single Contact (Joomla)
- Add template support for author, date, search and non-hierarchical taxonomy archives (WordPress)
- Add filter to load tags from the selected parent tag only (Joomla)
- Add dynamic condition filters "Starts/Ends with"
- Add theme settings import and export buttons to advanced settings
- Add Panel Slider element to builder
- Add Search element to builder
- Add Nav element to builder
- Add viewport height option to Map element
- Add custom image marker option to Map element 
- Add marker clustering option to Map element
- Add meta, image and link fields and settings to Map element
- Add Location custom field (Joomla)
- Add filter animations to Grid and Gallery elements
- Add panel style option to Grid Item and Panel Slider Item elements
- Add background size options for 100% width and height to Section and Column elements
- Add visibility option for background videos to Section element
- Add help videos for the page builder, layout library, element library and sections
- Add support for resizing webp images

### Changed

- Rename Slider element to Overlay Slider
- Rename Map Marker element to Map Item
- Google Maps has at most one info window open at any time in Maps element
- Split settings of item elements into content and settings tabs
- Search view no longer requires jQuery/Bootstrap (Joomla)

### Fixed

- Fix text alignment not working for table headings in Table element
- Fix background color for blending mode in Overlay Slider element
- Fix tags with special characters cause filter to break

## 2.3.32 (February 12, 2021)

### Fixed

- Fix generating routes (Joomla)

## 2.3.31 (February 05, 2021)

### Changed

- Remove on standard property `zoom` property from Bootstrap (Joomla)

### Fixed

- Fix JPEG image orentation based on embeded EXIF data
- Fix page builder button in frontend editing with sh404sef plugin enabled (Joomla)
- Fix missing hook `wp_body_open` in header.php (WordPress)

## 2.3.30 (February 02, 2021)

### Changed

- Update Leaflet version to 1.7.1

### Fixed

- Fix builder element with attribute selectors in custom CSS field
- Fix background image resizing with lazy loading disabled

## 2.3.29 (January 22, 2021)

### Fixed

- Fix gallery subnav

## 2.3.28 (January 22, 2021)

### Changed

- Change archive heading from `h3` to `h1` (WordPress)

### Fixed

- Fix generating routes (Joomla)
- Fix customizer if "Shared Sessions" setting is enabled (Joomla)
- Fix customizer overrides theme style params other than 'config' (Joomla)
- Fix some SVG images
- Fix filter in Grid and Gallery element

## 2.3.27 (January 14, 2021)

### Fixed

- Fix missing Less styles

## 2.3.26 (January 14, 2021)

### Fixed

- Fix breadcrumbs not rendering article item (Joomla)
- Fix saving builder article for editors other than TinyMCE (Joomla)
- Fix admin.css is no longer loaded on edit module view (Joomla)

## 2.3.25 (December 10, 2020)

### Fixed

- Fix missing `YOOtheme Builder` button (WordPress)

## 2.3.24 (December 08, 2020)

### Fixed

- Fix sorting in builder
- Fix page builder button with multilanguage and sh404sef plugin enabled (Joomla)

## 2.3.23 (December 07, 2020)

### Fixed

- Fix scrollspy animations

## 2.3.22 (December 07, 2020)

### Fixed

- Fix mimetype for generated images
- Fix modal footer buttons in TinyMCE fullscreen mode (Joomla)
- Fix breadcrumbs not rendered when caching enabled (Joomla)
- Fix builder section scrolls to top unexpectedly
- Fix builder with no layout renders empty page

## 2.3.21 (December 03, 2020)

### Fixed

- Fix background images not loading with lazy loading disabled

## 2.3.20 (December 02, 2020)

### Fixed

- Fix image path handling with WPML enabled (WordPress)
- Fix page layout for article view with caching enabled (Joomla)

## 2.3.19 (November 26, 2020)

### Fixed

- Fix mapping of nested group/repeater ACF fields (WordPress)
- Fix page builder button not showing on article edit form without editor-xtd buttons (Joomla)
- Fix 'Limit By Tags' list shows categories (Joomla)

## 2.3.18 (November 20, 2020)

### Fixed

- Fix use unique source schema cache files
- Fix php warning with ArticleEventType (Joomla)
- Fix link picker modal height (Joomla)
- Fix imagelist field (Joomla)

## 2.3.17 (November 18, 2020)

### Fixed

- Fix breadcrumbs for date archive pages (WordPress)

## 2.3.16 (November 16, 2020)

### Added

- Add fullscreen button to visual editor (WordPress)

### Fixed

- Fix social icons not being rendered in mobile header
- Fix 'enter' closes customizer on search input in modals
- Fix module section causes error in customizer (Joomla)
- Fix 'Posts page' menu item active on custom post type post (WordPress)
- Fix images with capitalized file extension not resizing

## 2.3.15 (November 05, 2020)

### Fixed

- Fix templates without layout cause blank page (WordPress)
- Fix templates no longer match on WooCommerce pages (WordPress)
- Fix notice if tinymce plugin is not installed (Joomla)

## 2.3.14 (November 03, 2020)

### Fixed

- Fix featured image not collapsing in dynamic content source (WordPress)
- Fix filtering of custom posts query (WordPress)
- Fix error "Invalid page template." while saving page in builder (WordPress)

## 2.3.13 (October 29, 2020)

### Changed

- Files returned by Filesystem sources must be located in systems upload folder

### Fixed

- Fix overriding 'offline.php' file in child theme (Joomla)
- Fix url to downloaded images on saving builder layouts (WordPress)

## 2.3.12 (October 23, 2020)

### Fixed

- Fix visual editor with 3rd party editor buttons installed (Joomla)

## 2.3.11 (October 23, 2020)

### Fixed

- Fix Media Picker for file source (WordPress)
- Fix attachment urls in dynamic content if site_url differs from home_url (WordPress)

## 2.3.10 (October 22, 2020)

### Fixed

- Fix attachment urls if 'upload_url_path' is set (WordPress)
- Fix insert from library not respecting chosen location

## 2.3.9 (October 21, 2020)

### Fixed

- Fix missing image if viewport height and text color is set in Slider element
- Fix Unsplash library displacement (WordPress)

## 2.3.8 (October 21, 2020)

### Fixed

- Fix inverting the text color on hover in Overlay, Gallery and Slider elements
- Fix editor toolbar not wrapping into the next line in small panels (Joomla)
- Fix template saving with 'json_post' PECL extension enabled (Joomla)

## 2.3.7 (October 20, 2020)

### Fixed

- Fix broken visual editor (Joomla)

## 2.3.6 (October 20, 2020)

### Added

- Add Paladin theme style

### Changed

- Improve breadcrumbs wrapping into the next line

### Fixed

- Fix pages filter for category templates (WordPress)
- Fix module save in customizer with Advanced Module Manager (Joomla)

## 2.3.5 (October 16, 2020)

### Fixed

- Fix wrong call to 'getPagination' in template matching (Joomla)

## 2.3.4 (October 16, 2020)

### Fixed

- Fix Url rewriting (WordPress)
- Fix error route handling (Joomla)
- Fix long breadcrumbs not wrapping into the next line

## 2.3.3 (October 15, 2020)

### Fixed

- Fix JCE editor in fullscreen mode (Joomla)
- Fix image loading with GZip compression enabled (Joomla)
- Fix Igallery plugin shortcode errors (Joomla)

## 2.3.2 (October 14, 2020)

### Fixed

- Fix image loading with SEF URLs enabled
- Fix PHP warning on modules administration (Joomla)

## 2.3.1 (October 13, 2020)

### Fixed

- Fix image loading in Google Chrome browser (Joomla)

## 2.3.0 (October 13, 2020)

### Added

- Add custom file source
- Add upload and download buttons to My Layouts, My Styles and My Element Presets libraries
- Add search with autofocus and item count to all libraries
- Add modify date to My Layouts, My Styles and My Element Presets libraries
- Add matching indicator to My Layouts and My Styles libraries
- Add search to field mapping dropdown
- Add option to limit the template assignment to the page number for index pages
- Add button to recompile the style to style customizer
- Add support for any Joomla editor plugin (Joomla)
- Add border and background options to lightbox button in style customizer
- Add help videos for updating, minimum stability, changelog, dynamic conditions and more

### Changed

- Use own tinyMCE as visual editor (Joomla)
- Disable visual editor if disabled in system config (Joomla)
- Make Module and Widget elements cross-system compatible
- Make Position and Area elements cross-system compatible
- Refactor load event for builder templates (Joomla)
- Refactor builder-templates matching
- Use autoloading for component helpers (Joomla)
- Refactor route handling using com_ajax (Joomla)
- Refactor event dispatcher using event objects (Joomla)
- Improve GraphQL query execution performance
- Make current menu parent items active in menus (WordPress)

### Fixed

- Fix builder collision detection
- Fix memory leak with tinyMCE editor plugins (WordPress)
- Fix template rendering with activated system cache (Joomla)
- Fix Category/Tag Archive not selectable in templates if WooCommerce is active (WordPress)
- Fix breadcrumbs if no posts page is assigned (WordPress)
- Fix images saved to cache in customizer mode
- Fix margin if pagination items wrap into the next line in Pagination elements
- Fix media overlay not being below mobile navbar in boxed page layout
- Fix match height if panels wrap into the next row in row settings
- Fix left/right aligned images not covering cards with different heights in Panel element
- Fix countdown element placeholder behavior

## 2.3.0-beta.7 (October 09, 2020)

### Fixed

- Fix images saved to cache in customizer mode
- Fix builder collision detection

## 2.3.0-beta.6 (October 05, 2020)

### Changed

- Improve GraphQL query execution performance
- Disable visual editor if disabled in system config (Joomla)

### Fixed

- Fix memory leak with tinyMCE editor plugins (WordPress)

## 2.3.0-beta.5 (September 25, 2020)

### Added

- Add custom file source
- Add search to field mapping dropdown
- Add option to limit the template assignment to the page number for index pages
- Add search with autofocus and item count to all libraries
- Add upload and download buttons to My Layouts, My Styles and My Element Presets libraries
- Add modify date to My Layouts, My Styles and My Element Presets libraries
- Add matching indicator to My Layouts and My Styles libraries
- Add button to recompile the style to style customizer
- Add help videos for updating, minimum stability, changelog, dynamic conditions and more
- Add border and background options to lightbox button in style customizer
- Add support for any Joomla editor plugin (Joomla)

### Changed

- Use own tinyMCE as visual editor (Joomla)
- Make Module and Widget elements cross-system compatible
- Make Position and Area elements cross-system compatible
- Make current menu parent items active in menus (WordPress)

### Fixed

- Fix margin if pagination items wrap into the next line in Pagination elements
- Fix media overlay not being below mobile navbar in boxed page layout

## 2.3.0-beta.4 (September 14, 2020)

### Changed

- Use autoloading for component helpers (Joomla)
- Refactor route handling using com_ajax (Joomla)
- Refactor event dispatcher using event objects (Joomla)

### Fixed

- Fix breadcrumbs if no posts page is assigned (WordPress)

## 2.3.0-beta.3 (September 4, 2020)

### Fixed

- Fix match height if panels wrap into the next row in row settings
- Fix template rendering with activated system cache (Joomla)
- Fix Category/Tag Archive not selectable in templates if WooCommerce is active (WordPress)

## 2.3.0-beta.2 (September 2, 2020)

### Changed

- Refactor builder-templates matching

### Fixed

- Fix left/right aligned images not covering cards with different heights in Panel element

## 2.3.0-beta.1 (August 26, 2020)

### Changed

- Refactor load event for builder templates (Joomla)

## 2.2.4 (August 21, 2020)

### Added

- Add 2xlarge overlay width to Overlay and Gallery elements

### Fixed

- Fix columns set to 2xlarge no longer wrap in builder layout view
- Fix missing check for post_type rest_base causing Source Field not to show (WordPress)

## 2.2.3 (August 17, 2020)

### Added

- Add link options to Slider element
- Add option to force left content alignment to Panel element
- Add link heading as style option to List element
- Add featured image caption mapping (WordPress)

### Fixed

- Fix title wrapping onto multiple lines in To Top element
- Fix accordion menus in mobile position
- Fix inverting the text color on hover in Overlay and Gallery elements
- Fix dynamic condition arguments no longer show if dynamic source is set to none
- Fix margin for pagebreak navigation
- Fix content overflow in 1-column row layout
- Fix custom categories ordering (Joomla)

## 2.2.2 (August 03, 2020)

### Fixed

- Fix rendering post excerpt (WordPress)
- Fix Preview handling (WordPress)
- Fix Sticky Navbar closing unexpectedly
- Fix compiled data URIs in theme.css when stored in child theme folder

## 2.2.1 (July 30, 2020)

### Fixed

- Fix menu rendering with Stacked Center Split menu

## 2.2.0 (July 29, 2020)

### Added

- Add filter options to custom post source
- Add alphanumeric order option for custom sources
- Add HTML element option for meta text in elements
- Add dynamic condition option to Divider element
- Add field mapping for transparent header option in Section element
- Add custom attributes option to row builder element
- Add `Stacked Center C` layout to header layouts
- Add support for search suggestions in Smart Search module (Joomla)
- Add help videos for custom fields, custom post types and 3rd party integration (WordPress)
- Add link field and more title and content options to Alert element
- Add HTML element option for title to Description List element
- Add xl grid breakpoint to Accordion, Panel, Grid, Gallery and Switcher elements
- Add navbar rail mode to style customizer
- Add title field to To Top element
- Add next page button to pagebreak navigation (WordPress)
- Add support for Toolset address field (WordPress)
- Add title grid options to To Top element
- Add image option to navbar menu items (WordPress)

### Changed

- Refactor GraphQL schema configuration
- Refactor page break navigation
- Make the Social element an multiple items element
- Move cookie banner bar to bottom of document body in dom
- Change Fjord `h4` and Horizon `h6` heading colors
- Change URL generation to use content directory (WordPress)
- Make Search Style option available in Layout settings for modules/widgets

### Fixed

- Fix date filter not translating according to site language (WordPress)
- Fix apply the_content filter to builder main content output only (WordPress)
- Fix include `pagination.php` from child-theme folder (Joomla)
- Fix empty multiple sources render placeholder item
- Fix elements with invalid source collapse
- Fix none deferred, enqueued scripts and styles are not rendered in footer (WordPress)
- Fix determining the current locale (WordPress)
- Fix category articles source no longer contains link items (Joomla)
- Fix article permalink not using https (Joomla)
- Fix WooCommerce style compiling (WordPress)
- Fix ACF date using wrong time zone (WordPress)
- Fix wpautop filter for source post content (WordPress)
- Fix Toolset repetitive fields
- Fix drop cap option in builder for page break navigation
- Fix remove margin for meta text if HTML element is an heading in elements
- Fix title style update script in Description List element
- Fix child theme custom Less style meta parsing
- Fix My Customizations modal not instantly showing changes
- Fix breadcrumbs not showing the posts page on the single post, category and tag archive (WordPress)
- Remove `loop_shop_per_page` filter to fix the Columns per page option in WooCommerce (WordPress)
- Fix unsaved changes warning not showing when clicking on link in preview (WordPress)
- Fix unsaved changes warning not showing when closing template section
- Fix search and social icons widgets position for Stacked Center C layout (WordPress)

## 2.2.0-beta.5 (July 22, 2020)

### Added

- Add title grid options to To Top element
- Add image option to navbar menu items (WordPress)

### Changed

- Change URL generation to use content directory (WordPress)

### Fixed

- Fix unsaved changes warning not showing when clicking on link in preview (WordPress)

## 2.2.0-beta.4 (July 14, 2020)

### Added

- Add next page button to pagebreak navigation (WordPress)
- Add support for Toolset address field (WordPress)

### Fixed

- Fix child theme custom Less style meta parsing
- Fix My Customizations modal not instantly showing changes
- Fix breadcrumbs not showing the posts page on the single post, category and tag archive (WordPress)
- Remove `loop_shop_per_page` filter to fix the Columns per page option in WooCommerce (WordPress)

## 2.2.0-beta.3 (July 10, 2020)

### Added

- Add title field to To Top element

### Fixed

- Fix title style update script in Description List element

## 2.2.0-beta.2 (July 09, 2020)

### Added

- Add link field and more title and content options to Alert element
- Add HTML element option for title to Description List element
- Add xl grid breakpoint to Accordion, Panel, Grid, Gallery and Switcher elements
- Add navbar rail mode to style customizer

### Fixed

- Fix WooCommerce style compiling (WordPress)
- Fix ACF date using wrong time zone (WordPress)
- Fix wpautop filter for source post content (WordPress)
- Fix Toolset repetitive fields
- Fix drop cap option in builder for page break navigation
- Fix remove margin for meta text if HTML element is an heading in elements

## 2.2.0-beta.1 (July 02, 2020)

### Added

- Add filter options to custom post source
- Add alphanumeric order option for custom sources
- Add HTML element option for meta text in elements
- Add dynamic condition option to Divider element
- Add field mapping for transparent header option in Section element
- Add custom attributes option to row builder element
- Add `Stacked Center C` layout to header layouts
- Add support for search suggestions in Smart Search module (Joomla)
- Add help videos for custom fields, custom post types and 3rd party integration (WordPress)

### Changed

- Refactor GraphQL schema configuration
- Refactor page break navigation
- Make the Social element an multiple items element
- Move cookie banner bar to bottom of document body in dom
- Change Fjord `h4` and Horizon `h6` heading colors

### Fixed

- Fix date filter not translating according to site language (WordPress)
- Fix apply the_content filter to builder main content output only (WordPress)
- Fix include `pagination.php` from child-theme folder (Joomla)
- Fix empty multiple sources render placeholder item
- Fix elements with invalid source collapse
- Fix none deferred, enqueued scripts and styles are not rendered in footer (WordPress)
- Fix determining the current locale (WordPress)
- Fix category articles source no longer contains link items (Joomla)
- Fix article permalink not using https (Joomla)

## 2.1.2 (July 07, 2020)

### Added

- Add Kitchen Daily theme style

## 2.1.1 (June 16, 2020)

### Fixed

- Fix widget rendering in widget element (WordPress)
- Fix site > page title source (Joomla)
- Fix missing limit filter for repeatable text fields (Joomla)

## 2.1.0 (June 16, 2020)

### Added

- Add dynamic conditions to display elements depending on a content field
- Add custom fields support for Toolset plugin (WordPress)
- Add content source support for WordPress Popular Posts plugin (WordPress)
- Add page builder support for custom post types (WordPress)
- Add excerpt option to teaser source
- Add teaser option to content source (WordPress)
- Add Featured Articles Order option to custom articles source (Joomla)
- Add 5 column layout presets to row layouts in builder
- Add row layout settings to customize the columns widths for each breakpoint in builder
- Add order first option for each column to row layout settings in builder
- Add hidden options to visibility setting in elements
- Add status icons for element visibility to builder
- Add status option to element items
- Add custom attributes option to builder elements
- Add marker type and color options to List and Description List elements
- Add collapse size option to List and Description List elements
- Add HTML element option to List and Description List elements
- Add column options to List, Description List, Panel, Grid, Accordion and Switcher elements
- Add dropcap option to Panel, Grid, Accordion and Switcher elements
- Add meta to content style option in elements
- Add more image and title grid widths to Accordion, Grid, Panel and Switcher elements
- Add field mapping for text color option to builder elements
- Add `logo` and `logo-mobile` module positions and widget areas
- Add current page and home display options to breadcrumbs layout settings
- Add social icons size and gap options to header layout
- Add help videos for dynamic content and templates (WordPress)

### Changed

- Make icon size based on width instead of ratio in builder elements
- Refactor breadcrumbs widget and element (WordPress)
- Update Google Fonts list

### Fixed

- Fix bottom margin if content is linked in List and Description List elements
- Fix Vimeo and Youtube video size if only width or height is set
- Fix Newsletter element in IE 11
- Fix post multiple categories styling (WordPress)
- Fix shortcode plugin assets not rendered (WordPress)
- Fix search module setting not affecting mobile search module (Joomla)
- Fix redirect builder pages to login page if "Show Unauthorised Links" is true (Joomla)
- Fix icon width update script in Grid and List elements
- Fix filtering Popular Posts by taxonomy (WordPress)
- Fix empty ACF Gallery element renders placeholder (WordPress)
- Fix date filter uses default date format (WordPress)
- Fix wrong profile link in login module (Joomla)
- Fix author uses created by alias (Joomla)
- Fix custom `uk-scrollspy` attribute not being applied in sections
- Fix loading `config.php` from child-theme (WordPress)
- Fix text not being truncated in dynamic input field
- Fix dynamic content for grid and group field types
- Fix Single Post Page Navigation (WordPress)
- Fix pagination element if the plugin is disabled (Joomla)
- Fix shortcode widgets not rendered (WordPress)
- Fix shortcodes being applied to saved post content (WordPress)

## 2.1.0-beta.3 (June 11, 2020)

### Added

- Add field mapping for text color option to builder elements
- Add help videos for dynamic content and templates (WordPress)

### Fixed

- Fix icon width update script in Grid and List elements
- Fix filtering Popular Posts by taxonomy (WordPress)
- Fix empty ACF Gallery element renders placeholder (WordPress)
- Fix date filter uses default date format (WordPress)
- Fix wrong profile link in login module (Joomla)
- Fix author uses created by alias (Joomla)
- Fix custom `uk-scrollspy` attribute not being applied in sections
- Fix loading `config.php` from child-theme (WordPress)
- Fix text not being truncated in dynamic input field
- Fix dynamic content for grid and group field types
- Fix Single Post Page Navigation (WordPress)
- Fix pagination element if the plugin is disabled (Joomla)

## 2.1.0-beta.2 (June 05, 2020)

### Changed

- Update Google Fonts list

### Fixed

- Fix post multiple categories styling (WordPress)
- Fix shortcode plugin assets not rendered (WordPress)
- Fix search module setting not affecting mobile search module (Joomla)
- Fix redirect builder pages to login page if "Show Unauthorised Links" is true (Joomla)

## 2.1.0-beta.1 (June 04, 2020)

### Added

- Add dynamic conditions to display elements depending on a content field
- Add custom fields support for Toolset plugin (WordPress)
- Add content source support for WordPress Popular Posts plugin (WordPress)
- Add page builder support for custom post types (WordPress)
- Add excerpt option to teaser source
- Add teaser option to content source (WordPress)
- Add Featured Articles Order option to custom articles source (Joomla)
- Add 5 column layout presets to row layouts in builder
- Add row layout settings to customize the columns widths for each breakpoint in builder
- Add order first option for each column to row layout settings in builder
- Add hidden options to visibility setting in elements
- Add status icons for element visibility to builder
- Add status option to element items
- Add custom attributes option to builder elements
- Add marker type and color options to List and Description List elements
- Add collapse size option to List and Description List elements
- Add HTML element option to List and Description List elements
- Add column options to List, Description List, Panel, Grid, Accordion and Switcher elements
- Add dropcap option to Panel, Grid, Accordion and Switcher elements
- Add meta to content style option in elements
- Add more image and title grid widths to Accordion, Grid, Panel and Switcher elements
- Add `logo` and `logo-mobile` module positions and widget areas
- Add current page and home display options to breadcrumbs layout settings
- Add social icons size and gap options to header layout

### Changed

- Make icon size based on width instead of ratio in builder elements
- Refactor breadcrumbs widget and element (WordPress)

### Fixed

- Fix bottom margin if content is linked in List and Description List elements
- Fix Vimeo and Youtube video size if only width or height is set
- Fix Newsletter element in IE 11

## 2.0.14 (June 03, 2020)

### Fixed

- Fix text wrapping into the next line for dynamic input fields
- Fix stripping `<del>` HTML element if whole element is linked
- Fix syntax highlighting in code element (WordPress)

## 2.0.13 (May 12, 2020)

### Changed

- Automatically hide empty terms (WordPress)

## 2.0.12 (May 07, 2020)

### Fixed

- Fix item alignment in masonry grid
- Fix encoding of unicode strings

## 2.0.11 (May 07, 2020)

### Fixed

- Fix broken customizer in non-English installations (WordPress)

## 2.0.10 (May 06, 2020)

### Fixed

- Fix duplicated dropdown menu items

## 2.0.9 (May 06, 2020)

### Added

- Add date format option to meta field

### Changed

- Change numbers on either start and end pagination edges to 3 (WordPress)

### Removed

- Remove Show Start/End links option from Pagination element

### Fixed

- Remove menu item active class for posts_page if currently on none blog page (WordPress)
- Fix PHP 7.0 compatibility
- Fix article field labeling/ordering (Joomla)
- Fix Image does not collapse if attachment does not exist (WordPress)
- Fix closing title html element in comment form (WordPress)
- Fix `...` in Pagination no longer render as link
- Fix title link in article meta name (Joomla)
- Fix theme button on widgets edit screen (WordPress)
- Fix default quantity option for Page Posts source (WordPress)
- Fix missing show link option for Post Taxonomy String source (WordPress)
- Fix duplicate content output on plugin pages (WordPress)
- Fix display of date picker, date time picker, time picker ACF fields (WordPress)
- Fix `YOOtheme Builder` media button (WordPress)
- Fix columns setting for navbar items resulting in wrong number of columns
- Fix tags field for category source (Joomla)
- Fix collapsing behavior of button element

## 2.0.8 (April 22, 2020)

### Added

- Add order by comment count for Custom Posts Query (WordPress)
- Add coordinates prop to GoogleMaps custom field (WordPress)
- Add limit filter to ACF text fields (WordPress)
- Add secondary text color as option to elements

### Changed

- Apply before/after filters on dynamically mapped fields only if it has a value
- Trim whitespace on dynamically mapped field values

### Fixed

- Fix display title effects tab navigation in Switcher element
- Fix offline image not shown (Joomla)
- Fix deprecation warning on post edit screen (WordPress >= 3.5.0)
- Fix article event fields for custom articles (Joomla)
- Fix image resizing with dynamic content (WordPress)

## 2.0.7 (April 9, 2020)

### Added

- Add help videos for dynamic content and templates (Joomla)

## 2.0.6 (April 9, 2020)

### Added

- Add field mapping for dynamic content to Social element
- Add indicator if template is disabled in the template overview

### Changed

- Collapse elements if all their content is empty

### Fixed

- Fix error on extended IPTC metadata when saving cache `jpg` images
- Fix left/right aligned images not covering cards with different heights in Grid element
- Fix Filter reverse order on numeric tags in Grid and Gallery element
- Fix asset urls with WPML plugin (WordPress)

## 2.0.5 (March 19, 2020)

### Added

- Add link style option to meta and tags field
- Add Parent Category Source (Joomla)
- Pre-select View Type field in template modal (Joomla)

### Changed

- Collapse elements if they have items but all their content is empty

### Fixed

- Fix meta field template (Joomla)
- Fix JCE editor style (Joomla)
- Fix "Open Templates" button (Joomla)
- Fix user link in meta template (Joomla)
- Fix templates no longer override templates with same name (Joomla)

## 2.0.4 (March 13, 2020)

### Fixed

- Fix loading menu module in J!Module element in templates (Joomla)
- Fix `menu_style` not applied in J!Module element (Joomla)
- Fix loading html overrides from child-theme (Joomla)
- Fix PHP 5.6 compatibility issue (Joomla)
- Fix theme styles loading

## 2.0.3 (March 12, 2020)

### Fixed

- Fix update scripts not being applied
- Fix transparent navbar container padding not being applied
- Fix `com_search` form with no results returned (Joomla)

## 2.0.2 (March 11, 2020)

### Fixed

- Fix loading `config.php` from child-theme (Joomla)

### Added

- Add profile link to `mod_login` override (Joomla)
- Add frontend edit button to template layouts (Joomla)

## 2.0.1 (March 10, 2020)

### Fixed

- Fix namespace in `/config.php` (Joomla)

## 2.0.0 (March 10, 2020)

### Added

- Add field mapping for dynamic content to elements
- Add current page content sources
- Add custom queried content sources
- Add related content sources
- Add multiple items content sources
- Add support for page, post, category, tag and user source types
- Add support for custom post types and taxonomies as source type (WordPress)
- Add custom fields support for field mapping
- Add custom fields support for Advanced Custom Field plugin (WordPress)
- Add custom fields support for Article Field from Regular Labs (Joomla)
- Add template builder
- Add template support for Category Blog, Single Article and Featured Articles (Joomla)
- Add template support for Single, Archive, Post Type Archive and Posts Page (WordPress)
- Add Breadcrumbs, Pagination and Comments elements
- Add status icons for disabled and positioned elements to builder
- Add id and class options to row columns in builder
- Add option to remove horizontal padding from section and row containers
- Add option to center rows and columns to Grid and Gallery elements
- Add column width auto to Grid and Gallery elements
- Add option to reverse filter navigation to Grid and Gallery elements
- Add link options to Panel, Grid, Popover, Overlay and Gallery elements
- Add hover effects for title to Popover, Overlay and Gallery elements
- Add xlarge width to Row, Section and Slideshow element and header, blog and layout options
- Add 2xlarge overlay width to Slideshow and Slider elements
- Add `div` to HTML element option in elements
- Add `com_finder` component override (Joomla)
- Add `separator` and `show_link` filters to Article Tags source (Joomla)
- Add warning if builder module wasn't saved (Joomla)

### Changed

- IMPORTANT: Breaking changes for template files and module API
- IMPORTANT: Change PHP requirement from 5.4 to 5.6
- Refactor dependency injection
- Refactor module configuration
- Refactor boot files, e.g. index.php is now bootstrap.php
- Group elements into basic, container and system elements in element library
- Group layouts into pages and templates in layout library
- Group section, row and column setting in tabs in builder
- File upload uses allowed file extensions and MIME types from system settings (Joomla)
- Collisions detection changed to hash over article/post content
- Update `mod_articles_news` module override to support article images (Joomla)
- Update `com_search` component override (Joomla)

### Fixed

- Fix collision notification
- Fix URL generation issue
- Fix https detection for routing
- Fix support for hosting environment with a changed `wp-content` folder location
- Fix 'save' and 'save as copy' could corrupt Builder data in article (Joomla)
- Fix error "Service 'Joomla\CMS\User\User' is not defined" on SunOS (Joomla)
- Fix color picker hex values
- Fix loading RTL stylesheet
- Fix duplicate attribute `rel="stylesheet"`
- Fix styler preview in customizer (WordPress)
- Fix image download in layout library
- Fix cookie `notification` mode blocking script execution
- Fix default `limit` for articles in Category template (Joomla)
- Fix separator field being always disabled in `meta` source field (Joomla)
- Fix disabled `System - Fields` plugin throws error (Joomla)
- Fix filtering Custom Articles source by tag (Joomla)
- Fix Breadcrumbs not showing current item (Joomla)
- Fix load single value of multiple items content sources (Joomla)
- Fix disappearing image when left/right aligned after stacking in Panel and Grid elements
- Fix `Stacked Left B` header layout
- Fix keyboard navigation in accordion menu
- Fix file `css/custom.css` and `js/custom.js` not loaded
- Fix mod_languages default styling (Joomla)
- Fix overrides in child-theme folder (Joomla)
- Fix load custom elements from child-theme folder (Joomla)
- Fix custom code not available (Joomla)
- Fix Builder panels UI (WordPress)
- Fix link picker (WordPress)
- Fix comments reply form (WordPress)
- Fix Toolset plugin compatibility (WordPress)
- Fix Undefined filter 'builder'
- Fix error Class `YOOtheme\FinderHelperRoute` not found (Joomla)
- Fix random ordering in article source (Joomla)
- Fix breadcrumbs element in builder module (Joomla)
- Fix newsletter element

## 2.0.0-beta.10 (March 5, 2020)

### Fixed

- Fix disabled `System - Fields` plugin throws error (Joomla)
- Fix filtering Custom Articles source by tag (Joomla)
- Fix Breadcrumbs not showing current item (Joomla)
- Fix load single value of multiple items content sources (Joomla)
- Fix keyboard navigation in accordion menu
- Fix cookie `notification` mode blocking script execution

## 2.0.0-beta.9 (February 28, 2020)

### Added

- Add field mapping for dynamic content to elements
- Add current page content sources
- Add custom queried content sources
- Add related content sources
- Add multiple items content sources
- Add support for page, post, category, tag and user source types
- Add support for custom post types and taxonomies as source type (WordPress)
- Add custom fields support for field mapping
- Add custom fields support for Advanced Custom Field plugin (WordPress)
- Add custom fields support for Article Field from Regular Labs (Joomla)
- Add template builder
- Add template support for Category Blog, Single Article and Featured Articles (Joomla)
- Add template support for Single, Archive, Post Type Archive and Posts Page (WordPress)
- Add Breadcrumbs, Pagination and Comments elements
- Add status icons for disabled and positioned elements to builder
- Add id and class options to row columns in builder
- Add option to remove horizontal padding from section and row containers
- Add option to center rows to Grid and Gallery element

### Changed

- Group elements into basic, container and system elements in element library
- Group layouts into pages and templates in layout library
- Group section, row and column setting in tabs in builder
- File upload uses allowed file extensions and MIME types from system settings (Joomla)
- Collisions detection changed to hash over article/post content

### Fixed

- Fix collision notification

## 2.0.0-beta.8 (February 13, 2020)

### Fixed

- Fix override `index.php` in child-theme (Joomla)
- Fix 'save' and 'save as copy' could corrupt Builder data in article (Joomla)
- Fix disappearing image when left/right aligned after stacking in Panel and Grid element
- Fix loading RTL stylesheet
- Fix color picker hex values

### Changed

- Update `mod_articles_news` module override to support article images (Joomla)

## 2.0.0-beta.7 (January 30, 2020)

### Fixed

- Fix styler preview in customizer (WordPress)
- Fix overrides in child-theme folder (Joomla)
- Fix https detection for routing

## 2.0.0-beta.6 (January 23, 2020)

### Added

- Add link options to Panel, Grid, Popover, Overlay and Gallery element
- Add hover effects for title to Popover, Overlay and Gallery element
- Add xlarge width to Row, Section and Slideshow element and header, blog and layout options
- Add `div` to HTML element option in elements
- Add option to reverse filter navigation to Grid and Gallery element
- Add 2xlarge overlay width to Slideshow and Slider element
- Add `com_finder` component override (Joomla)

### Changed

- Update `com_search` component override (Joomla)

### Fixed

- Fix support for hosting environment with a changed `wp-content` folder location
- Fix Builder panels UI (WordPress)
- Fix link picker (WordPress)
- Fix `Stacked Left B` header layout
- Fix duplicate attribute `rel="stylesheet"`
- Fix comments reply form (WordPress)

## 2.0.0-beta.5 (December 13, 2019)

### Fixed

- Fix error "Service 'Joomla\CMS\User\User' is not defined" on SunOS (Joomla)
- Fix load custom elements from child-theme folder (Joomla)

## 2.0.0-beta.4 (December 11, 2019)

### Added

- Add option to center columns to Grid and Gallery element
- Add column width auto to Grid and Gallery element
- Add warning if builder module wasn't saved (Joomla)

### Fixed

- Fix mod_languages default styling (Joomla)
- Fix image download in layout library
- Fix URL generation issue

## 2.0.0-beta.3 (December 10, 2019)

### Fixed

- Fix Undefined filter 'builder'
- Fix custom code not available (Joomla)
- Fix file `css/custom.css` and `js/custom.js` not loaded
- Fix error Class `YOOtheme\FinderHelperRoute` not found (Joomla)

## 2.0.0-beta.2 (December 10, 2019)

### Fixed

- Fix URL generation issue

## 2.0.0-beta.1 (December 09, 2019)

### Changed

- IMPORTANT: Breaking changes for template files and module API
- IMPORTANT: Change PHP requirement from 5.4 to 5.6
- Refactor dependency injection
- Refactor module configuration
- Refactor boot files, e.g. index.php is now bootstrap.php

### Fixed

- Fix Toolset plugin compatibility (WordPress)

## 1.22.8 (January 23, 2020)

### Fixed

- Fix PHP notice on search results (Joomla)

## 1.22.7 (January 09, 2020)

### Fixed

- Fix PHP warning on builder pages with PHP >= 7.4

## 1.22.6 (November 13, 2019)

### Fixed

- Fix 'save as copy' missing Builder data in copied article (Joomla)
- Fix entering the word 'latin' in the `Languages` field of Google Fonts panel
- Fix WordPress 5.3 compatibility (WordPress)

## 1.22.5 (November 05, 2019)

### Fixed

- Fix sidebar breakpoint is not applied

## 1.22.4 (November 04, 2019)

### Fixed

- Fix article editor 'save' corrupts builder layout (Joomla)
- Fix post gallery only shows featured image (WordPress)
- Fix default sidebar settings

## 1.22.3 (October 23, 2019)

### Fixed

- Fix show 'register to read more' link on access restricted articles (Joomla)
- Fix syntax error in custom code when commenting last code line
- Fix error on extended IPTC metadata when saving cache `jpg` images

## 1.22.2 (October 15, 2019)

### Fixed

- Fix PHP Warning on blog pages

## 1.22.1 (October 14, 2019)

### Fixed

- Fix one column blog layouts not constraining child widths

## 1.22.0 (October 14, 2019)

### Added

- Add column and row gap options to elements
- Add column and row gap options to blog, top and bottom layout settings
- Add possibility to create accordion menus in mobile position
- Add possibility to create menu headings and dividers (WordPress)
- Add `mod_language` module override (Joomla)
- Add IPTC metadata when saving cache `jpg` images
- Add help videos for blog, posts, menus, builder module, post builder and module and position elements

### Changed

- Use the gap option for the one column blog layout instead of defining the gap size in CSS
- Change behavior when an accordion menu item is displayed

### Fixed

- Fix column not expanding if sibling column collapses in rare cases
- Fix `YOOtheme Builder` button in frontend editing on new articles (Joomla)
- Fix Leaflet map marker popup position on load
- Fix Module Header Class (Joomla)
- Fix passing `layout` parameter in URL (Joomla)
- Fix active menu item state for blog and shop pages (WordPress)
- Fix customizer sidebar in RTL mode (WordPress)
- Fix readmore button if the post excerpt is used

## 1.22.0-beta.2 (September 23, 2019)

### Added

- Add IPTC metadata when saving cache `jpg` images

### Fixed

- Fix Module Header Class (Joomla)
- Fix passing `layout` parameter in URL (Joomla)
- Fix active menu item state for blog and shop pages (WordPress)
- Fix customizer sidebar in RTL mode (WordPress)
- Fix readmore button if the post excerpt is used

## 1.22.0-beta.1 (September 10, 2019)

### Added

- Add column and row gap options to elements
- Add column and row gap options to blog, top and bottom layout settings
- Add possibility to create accordion menus in mobile position
- Add possibility to create menu headings and dividers (WordPress)
- Add `mod_language` module override (Joomla)

### Changed

- Use the gap option for the one column blog layout instead of defining the gap size in CSS
- Change behavior when an accordion menu item is displayed

### Fixed

- Fix column not expanding if sibling column collapses in rare cases
- Fix `YOOtheme Builder` button in frontend editing on new articles (Joomla)
- Fix Leaflet map marker popup position on load

## 1.21.10 (September 2, 2019)

### Added

- Add `Disable Emojis` setting (WordPress)

## 1.21.9 (August 7, 2019)

### Fixed

- Fix regression with Leaflet markers not showing
- Fix regression with transparent headers set to `sticky on scroll up`

## 1.21.8 (August 6, 2019)

### Fixed

- Fix regression in config caching on Windows and PHP < 7.3

## 1.21.7 (August 2, 2019)

### Fixed

- Fix vertical alignment option for the Joomla Position and WordPress Area element
- Fix alignment in offcanvas and modal center layouts
- Fix Leaflet map style by deferring CSS
- Fix dropbar mode with transparent headers

## 1.21.6 (July 24, 2019)

### Added

- Add `wp_body_open` hook to header.php (WordPress)

### Fixed

- Fix section overlap between main content and builder module or footer
- Fix Gallery/Grid item animations not being applied
- Fix Edge compatibility in builder
- Fix missing `rel` attribute in menu link (WordPress)
- Apply content plugins on builder output only once (Joomla)

## 1.21.5 (July 10, 2019)

### Fixed

- Fix text wrapping if section as a section title and content is vertical aligned
- Fix lightbox requires two clicks to open
- Fix urls being displayed for builder pages (Joomla)
- Fix countdown label color inverse
- Fix drag and drop elements in builder
- Fix lazy loading images not showing in rare cases

## 1.21.4 (June 28, 2019)

### Fixed

- Fix multiple UIkits being loaded in customizer mode
- Fix lazy loading map crashes website

## 1.21.3 (June 27, 2019)

### Fixed

- Fix relative paths in generated CSS
- Fix rare case of browser freeze when switching device preview

## 1.21.2 (June 26, 2019)

### Fixed

- Fix toolbar for module- and widget builder in preview
- Fix relative paths in generated CSS if located in child theme
- Fix animation stutter in Slideshow/Slider elements
- Fix swipe gestures in Switcher (Android)
- Fix article print view (Joomla)
- Fix wrong closing tag in `content-search.php` (WordPress)

## 1.21.1 (June 21, 2019)

### Fixed

- Fix wrong Google Fonts being shown in style customizer
- Fix PHP notice on saving builder

## 1.21.0 (June 18, 2019)

### Added

- Add font family option to title fields in elements
- Add content events to builder pages for plugin compatibility (Joomla)

### Changed

- Don't add theme object to query vars for plugin compatibility (WordPress)

### Fixed

- Fix text alignment 'justify' applied responsive breakpoints
- Fix gallery shortcode rendering images attached to a post (WordPress)
- Fix media manager (Joomla)
- Fix link picker in frontend editing (Joomla)
- Fix warning on builder pages (Joomla)

## 1.21.0-beta.2 (June 17, 2019)

### Fixed

- Fix media manager (Joomla)
- Fix link picker in frontend editing (Joomla)
- Fix warning on builder pages (Joomla)

## 1.21.0-beta.1 (June 14, 2019)

### Added

- Add font family option to title fields in elements
- Add content events to builder pages for plugin compatibility (Joomla)

### Changed

- Don't add theme object to query vars for plugin compatibility (WordPress)

### Fixed

- Fix text alignment 'justify' applied responsive breakpoints
- Fix gallery shortcode rendering images attached to a post (WordPress)

## 1.20.6 (May 28, 2019)

### Fixed

- Fix font loading

## 1.20.5 (May 28, 2019)

### Added

- Add toolbar width option

### Changed

- Replace toolbar padding vertical variable with padding top and bottom

### Fixed

- Fix loading of Google fonts with varying subset support
- Fix Module Class Suffix in J!Module element (Joomla)
- Fix missing status option in HTML and Description List element

## 1.20.4 (May 24, 2019)

### Changed

- Show Less errors in components panel

### Fixed

- Fix Maps/Newsletter elements with caching enabled (Joomla)

## 1.20.3 (May 22, 2019)

### Fixed

- Preserve heading font customizations on update

## 1.20.2 (May 20, 2019)

### Fixed

- Fix builder output with caching enabled (Joomla)

## 1.20.1 (May 20, 2019)

### Fixed

- Fix content plugins on builder pages (Joomla)
- Fix builder output with caching enabled (Joomla)

## 1.20.0 (May 17, 2019)

### Added

- Add width option to header layouts
- Add position options to elements
- Add heading style options to title and meta fields to elements
- Add option to align meta text above the content to elements
- Add hover effects for title and image to Panel and Grid elements
- Add tab style option to Subnav element
- Add navbar frame mode to style customizer
- Add padding option to navbar in style customizer
- Add block alignment breakpoint and fallback option to elements
- Add help videos for links, media manager and Unsplash library
- Add Etsy icon to social icons
- Add help videos for lazy loading and webp images
- Add theme config update scripts

### Changed

- Update CSS heading sizes in styles
- Disable wpautop filter for text-widget in navbar, header and toolbar positions (WordPress)
- Rename page container padding variable to margin in styler
- Render favicon configured in theme settings only (WordPress)
- Prevent stripping of common HTML elements if whole element is linked
- Refactor customizer config

### Removed

- Remove Primary modifier from Heading component in style customizer. Use Medium instead.
- Remove Hero modifier from Heading component in style customizer. Use XLarge instead.

### Fixed

- Fix headings if animation option is set in the builder for Vibe style
- Fix image hover box shadow option if title/image are linked for Panel and Grid element
- Fix link set to target blank in Slider element
- Fix Unsplash tab loosing scroll position after re-opening
- Fix meta alignment in Description List element
- Fix container elements not collapsing, if they contain empty elements only
- Fix frontend editor field (Joomla)
- Fix combination of border and border-radius for thumbnav in styler
- Fix missing `bootstrap.php` in templateDetails.xml (Joomla)
- Fix block alignment setting in elements
- Fix JavaScript errors in customizer
- Fix menu link picker filter dropdowns in Firefox (Joomla)
- Fix position of absolute positioned elements
- Fix widget editing (WordPress)
- Fix page heading being displayed for builder pages (Joomla)
- Fix Toolset plugin compatibility (WordPress)
- Update customizer config
- Fix last child margin for absolute positioned elements

## 1.20.0-beta.7 (May 15, 2019)

### Fixed

- Update customizer config
- Fix last child margin for absolute positioned elements

## 1.20.0-beta.6 (May 13, 2019)

### Added

- Add theme config update scripts

### Changed

- Refactor customizer config

### Fixed

- Fix position of absolute positioned elements
- Fix widget editing (WordPress)
- Fix page heading being displayed for builder pages (Joomla)
- Fix Toolset plugin compatibility (WordPress)

## 1.20.0-beta.5 (May 7, 2019)

### Added

- Add Etsy icon to social icons
- Add help videos for lazy loading and webp images

### Fixed

- Fix JavaScript errors in customizer
- Fix menu link picker filter dropdowns in Firefox (Joomla)

## 1.20.0-beta.4 (May 3, 2019)

### Fixed

- Fix block alignment setting in elements

## 1.20.0-beta.3 (May 2, 2019)

### Fixed

- Fix missing `bootstrap.php` in templateDetails.xml (Joomla)

## 1.20.0-beta.2 (May 2, 2019)

### Added

- Add block alignment breakpoint and fallback option to elements
- Add help videos for links, media manager and Unsplash library

### Fixed

- Fix combination of border and border-radius for thumbnav in styler

## 1.20.0-beta.1 (April 30, 2019)

### Added

- Add width option to header layouts
- Add position options to elements
- Add heading style options to title and meta fields to elements
- Add option to align meta text above the content to elements
- Add hover effects for title and image in Panel and Grid elements
- Add tab style option to Subnav element
- Add navbar frame mode to style customizer
- Add padding option to navbar in style customizer

### Changed

- Update CSS heading sizes in styles
- Disable wpautop filter for text-widget in navbar, header and toolbar positions (WordPress)
- Rename page container padding variable to margin in styler
- Render favicon configured in theme settings only (WordPress)
- Prevent stripping of common HTML elements if whole element is linked

### Removed

- Remove Primary modifier from Heading component in style customizer. Use Medium instead.
- Remove Hero modifier from Heading component in style customizer. Use XLarge instead.

### Fixed

- Fix headings if animation option is set in the builder for Vibe style
- Fix image hover box shadow option if title/image are linked for Panel and Grid element
- Fix link set to target blank in Slider element
- Fix Unsplash tab loosing scroll position after re-opening
- Fix meta alignment in Description List element
- Fix container elements not collapsing, if they contain empty elements only
- Fix frontend editor field (Joomla)

## 1.19.2 (April 5, 2019)

### Changed

- Prevent stripping of `br`, `span`, `strong`, `em`, `p` and `div` if whole element is linked
- Remove margin from the last-child in content fields in elements

### Fixed

- Fix inline svg option being lost after update for Accordion element

## 1.19.1 (April 1, 2019)

### Added

- Add easing option to background images with parallax effect

### Changed

- Allow a negative parallax easing to start off slowly

### Fixed

- Fix video element missing closing tag

## 1.19.0 (March 28, 2019)

### Added

- Add help system
- Add help videos for layout and module panels
- Add page builder support for blog posts
- Add option show the post excerpt in the blog overview (WordPress)
- Add image options for boxed page layout
- Add option to display the header outside of the boxed page layout
- Add option to let the toolbar inherit the transparency from the navbar
- Add grid options for title alignment in Panel, Grid and Switcher elements
- Add option to align meta text below the content to elements
- Add link type options to Panel, Grid and Popover elements
- Add panel padding option to Panel and Grid elements
- Add link options to Overlay, Gallery and Slider elements
- Add primary navbar style

### Changed

- Allow to set top and bottom margin independently for the boxed page layout
- Improve links for search engines and accessibility in Panel, Grid, Popover, Overlay, Gallery and Slider elements
- Change default page container width to 1500px
- Allow navbar to have different top and bottom paddings

### Fixed

- Fix headerbar-bottom color if transparent in `Stacked Center B` layout
- Fix background image size for external images
- Fix image link missing target attribute in List element
- Fix duplicate items in Lightbox
- Fix overlay is shown empty in Overlay, Gallery and Slider element
- Fix scroll position when searching the Unsplash library
- Fix rare case of broken header in Chrome

## 1.19.0-beta.3 (March 27, 2019)

### Added

- Add page builder support for blog posts
- Add option show the post excerpt in the blog overview (WordPress)

### Fixed

- Fix rare case of broken header in Chrome

## 1.19.0-beta.2 (March 25, 2019)

### Added

- Add primary navbar style

### Changed

- Change default page container width to 1500px
- Allow navbar to have different top and bottom paddings

### Fixed

- Fix background image size for external images
- Fix image link missing target attribute in List element
- Fix duplicate items in Lightbox
- Fix overlay is shown empty in Overlay, Gallery and Slider element
- Fix scroll position when searching the Unsplash library

## 1.19.0-beta.1 (March 19, 2019)

### Added

- Add help system
- Add help videos for layout and module panels
- Add image options for boxed page layout
- Add option to display the header outside of the boxed page layout
- Add option to let the toolbar inherit the transparency from the navbar
- Add grid options for title alignment in Panel, Grid and Switcher elements
- Add option to align meta text below the content to elements
- Add link type options to Panel, Grid and Popover elements
- Add panel padding option to Panel and Grid elements
- Add link options to Overlay, Gallery and Slider elements

### Changed

- Allow to set top and bottom margin independently for the boxed page layout
- Improve links for search engines and accessibility in Panel, Grid, Popover, Overlay, Gallery and Slider elements

### Fixed

- Fix headerbar-bottom color if transparent in `Stacked Center B` layout

## 1.18.16 (March 19, 2019)

### Fixed

- Fix missing map to add marker in Map element
- Fix preview being displayed in previous state, when entering style component
- Allow `Filter All Label` translation in Grid elements

## 1.18.15 (March 07, 2019)

### Fixed

- Allow WebP image format in media manager
- Fix `Add From Media` items missing images in Popover element
- Fix set `target` and `rel` attribute in menu item anchor (Joomla)
- Fix post gallery missing image caption (WordPress)
- Fix SVG support in IE11/Edge

## 1.18.14 (February 28, 2019)

### Fixed

- Fix IE11 compatibility

## 1.18.13 (February 28, 2019)

### Fixed

- Fix missing icon files

## 1.18.12 (February 27, 2019)

### Fixed

- Fix `custom js` setting with multiple `<script>` tags

## 1.18.11 (February 27, 2019)

### Added

- Add more margin options for fields to elements
- Add color option for inlined SVGs to elements

### Changed

- Copy theme settings to child theme on first activation (WordPress)

### Fixed

- Fix button text style
- Fix image border option if aligned between in Panel and Grid elements
- Fix centering the map element with a hidden marker
- Fix rare occasion where Grid element content was not being displayed
- Fix video/image setting not being displayed in Section element
- Fix PHP < 5.6 compatibility (WordPress)
- Fix editing widgets, after previously saving them (WordPress)
- Fix preview reloading when empty anchors are clicked (WordPress)
- Fix saving anchor tags with `target` attribute in Builder (WordPress)
- Fix duplicate title in module positions (Joomla)
- Fix `My Elements` showing items in empty element library

## 1.18.10 (February 13, 2019)

### Changed

- Allow image border option for cards in Panel and Grid elements

### Fixed

- Fix class loading error 'YOOtheme\Theme\Widgets' not found (WordPress)

## 1.18.9 (February 13, 2019)

### Added

- Add stroke animation option for inline SVG to Grid, List, Switcher and Table elements

### Fixed

- Fix lazy image loading for Switcher and Popover element
- Fix box decoration preventing links from being clickable in some styles
- Fix Gutenberg editor enabled on WooCommerce product posts (WordPress)
- Fix checkbox checkmark in Finder

## 1.18.8 (February 8, 2019)

### Added

- Add stroke animation option for inline SVG

### Changed

- Better placeholder values for elements

### Fixed

- Fix missing status option in some elements
- Fix set x and y properties simultaneously in parallax animation
- Fix image upload progress never finish (Joomla)

## 1.18.7 (February 6, 2019)

### Fixed

- Fix color picker

## 1.18.6 (February 5, 2019)

### Fixed

- Fix grid settings in J!Position element (Joomla)
- Fix clicking links in cookie banner also accepting cookies
- Fix display options in blog and post layout settings (WordPress)

## 1.18.5 (February 5, 2019)

### Fixed

- Fix endless update loop in preview

## 1.18.4 (February 4, 2019)

### Fixed

- Fix empty `layout` in JSON string in layouts
- Fix custom elements not being loaded (WordPress)
- Fix menu style setting in J!Module element (Joomla)
- Fix "Preview all UI elements in style customizer

## 1.18.3 (February 1, 2019)

### Fixed

- Fix error when loading `js/custom.js`

## 1.18.2 (February 1, 2019)

### Fixed

- Fix PHP 7.3 compatibility in regex syntax
- Fix WooCommerce module loading (WordPress)

## 1.18.1 (January 31, 2019)

### Fixed

- Fix shortcodes not being applied to builder content (WordPress)
- Fix footer builder rendering in child theme override
- Fix PHP 5.4 syntax error in Newsletter element
- Fix `Clear Cache` button seemingly not clearing the cache

## 1.18.0 (January 31, 2019)

### Added

- Add status option to disable sections, rows and elements
- Allow for js/custom.js in child theme

### Changed

- Implement render tree concept for the page builder
- Improve saved page content
- Refactor element file structure

### Fixed

- Fix display of categories in breadcrumbs

## 1.17.7 (January 15, 2019)

### Fixed

- Fix offcanvas overlay transition
- Fix active state in Switcher element
- Fix background images on displays with higher devicePixelRatio in Img component
- Fix `YOOtheme Builder` button SEF URL plugin compatibility (Joomla)
- Fix `limit content length` blog setting

## 1.17.6 (January 14, 2019)

### Added

- Add `Horizontal Center Logo` layout to header layouts

### Fixed

- Fix navbar menu rendering in header position
- Fix warning if widget is assigned to a language in WP Widget element (WordPress)
- Fix modal video fullscreen option in image element

## 1.17.5 (January 04, 2019)

### Added

- Add Breadcrumbs Widget (WordPress)
- Add option to require mandatory consent before loading cookies

### Fixed

- Fix Gutenberg editor integration (WordPress)
- Fix alignment of justified dropdowns in navbar with dropbar

## 1.17.4 (December 21, 2018)

### Fixed

- Fix cookie notification appear below maps
- Fix invisible images in large galleries
- Fix `YOOtheme Builder` button multilanguage support (Joomla)
- Fix cancelling after prior save in customizer (Joomla)
- Fix PostgreSQL database compatibility (Joomla)
- Fix empty image container when no image selected in post (Wordpress)

## 1.17.3 (December 14, 2018)

### Fixed

- Fix customizer not loading in IE and Edge browser

## 1.17.2 (December 14, 2018)

### Fixed

- Fix API Key handling
- Fix missing toolbar layout (Wordpress)

## 1.17.1 (December 13, 2018)

### Added

- Add gradient option to media settings in Section and Row elements
- Add color option for meta field to elements
- Add box decoration inverse option to builder elements
- Add inverse style for box decorations to styles

### Changed

- Optimize box decorations in styles

### Fixed

- Fix create new table element
- Fix display search in header or navbar position (Wordpress)

## 1.17.0 (December 05, 2018)

### Added

- Add local style library
- Add footer layouts to library
- Add Cookie Banner panel to settings
- Add delete buttons to menu item and module modal (Joomla)
- Add option to extend the max width to left or right in sections and rows
- Add option to remove left or right section/row padding to media elements
- Add box decoration option to builder elements
- Add inline SVG option to Accordion, Popover, Slideshow, Switcher and Table element
- Add option to shrink thumbnav into a single line in Slideshow element
- Add option to insert layout from the library at the top of the current layout

### Changed

- Memorize the option how a layout is inserted through the library

### Fixed

- Fix Unsplash library needing refresh on apikey change
- Fix Height Viewport calculation (IE11)
- Fix Link Toolbar not hiding in Visual Editor (WordPress)
- Fix using data URIs in custom element CSS
- Fix using CSS escape characters in selectors in custom element CSS
- Fix visibility setting for toolbar + navbar widgets/modules
- Fix render widget container when not assigned to current language (WordPress)
- Fix article editor 'save' no longer corrupts builder layouts
- Fix slideshow 'pause on hover' setting
- Fix `YOOtheme Builder` button does not open into `builder` section (WordPress)
- Fix issue with Page Builder getting out of sync with preview
- Fix superfluous page change notifications under certain conditions

## 1.16.7 (November 24, 2018)

### Fixed

- Fix redirect after closing customizer (Joomla)
- Fix IE11 compatibility
- Fix Advanced Module Manager compatibility (Joomla)
- Fix commentform translation (WordPress)

## 1.16.6 (November 23, 2018)

### Fixed

- Fix markup in element templates

## 1.16.5 (November 23, 2018)

### Changed

- Refactor element templates

### Fixed

- Fix module header tag setting not reflected in J!Module element (Joomla)
- Fix superfluous page change notifications when post has no revision (WordPress)
- Fix IE11 compatibility
- Fix transparent navbar header

## 1.16.4 (November 20, 2018)

### Fixed

- Fix size of background images on retina displays
- Fix image urls in Map element markers
- Fix autoplay option in Video element
- Fix superfluous page change notifications under certain conditions
- Fix menu item class on separator items
- Fix 'Enable click mode on text separators' mode (WordPress)

## 1.16.3 (November 16, 2018)

### Changed

- Improved System Check

### Fixed

- Fix duplicating actions on clicking buttons in page builder
- Fix regression with modals not closing
- Fix Offcanvas changing viewport upon opening
- Fix notice on WooCommerce pages (WordPress)

## 1.16.2 (November 13, 2018)

### Fixed

- Fix "New layout" button in footer, module and widget builders
- Fix duplicating images in item list for builder elements with content items
- Fix superfluous page change notifications under certain conditions
- Fix sticky navbar not recalculating
- Fix media picker in link picker field
- Fix title in builder widget (WordPress)
- Fix page builder closes unexpected on touch devices
- Fix change footer-builder title

## 1.16.1 (November 09, 2018)

### Added

- Add warning for uninstalled/disabled `installer` plugin in API key section

### Fixed

- Fix "YOOtheme Builder" button in article edit view (Joomla)
- Fix regression with modals not closing
- Fix audio element disappear in Chrome

## 1.16.0 (November 08, 2018)

### Added

- Add buttons to hide/show customizer (Joomla)
- Add button to drag the width of the customizer (Joomla)
- Add notification before saving if layout has been updated by another user
- Add confirmation before replacing layout through library
- Add sticky navbar options to mobile header
- Add multiple items from media manager to builder elements
- Add image to item list for builder elements with content items
- Add default icon and icon color option to List element
- Add vertical alignment option to List element
- Add name, id, class and CSS fields to HTML element
- Add max width options to Grid and Gallery element
- Add lazy loading to Maps element
- Add text color emphasis option for title and icon fields
- Add text shadow picker in style customizer
- Add font-style option to blockquote footer
- Add button to rename files to media manager (Joomla)
- Add module id to select in J!Module element (Joomla)
- Add module id to edit module modal (Joomla)
- Add System Check panel to settings
- Add API Key panel to settings (Joomla)
- Add print, reddit, microphone, file-text, file-pdf and more to icon field
- Add support for the Gutenberg editor (WordPress)

### Changed

- Adjust sidebar in builder panels to the same width
- Make layout save button sticky and available in builder panels
- Move 3rd party options to External Services panel in settings
- Move CMS specific options from System panel to Advanced panel in settings
- Move button to start a new layout to initial builder panel
- Update top and bottom settings according to latest builder section settings

### Fixed

- Fix text filter issue for any filter group and type (Joomla)
- Fix background image srcset resizing for top and bottom position
- Fix extra white space below masonry grid
- Fix 'inset' option in boxshadow picker
- Fix vertical alignment in search style "Modal" for IE11

## 1.15.7 (October 16, 2018)

### Fixed

- Fix PHP notice if columns not defined in blog (WordPress)
- Fix menu images in `Stacked Center Split` navbar layout

## 1.15.6 (October 15, 2018)

### Added

- Add width option and responsiveness to Map element
- Add height setting to rows
- Add bottom option for vertical alignment of column

### Changed

- Match height option now matches not just single panels in row settings
- Moved vertical alignment option from row to column settings
- Improve background image sizes

### Fixed

- Fix match height of panels if overlay color is used for column image
- Fix vertical alignment if tile or image is used for column
- Fix padding option not being available if column image is used
- Fix z-index issue if using menu animation with dropdown slide in mobile header
- Fix storing layouts containing elements without content items
- Fix the sticky navbar not being sticky on small viewports in rare cases
- Fix menu link picker filter dropdowns in Firefox (Joomla)

## 1.15.5 (October 08, 2018)

### Fixed

- Fix setting empty default values in builder causes refresh and dirty state
- Fix "Theme" button on edit widgets (WordPress)
- Fix images in customizer mode still being saved (WordPress)
- Fix readmore link redirect after login (Joomla)
- Fix could not save module settings after error occured (Joomla)
- Fix replacing images in builder layouts
- Fix initially wrong position of background image with parallax

## 1.15.4 (October 02, 2018)

### Added

- Add divider vertical style

### Changed

- Compile WooCommerce style only when plugin is active (WordPress)

### Fixed

- Fix encoded thumbnail URI in media manager list (Joomla)
- Fix builder toolbars in footer
- Prevent refresh after clicking builder toolbar (WordPress)
- Fix resetting of gradient color field in style customizer

## 1.15.3 (September 28, 2018)

### Fixed

- Fix style inspector missing in "Preview all UI elements"
- Fix builder element highlighting in preview
- Fix opening changelog multiple times
- Fix social icon element loosing values upon edit
- Fix missing preview images in PHP < 7

## 1.15.2 (September 27, 2018)

### Fixed

- Fix builder closing its panels unexpected
- Fix link picker only selecting images (Joomla)

## 1.15.1 (September 26, 2018)

### Fixed

- Fix empty style customizer
- Fix font handling in style customizer
- Fix builder layout not refreshing when browsing to another page in preview
- Fix not being able to create new builder layout (WordPress)
- Fix builder if opened through module edit view (Joomla)
- Fix article and menu buttons in visual editor (Joomla)
- Fix newsletter API settings
- Fix editing Builder Widgets (WordPress)
- Fix changelog in Safari (WordPress)
- Fix Lilian Less typo

## 1.15.0 (September 25, 2018)

### Changed

- Upgrade to Vue 2.5
- Refactor JavaScript application
- Add new color picker
- Improve image creation in page builder

## 1.14.8 (September 14, 2018)

### Fixed

- Fix regression in Newsletter element
- Fix regression with resizing images loaded from Layout Library
- Fix match height of panels if column image with overlay color is used
- Fix show image option not working with icon field in Grid and List element

## 1.14.7 (September 06, 2018)

### Added

- Add form style option to newsletter element

### Fixed

- Fix LESS syntax error in white-blue Flow style

## 1.14.6 (September 05, 2018)

### Added

- Add Flow style
- Add pill to border option in elements
- Allow `.m4v` file selection in media picker

### Changed

- Allow logo to expand navbar height
- Reduce animation delay to 200ms

### Fixed

- Fix Animation setting for Grid/Gallery elements
- Fix Lightbox caption in Grid element
- Fix Blog/Post image missing alt attribute
- Fix Header `Stacked Center Split` with menu modules and caching (Joomla)
- Fix images load wrong srcset in Edge browser

## 1.14.5 (August 21, 2018)

### Added

- Add option to inline SVGs in Image, Panel, Grid and List element

### Changed

- Update administration language files

### Fixed

- Fix filter if tags are numerical values
- Fix LESS highlighting in custom CSS/LESS field

## 1.14.4 (August 09, 2018)

### Fixed

- Fix video file selection in media picker
- Fix JCE editor (Joomla)
- Fix smart search advanced options not visible (Joomla)

## 1.14.3 (August 08, 2018)

### Added

- Add padding option to blog and post settings
- Add width option `None` to post settings
- Apply blog settings in tag view (Joomla)

### Fixed

- Fix TinyMCE losing focus in Edge
- Fix overriding `$post` (WordPress)

## 1.14.2 (August 03, 2018)

### Fixed

- Fix blog center title and meta setting (WordPress)
- Fix IE 11 regression in customizer
- Fix PHP < 5.6 compatibility with Font saving
- Fix handling error on Font saving

## 1.14.1 (August 02, 2018)

### Fixed

- Fix notice on blog archive (WordPress)

## 1.14.0 (August 02, 2018)

### Added

- Add margin options to blog and post settings
- Add width options to blog and post settings
- Add title style option to blog settings
- Add breakpoint option to blog settings
- Add masonry option to blog settings
- Add parallax option to blog settings
- Add option to limit the content length
- Add option to hide readmore button and comments count (WordPress)
- Add warning if Text Filters are active (Joomla)
- Add support for smart search (Joomla)

### Changed

- Show drop cap in post view only
- Center blog image if smaller than the container

### Removed

- Remove blog column order (WordPress)
- Remove divider option in blog settings
- Remove grid if just one blog column

### Fixed

- Fix layout blog settings not applied to featured blog (Joomla)
- Remove empty `div` if there is no blog intro text
- Fix link style being disabled in Icon element
- Fix jumping in filtered Grid during animation
- Fix phone number or email adress opening a new tab in social icons
- Handle error on save (Joomla)

## 1.13.2 (July 13, 2018)

### Added

- Add option to shrink thumbnav into a single line in Switcher element
- Add color option button text arrow icon in style customizer
- Add border option for table divider header in style customizer

### Fixed

- Fix modal not covering viewport in Button element

## 1.13.1 (July 10, 2018)

### Fixed

- Fix margin if thumbnav wraps into multiple lines in Switcher element
- Fix Gallery element with `Min Height` applied
- Fix Layout library modal jumping in size indefinitely
- Close current Builder Section upon saving external images only
- Optimize unsplash preview image sizes
- Fix double encoded iframe src

## 1.13.0 (July 05, 2018)

### Added

- Add Unsplash image library
- Store and load Google Fonts locally

### Fixed

- Fix route generating (Joomla)
- Exclude GIF images from resizing

## 1.12.6 (June 20, 2018)

### Fixed

- Fix Dropbar in IE 11
- Fix PNG image transparencies

## 1.12.5 (June 18, 2018)

### Fixed

- Fix images wrong positioned in Gallery and Overlay element
- Raise PHP memory_limit on image operations
- Fix module rendering in `navbar` position in PHP 5 (Joomla)

## 1.12.4 (June 11, 2018)

### Fixed

- Apply translations to element names
- Fix clicking on filter items in Customizer (WordPress)
- Fix Masonry Grid not having correct height
- Fix module rendering in `navbar` position (Joomla)
- Fix iframe jumping introduced with Chrome 66

## 1.12.3 (June 06, 2018)

### Fixed

- Fix PHP < 5.5 compatibility with Image creation
- Fix cause for missing images
- Fix error for none existing image in Gallery and Overlay element
- Fix filter if tags are numerical values

## 1.12.2 (June 05, 2018)

### Fixed

- Fix webp config setting
- Fix internal link handling (Joomla)
- Fix missing menu module params in `navbar` position (Joomla)
- Apply Link Class to anchors instead of list items in Navs (Joomla)

## 1.12.1 (June 05, 2018)

### Fixed

- Fix PHP < 7 compatibility

## 1.12.0 (June 04, 2018)

### Added

- Add filter options to Grid and Gallery element
- Add `masonry` option to Grid and Gallery element
- Add general lazy loading option for images
- Add lazy loading option to Video element
- Add option which play/pause the Video element as it enters/leaves the viewport
- Add smaller font-sizes on mobile for h1, h2, primary and hero heading and article title

### Changed

- Use image elements instead of background images in Overlay and Gallery elements

### Fixed

- Resize poster image to video dimensions in Video element
- Disable video options for `youtube-nocookie.com` domain in Video element
- Fix gallery shortcode rendering (WordPress)
- Header Layout `Stacked Center Split` usable with menu modules

## 1.11.9 (May 04, 2018)

### Added

- Add Mailchimp double opt-in setting to Newsletter element

### Fixed

- Fix Videos not auto play/pause in modals
- Fix Gallery images missing alt attribute in Lightbox
- Fix multiple Popover elements overlapping each other
- Fix sh404sef error handling compatibility

## 1.11.8 (April 11, 2018)

### Fixed

- Fix Offcanvas/Modal not opening more than once
- Fix regression with fullscreen Slideshow element

## 1.11.7 (April 05, 2018)

### Added

- Add large size option to Table element
- Add full width option for buttons to Table element
- Add heading hero option to panel and Grid element

### Fixed

- Fix boxed layout background image uses relative URL (WordPress)
- Fix missing menu icon class (Joomla)
- Fix Tab key navigation in Customizer
- Fix Customizer translation based on user profile setting (WordPress)
- Fix Google Font Montserrat font-weight (WordPress)

## 1.11.6 (March 15, 2018)

### Fixed

- Fix loop youtube videos
- Fix player ids in Vimeo videos
- Fix prefix custom CSS for elements
- Fix grouped input field loosing focus upon first input
- Child theme can override offline.php (Joomla)

### Removed

- Remove redundant WooCommerce setting for WooCommerce 3.3 (WordPress)

## 1.11.5 (March 06, 2018)

### Fixed

- Fix Pinewood-Lake navbar letter-spacing

## 1.11.4 (March 05, 2018)

### Added

- Add options to remove margin to row settings in builder
- Add border options to navbar in style customizer

### Fixed

- Fix SH404SEF plugin compatibility (Joomla)
- Fix EasySocial plugin compatibility (Joomla)
- Fix overlapping sections if section has a background image
- Fix missing menu item title attribute (WordPress)
- Fix padding option if an image is selected for builder columns
- Fix dropbar opens on bottom positioned drops only
- Fix section overlap textures in fjord style for Firefox and Safari

## 1.11.3 (February 12, 2018)

### Fixed

- Fix YouTube short urls in Lightbox
- Fix Google Font Montserrat font-weight

## 1.11.2 (February 02, 2018)

### Changed

- Rename Vision style dark-green to black-green

## 1.11.1 (February 01, 2018)

### Added

- Add Vision style

## 1.11.0 (January 31, 2018)

### Added

- Add Slider element to builder
- Add slidenav position outside to Slideshow element
- Add color option for navigations to Slideshow element
- Add option for link hover effect to Heading element
- Add support for privacy enhanced mode in YouTube urls

### Changed

- Update title style in Accordion element
- Improve image srcset resizing
- Update list of available Google Fonts
- YouTube/Vimeo options are now settable through their URL in Video element

### Fixed

- Make Accordion element accessible through keyboard
- Make overlays in Overlay and Gallery element accessible through keyboard
- Add debug backtrace to error.php (Joomla)
- Child theme can override error.php (Joomla)
- Allow uploading PDF files in media manager (Joomla)
- Fix Editors loosing focus upon typing first letter

## 1.10.8 (December 18, 2017)

### Fixed

- Fix select image from media-library (WordPress)

## 1.10.7 (December 14, 2017)

### Added

- Highlight selected image in media-library (WordPress)
- Add page builder link to pages list (WordPress)

### Fixed

- Fix preview refreshing when changing style (WordPress)
- Fix link picker url path (WordPress)
- Fix module rendering in format raw mode (Joomla)
- Fix new routing method compatibility in error.php (Joomla)

## 1.10.6 (December 05, 2017)

### Fixed

- Fix pagination on Windows platforms (Joomla)
- Add missing error.php to templateDetails.xml (Joomla)

## 1.10.5 (December 01, 2017)

### Added

- Add reset filter button to style and layout library
- Add border mode to alert in style customizer
- Add font options to search in style customizer
- Add error page (Joomla)

### Fixed

- Create separate `theme.css` for multisites (WordPress)
- Create separate `theme.css` for template styles (Joomla)
- Include missing preventAutofocus.js file in dist
- Fixed validation messages not shown in frontend editing (Joomla)

## 1.10.4 (November 16, 2017)

### Added

- Make html/pagination.php overwritable in child theme (Joomla)

### Fixed

- Fix error in JSON views (Joomla)
- Prevent `input` elements with `autofocus` attribute from gaining focus in customizer preview

## 1.10.3 (November 13, 2017)

### Fixed

- Fix media manager in frontend edit (Joomla)
- Fix IE 11 regression

## 1.10.2 (November 09, 2017)

### Changed

- Load jQuery automatically if used in `theme.js` in child themes (WordPress)

### Fixed

- Fix Accordion elements not opening
- Fix failed loading Icomoon fonts (Joomla)
- Fix Slideshow YouTube videos play inline on mobile

## 1.10.1 (November 08, 2017)

### Changed

- Load jQuery automatically if used in `theme.js` in child themes (Joomla)

### Fixed

- Fix CSS auto-compiling after theme update
- Fix multi-line selectors in custom CSS field in the builder
- Fix rare fatal error in child themes with 3rd party modules
- Prevent saving the style customizer if a Less error occurs

## 1.10.0 (November 07, 2017)

### Added

- Add Slideshow element to builder
- Add controls, muted and playsinline options to Video element
- Add advanced coloring and parallax options to builder column
- Add max width breakpoint option to elements
- Add reset style button to style customizer components overview
- Add UI preview for the theme component to style customizer
- Add thumbnav component to style customizer
- Add large margin option to Overlay and Gallery element

### Changed

- Rework UI preview in style customizer
- Rework save and cancel handling in style customizer
- jQuery is no longer be loaded by default, enable corresponding setting to load it
- Allow to select a style and a video for sections at the same time
- Switcher element is now using the thumbnav style for thumbnail navigation
- Update dotnav and slidenav styles in styles

### Removed

- Remove fallback image and use playsinline attribute instead for section videos

### Fixed

- Fix background image breaking style textures for builder column
- Fix visual editor default settings (WordPress)
- Fix render widgets in custom positions (WordPress)
- Fix breaking `Stacked Center A` header layout
- Fix invalid connect_ids for Switcher, Image and Button element
- Fix animated navbar line in Safari
- Fix markup in Joomla Module Element
- Fix Gallery and Grid Elements support YouTube and Vimeo URLs
- Fix Lightbox with anchor elements in description

## 1.9.9 (September 29, 2017)

### Added

- Add option to center logo for modal and offcanvas header layouts
- Add z index option to parallax settings
- Add UI preview for the inverse component to style customizer

### Changed

- Optimize CSS and markup for boxed page option
- Move border mode for body element to theme page class
- Rework UI preview pages of components for style customizer

### Fixed

- Fix overlay max width option in Overlay and Gallery element
- Fix search icon style in navbar for modal mode
- Fix TinyMCE notification z-index
- Fix email cloaking cleanup (Joomla)
- Fix comments pagination links (WordPress)
- Fix form blank focus style

## 1.9.8 (September 25, 2017)

### Added

- Enable page builder in substyles (Joomla)

### Fixed

- Fix MailChimp provider shows only up to 10 lists in Newsletter element
- Fix Module element closing title tag (Joomla)

## 1.9.7 (September 19, 2017)

### Fixed

- Fix RTL theme CSS include (WordPress)
- Fix link picker with multiple menus (Joomla)
- Fix module position renderer (Joomla)

## 1.9.6 (September 8, 2017)

### Fixed

- Fix image srcset sizing

## 1.9.5 (September 7, 2017)

### Fixed

- Fix image preview in layouts

### Changed

- Optimize Less source file loading

## 1.9.4 (August 30, 2017)

### Fixed

- Fix submenus in nav rendering
- Fix grid and gallery animation settings
- Fix animated navbar line in Firefox
- Fix show UI components option for boxed page layouts with vertical padding
- Fix prevent duplicate meta charset (Joomla)
- Fix link picker (WordPress)

## 1.9.3 (August 18, 2017)

### Fixed

- Fix navbar animations in Firefox
- Fix Module Class Suffix in module overrides (Joomla)
- Fix boxed container width and background

## 1.9.2 (August 16, 2017)

### Fixed

- Fix centered toolbar-right position if toolbar-left is empty
- Fix unsorted inverse variables in style customizer
- Fix system overrides in child-theme (Joomla)
- Fix layout select field

## 1.9.1 (August 03, 2017)

### Fixed

- Fix editing builder module
- Fix 'Enable click mode on text separators' mode

## 1.9.0 (August 01, 2017)

### Added

- Add lightbox gallery to Grid and Gallery element
- Add lightbox options to image and button element
- Add section title options
- Add vertical alignment option if section height is larger than its content
- Add mixed image orientation mode to Gallery and Grid element
- Add min-height option to Overlay and Gallery element
- Add support for hover image only to Overlay and Gallery element
- Add option to center the toolbar
- Add option to pick files to link fields
- Child theme can overwrite more template files, e.g. index.php and offline.php
- Child theme loads custom elements from builder/ directory
- Child theme loads custom module from config.php

### Changed

- Check for script tags in custom script code
- Refactored tabs and settings UI for sections
- Add link picker to redirect field in Newsletter element
- Improve dropbar style in some themes

### Fixed

- Fix HTML element option in Divider element
- Fix Id option in Switcher element
- Fix sticky navbar behaviour
- Fix dropdown position if navbar has responsive height

## 1.8.5 (July 26, 2017)

### Fixed

- Fix content style setting in accordion
- Fix opening anchor links from the Offcanvas menu
- Fix rare case of "Invalid CSRF token" upon saving (WordPress)

## 1.8.4 (July 19, 2017)

### Fixed

- Fix email cloaking cleanup (Joomla)
- Fix title attributes on menu anchors (Joomla)

## 1.8.3 (July 12, 2017)

### Fixed

- Fix email cloaking issue (Joomla)

### Changed

- Update administration language files

## 1.8.2 (July 10, 2017)

### Fixed

- Fix library in Builder Module (Joomla)
- Fix compatibility with yoast plugin (WordPress)

## 1.8.1 (July 05, 2017)

### Fixed

- Fix Google Fonts issue
- Disable general field instead of hide
- Fix highlight search result (Joomla)

## 1.8.0 (July 04, 2017)

### Added

- Add style library
- Add 45 color variations to style library
- Add link picker
- Add group field type
- Add divider attribute for fields

### Changed

- Refactored tabs and settings UI for elements
- Layout library remembers filters when closed
- Use range picker instead of text fields in Map element
- Update administration language files
- Set gestureHandling to cooperative by default for google maps
- Activated double opt-in for MailChimp in Newsletter element

### Fixed

- Fix link/title bullet combination for Panel and Grid element
- Fix template settings in module front-end editing view
- Fix nav hover style in menu panel (Joomla)
- Offcanvas in overlay mode will close and keep scroll position if anchor link was clicked

## 1.7.7 (June 26, 2017)

### Fixed

- Fix error with saving Pro Layouts

## 1.7.6 (June 23, 2017)

### Fixed

- Fix notice on article edit screen (Joomla)
- Fix error in style customizer (WordPress)


## 1.7.5 (June 21, 2017)

### Fixed

- Fix article TOC display (Joomla)
- Fix article multiple categories styling (WordPress)
- Allow for script tags in builder data (WordPress)
- Fix panel widths in customizer (WordPress)

## 1.7.4 (June 14, 2017)

### Fixed

- Fix issue with custom fields saving (Joomla)
- Fix transparent navbar with builder module on top position

## 1.7.3 (June 08, 2017)

### Changed

- Use range picker instead of text fields for Popover element
- Media Picker remembers last used view (thumbnail / list) upon opening (Joomla)

### Fixed

- Fix MailChimp name fields in Newsletter element
- Fix frontend editing
- Fix builder module/widget warning messages
- Fix Joomla Position/WordPress Area Elements names searchable

## 1.7.2 (June 07, 2017)

### Added

- Add J! Position builder element
- Add WP Area builder element
- Add dedicated builder module positions and widget areas

### Changed

- Sort less export by variable names

## 1.7.1 (June 02, 2017)

### Added

- Add 500px icon to social icons

### Changed

- Put custom JavaScript code in isolated script tag

### Fixed

- Fix issue with 3rd party extensions (Joomla)

## 1.7.0 (June 01, 2017)

### Added

- Add Juno style
- Add builder module/widget
- Add newsletter element to builder
- Add popover element to builder
- Add parallax options to builder elements
- Add image parallax option to builder section
- Add parallax mode to grid and gallery element
- Add width and height option for logos
- Add marker component to style customizer
- Add form range component to style customizer
- Add xlarge padding option to builder column
- Add support menu header item (WordPress)
- Add `div` to HTML element option in headline element
- Add link text option to builder elements and style customizer
- Add border mode for body to base
- Add link field to headline element
- Add max width option to more builder elements

### Changed

- 'uk-*' attributes are preserved in visual editor
- Collapse layout if Module/Widget elements have no output
- Media Picker remembers last browsed folder upon opening (Joomla)
- Empty builder by deleting its last section

### Fixed

- Fix width and height option for SVG image on sections and tiles
- Fix frontend editing and module class suffix for Joomla modules
- Fix column option for large screens in Grid and Gallery element
- Fix display options if navigation is bottom aligned for switcher element
- Fix prevent frontend editing when no user is logged in (Joomla)
- Fix library media download (Joomla)
- Allow '0' as content in builder elements
- Do not render filtered widgets in WP Widget element (WordPress)
- Link to page builder from article edit view contains correct Itemid now (Joomla)

## 1.6.5 (May 09, 2017)

### Fixed

- Fix bottom aligned thumbnails for switcher element
- Fix navbar behaviour for none transparent sections
- Fix emptying layouts in builder behaviour
- Fix navbar behaviour (iOS < 9.3)

## 1.6.4 (May 04, 2017)

### Fixed

- Fix builder toolbar being shown without open builder
- Fix editor for users with limited access (WordPress)
- Fix Less error messages on custom Less field
- Fix drag and drop in builder on devices with both mouse and touch
- Fix syntax highlighting in custom JavaScript field

## 1.6.3 (May 02, 2017)

### Added

- Add Vibe style

### Fixed

- Prevent nested &lt;p&gt; tags in builder page

## 1.6.2 (April 28, 2017)

### Added

- Add fallback image for touch devices for video sections

### Changed

- Disable visual editor when no visual system editor enabled

### Fixed

- Fix UIkit/Master theme styles with custom fonts
- Countdown element supports more than two digits
- Fix header mobile layout offcanvas overlay mode
- Fix 'Link' label in style customizer

## 1.6.1 (April 27, 2017)

### Changed

- Visual editor use line breaks instead of paragraphs for heading element

### Fix

- Fix incompatibility with PHP versions < 5.4.32, 5.5.16

## 1.6.0 (April 26, 2017)

### Added

- Add system WYSIWYG editor
- Add table element to builder
- Add countdown element to builder
- Add option to anonymize IPs for Google Analytics
- Add box-shadow bottom option to builder elements
- Add shadow options to video element
- Add font-style option to style components
- Add border gradient support to base, button and tab
- Add gradient support to navbar container

### Changed

- Update UIkit to 3.0.0 beta22
- Update table component according to UIkit
- Start playing animated Gifs when entering the viewport

### Fix

- Fix list striped component
- Fix select box color if bg is transparent in IE11 and Edge

## 1.5.7 (April 21, 2017)

### Changed

- Renamed module template parameter (Joomla)

### Fixed

- Fix arguments in widget element (WordPress)
- Fix menu rendering in widget element (WordPress)
- Fix Navbar in RTL mode

## 1.5.6 (April 19, 2017)

### Fixed

- Fix customizer session handling (Joomla)

## 1.5.5 (April 19, 2017)

### Fixed

- Fix article view ACL (Joomla)

## 1.5.4 (April 18, 2017)

### Fixed

- Fix icons
- Fix article view ACL (Joomla)

## 1.5.3 (April 18, 2017)

### Changed

- Updated WooCommerce style (WordPress)

### Fixed

- Fix Navbar Dropbar

## 1.5.2 (April 13, 2017)

### Changed

- Improve Builder sorting performance
- Accordion menu parent items (WordPress)

### Fixed

- Fix openstreetmap not using https
- Fix Builder memory leaks
- Fix WooCommerce 3.x product gallery

## 1.5.1 (April 06, 2017)

### Fixed

- Fix text alignment for Button, Social and Subnav elements
- Fix mobile dropdown menu
- Fix duplicate module/widget ids
- Fix expand mode on 'main' container

## 1.5.0 (April 04, 2017)

### Added

- Add Copper Hill style
- Add custom CSS field for builder elements
- Add style and alignment options for offcanvas and modal header layouts
- Add style and alignment options for mobile layouts
- Add more fields and options to description-list element
- Add google maps url support in social links
- Add tripadvisor and yelp to icons
- Add autocomplete to code fields
- Add gradient support to card hover
- Add options to remove left logo padding in header
- Add typo options to logo, table and description-list in style customizer
- Add padding options vertical tabs in style customizer
- Add transitions to nav items

### Changed

- Improve Google font loading
- Improve offcanvas and modal header layouts
- Navs with parent links are no longer rendered as Accordion
- Wrap page in offcanvas content `div`
- Make navbar toggle text look like navbar nav items
- Updated administration language files

### Fixed

- Fix offcanvas scrolling on touch devices

## 1.4.3 (March 17, 2017)

### Fixed

- Fix missing RTL stylesheet

## 1.4.2 (March 17, 2017)

### Fixed

- Fix background video height in sections
- Fix Javascript error when using multiple Map elements in builder
- Fix wrong locale no-NO in language files

## 1.4.1 (March 16, 2017)

### Fixed

- Fix missing builder elements
- Fix "Pro Layouts" tab in layout library

## 1.4.0 (March 16, 2017)

### Added

- Add overlay element to builder
- Add gallery element to builder
- Add switcher element to builder
- Add more fields and options to accordion element
- Add row column settings in builder
- Add tile component to style customizer
- Add 25 site and 11 admin localizations
- Add support for RTL languages

### Changed

- Update outdated CSS when opening customizer

### Fixed

- Fix menu style setting in widget element (WordPress)
- Fix "Preview all UI elements" disable on style change
- Fix rendering of additional menus in navbar with layout `Stacked Center Split`
- Fix loop youtube videos
- Fix PageBuilder button in IE 11

## 1.3.13 (March 07, 2017)

### Fixed

- Fix transparent header behaviour
- Fix builder in Firefox

## 1.3.12 (March 03, 2017)

### Fixed

- Fix "sticky on up" behaviour in Navbar

## 1.3.11 (March 02, 2017)

### Changed

- Disable 'Visual' Editor button on page edit view (WordPress)

### Fixed

- Fix JavaScript error in frontend
- Fix navbar groups center left/right in IE 11
- Fix alt attribute for images in grid element
- Fix blockquote inverse color in fjord style
- Fix panel animations in customizer (WordPress)
- Fix transparent png issue if resized

## 1.3.10 (March 02, 2017)

### Fixed

- Fix transparent navbar overlay
- Fix widgetkit compatibility (WordPress)

## 1.3.9 (March 01, 2017)

### Added

- Add Sonic style
- Add background image option to section styles
- Add gutter and breakpoint option to description-list element
- Add text color setting to headline, module / widget and panel element
- Add on hover box-shadow option to image element
- Add support for heading hero
- Add display link option to list element
- Add image box-shadow option to panel and grid element
- Add receiver icon to social icons
- Add gradient support to divider, icon, navbar, progress and subnav

### Changed

- Use JS solution for transparent headers

### Fixed

- Fix image background position center for sections
- Fix responsive breakpoints for Quarters 1-2-1 row layout
- Fix display image option in list element
- Fix modules/menu items staying checked out after edit (Joomla)
- Fix mod_menu apply additional params (Joomla)
- Fix image transparency issue on resize

## 1.3.8 (February 17, 2017)

### Fixed

- Fix Grid element
- Fix library layout saving
- Fix Maps element
- Fix custom menu widget rendering (WordPress)
- Fix saving widget settings (WordPress)

## 1.3.7 (February 16, 2017)

### Fixed

- Fix images in pro layouts overview
- Fix justified dropdown menu item
- Fix Media Picker (Joomla)

## 1.3.6 (February 15, 2017)

### Fixed

- Fix module select in builder (Joomla)
- Fix finder module advanced mode (Joomla)

## 1.3.5 (February 14, 2017)

### Fixed

- Fix builder issue with empty value

## 1.3.4 (February 13, 2017)

### Added

- Show builder toolbars in footer
- Add menu style setting for menu modules/widgets
- Add image align bottom option to panel and grid element

### Changed

- Update UIkit to 3.0.0 beta10

### Fixed

- Fix Google Fonts in font picker
- Fix social icons wrapping if navbar is centered
- Fix content change check on articles with tinyMCE 3.x (Joomla)

## 1.3.3 (February 06, 2017)

### Added

- Gradient field for style

### Fixed

- Fix scrollspy animations
- Fix content change check on articles with tinyMCE (Joomla)

## 1.3.2 (February 03, 2017)

### Changed

- Update UIkit to 3.0.0 beta9
- Update German admin language file

### Removed

- Custom dropdown width for single navbar items

### Fixed

- Fix Google font subset loading in IE
- Fix start/end level menu module setting (Joomla)
- Fix comment submit button style for iOS (WordPress)
- Fix Media Picker in frontend (Joomla)

## 1.3.1 (February 02, 2017)

### Changed

- Update UIkit to 3.0.0 beta8
- Revert header split menu behavior
- Check replace layout option by default

### Fixed

- Fix IE compatibility
- Section xsmall variable in style customizer
- Fix dotnav inverse variables
- Fix hidden title field for panel and grid element

## 1.3.0 (February 01, 2017)

### Added

- Add Fjord style
- Add layout library
- Add UIkit theme to style customizer
- Add German admin language file
- Add panel fields and options to grid element
- Add meta field and options to panel element
- Add image card and content style options to panel element
- Add option for overlapping sections with richer graphics
- Add more section height options
- Add gradient support to button, card, overlay and section
- Add background-image support to section

### Changed

- Move content settings into their own tab for panel element
- Move animations to grid items for grid element
- Update UIkit to 3.0.0 beta7

### Fixed

- Fix logo centering for split navbar header layout
- Fix image alignment in panel element
- Fix order option for breakpoints in builder rows
- Fix uploads in Media Picker (Joomla)
- Fix error messages in Media Picker (Joomla)
- Add missing video dimensions for video sections

## 1.2.16 (January 24, 2017)

### Added

- Add German language file (site)

### Changed

- Update UIkit to 3.0.0 beta6

### Fixed

- Fix module/widget list style
- Fix maps element (WordPress)

## 1.2.15 (January 23, 2017)

### Fixed

- Fix customizer settings (WordPress)

## 1.2.14 (January 22, 2017)

### Changed

- Update UIkit to 3.0.0 beta5

### Fixed

- Fix viewport height issue
- Fix IE + Edge compatibility

## 1.2.13 (January 21, 2017)

### Fixed

- Fix Jetpack compatibility (WordPress)

## 1.2.12 (January 19, 2017)

### Added

- Add inherit to typo options in style customizer
- Add font-style option to meta text in style customizer

### Fixed

- Fix IE + Edge compatibility

## 1.2.11 (January 18, 2017)

### Fixed

- Fix builder sorting
- Fix UIkit icon image path
- Fix preview module positions (Joomla)

## 1.2.10 (January 17, 2017)

### Added

- Add pagination option to toggle Start/End links (Joomla)

### Changed

- Update leaflet to 1.0.2
- Update dropdown nav in max style
- Update default code, pre and blockquote style
- Change global border-radius behaviour in themes
- Change default value for zooming/dragging option in maps element
- Adapt customizer style to latest WordPress version (WordPress)

### Fixed

- Fix card component hover transition
- Fix image paths for divider and list icons in fuse and horizon style
- Fix WooCommerce gallery thumbnailview for WooCommerce 2.7+ (WordPress)

## 1.2.9 (January 02, 2017)

### Added

- Add Joline style
- Add box-shadow option to image element
- Add x-small padding to section options

### Changed

- Optimized CSS selectors for inverse mode
- Renamed UIkit internal image variables
- Update pagination output

### Fixed

- Fix form border for inverse mode
- Fix link style for inverse mode
- Fix blockquote footer color for inverse mode
- Fix badge focus style
- Fix categories count in article view (WordPress)

## 1.2.8 (December 23, 2016)

### Changed

- Renamed styles to website name

### Fixed

- Fix style parsing
- Fix navbar decorative line in Safari
- Fix module/widget list style on sections

## 1.2.7 (December 22, 2016)

### Fixed

- Fix asset cache breaker (Joomla)
- Fix inline style/script order (WordPress)

## 1.2.6 (December 21, 2016)

### Changed

- Update Module/Widget builder element select

### Fixed

- Fix double initialization (WordPress)

## 1.2.5 (December 20, 2016)

### Added

- Add list options for modules/widgets

### Fixed

- Fix builder sorting
- Fix navbar behaviour
- Fix resizing of images with non-alphanumeric characters
- Fix map element with hidden markers
- Fix render menu widgets (WordPress)
- Fix labels in navbar item edit (WordPress)
- Fix child-theme module overrides (Joomla)

## 1.2.4 (December 14, 2016)

### Changed

- Update "Read more" translation
- Customizer route redirects to login for guests (Joomla)

### Fixed

- Fix z-index issue for Map elements
- Fix Module/Widget builder element settings
- Fix code syntax highlighting
- Fix builder refresh issue (WordPress)
- Fix compatibility with Advanced Module Manager extension (Joomla)

## 1.2.3 (December 12, 2016)

### Fixed

- Fix edit template style (Joomla)

## 1.2.2 (December 12, 2016)

### Added

- Add button text style mode
- Add border option to dropdowns and subnav pill
- Add typo options to blockquote footer
- Add more text alignment options for modules/widgets
- Add border bottom option to headerbar top
- Add option to hide category title on archive view (WordPress)

### Changed

- Minor UIkit theme modifications

### Fixed

- Fix category multi-column order (Joomla)
- Fix dropdowns in customizer mode (WordPress)

## 1.2.1 (December 07, 2016)

### Fixed

- Fix WordPress 4.7 incompatibility issue
- Fix check for API key (Joomla)
- Fix featured article parameters (Joomla)
- Fix title on edit modules and menu items modal (Joomla)

## 1.2.0 (December 05, 2016)

### Added

- Add Max style
- Add layout options for blog and posts
- Add title options for modules/widgets
- Add headline style line to elements
- Add preserve color option for primary and secondary sections
- Add x-large padding to section options
- Launch page builder from article edit (Joomla)
- Add dashboard quickicon for website builder (Joomla)
- Add front-end editing if page builder is active (Joomla)

### Changed

- Refactored system pages and modules/widgets
- Split element component into divider, heading and link component
- Primary and secondary sections now adapt the text color automatically
- page builder button opens builder directly (WordPress)
- Mark menu-item as active if current page is a sub-page of the menu-item (WordPress)

### Fixed

- Fix sidebar wrapping if grid gutter is none
- Fix element settings if previously saved empty
- Fix WooCommerce styling
- Fix module blank style
- Resetting style variables shows save button
- Fix widget selection in builder (WordPress)
- Fix missing alt attribute for intro images (Joomla)
- Fix CodeMirror overflow in front-end editing (Joomla)

## 1.1.6 (November 24, 2016)

### Changed

- Set form radio background to transparent in material UIkit style

### Fixed

- Fix icon ratio and color in list element
- Fix scroll behaviour on page refresh
- Fix Map element (WordPress)
- Fix Navbar item options (WordPress)

## 1.1.5 (November 21, 2016)

### Added

- Add max width option for grids in the builder
- Add option to open links in new window to list elements
- Add smooth scrolling to links with URL fragments in elements
- Add sidebar.php layout file (required by WooCommerce)
- Add icon alignment option to button element
- Add icon option to list element
- Add link muted as style option to button element
- Make builder element templates overridable in child-theme (/builder/{element}/template.php)

### Changed

- Update Bootstrap layer (Joomla)

### Fixed

- Make transparent header work with section styles
- Remove possible horizontal scrollbar during animations
- Fix font-smoothing after animation for Webkit
- Fix textarea border for minimal style
- Fix z-index issue for mobile dropdown menu
- Ignore compression setting in customizer mode
- Access check on builder page (Joomla)
- Save button on Menu/Module edit (Joomla)
- Navbar item options (WordPress)
- Fix asset urls within installations using custom ports (WordPress)

## 1.1.4 (November 15, 2016)

### Added

- Clear cache button
- Pass through video url parameters (video element)

### Changed

- Saving a layout won't show the builder's save button
- Show default social icon if service is unknown

### Fixed

- Element sorting in builder
- Menu widgets (WordPress)

## 1.1.3 (November 11, 2016)

### Fixed

- Fix theme updater (WordPress)

## 1.1.2 (November 11, 2016)

### Fixed

- Fix builder on empty article (Joomla)

## 1.1.1 (November 10, 2016)

### Added

- "New" button for menu items and modules (Joomla)

### Changed

- Update Google Fonts list
- Optimize drag style for builder elements
- Optimize changelog style

### Fixed

- Fix element animations delay
- Fix image element svg width/heigth
- Fix custom class on module/widget element
- Fix child themes (WordPress)
- Fix duplicating social icons bug (WordPress)
- Fix builder output when cache enabled (Joomla)

## 1.1.0 (November 07, 2016)

### Added

- Add WordPress support
- Add grid element to builder
- Apply content plugins/shortcodes to Builder output

### Fixed

- Fix builder element default values
- Fix click behaviour on item links in navbar
- Fix builder row layout edit
- Fix iconnav test

## 1.0.11 (November 02, 2016)

### Fixed

- Fix regression with Google fonts

## 1.0.10 (November 02, 2016)

### Added

- Add Horizon style
- Add fixed width option for grids
- Add decorative line for navbar items
- Add divider small style
- Add border mode top, left and right to style components
- Add box-shadow option to form and offcanvas
- Add more style options to blockquote and card badge

### Changed

- Improved variables ordering in style customizer
- Improved preview loading

### Fixed

- Customizer "cancel" no longer resets builder changes
- Make heading bullet work with text align
- Fix initial missing Google font variant and language settings
- Fix section default values
- Fix "Export variables" button disabled state
- Scrollspy animation classes are no longer applied to the row
- Joomla Module element respects its module's settings

## 1.0.9 (October 26, 2016)

### Added

- Add large option to section width
- Add xl alignment breakpoint for text align in elements

### Fixed

- Fix administration style
- Fix error on closing panel with editor, before value is set
- Fix always respect blog columns setting, preventing full-width articles
- Fix populate image alt attribute with filename if no alt text is set
- Fix missing inverse style options in components
- Respect blog columns to prevent full width articles at the end
- HTML tags will no longer be stripped from footer elements

## 1.0.8 (October 21, 2016)

### Changed

- Significant speed improvement for style customizer

### Fixed

- Catch error with builder element
- Fix cancel button behaviour

## 1.0.7 (October 20, 2016)

### Added

- Add box shadow options to style components
- Add 100% width option in module template settings

### Changed

- Move image/video options for sections into their own panel
- Optimized box-shadow picker
- Optimized preview loading

### Fixed

- Fix default values in builder elements
- Fix variable names in style customizer
- Center social icons in header modal
- Fix builder toolbar (Safari 10)
- Fix page class output
- Fix .row-striped styling (Bootstrap)
- Fix css minification

## 1.0.6 (October 19, 2016)

### Changed

- Wrap custom js code in try/catch block
- Optimize variable groups in style
- Rename search border radius variable

### Fixed

- Update UIkit components after css injection in style preview panel
- Fix style group ordering
- Fix media manager in debug mode (Joomla)
- Fix text color option if navbar is transparent
- Fix UIkit tests if boxed page layout is set

## 1.0.5 (October 18, 2016)

### Added

- Add border and typo options to style components
- Add border mode to style components
- Add background and border options to slidenav and totop style component
- Allow for css/custom.css in child theme
- Allow to add style via child themes

### Changed

- Minify theme CSS
- Load minified UIkit
- LESS updates accordion to UIkit
- Optimize UIkit tests
- Optimize variable groups in style
- Rename subnav, tab and breadcrumb item variables

### Fixed

- Prevent background repeat for section images
- Fix card media border-radius
- Expand main section to fill the viewport if needed
- Set default style to minimal
- Load Bootstrap framework
- Builder row layout select (Safari 10)
- Template module positions preview (tp=1)
- Fix Bootstrap input resets
- Fix CodeMirror style

## 1.0.4 (October 12, 2016)

### Fixed

- Fix minor UI issues
- Fix image indicator if color field is none

## 1.0.3 (October 11, 2016)

### Fixed

- Fix style font picker
- Fix child theme select
- Fix preview box-shadow
- Fix temporarily preview scrollbars in Firefox
- Prevent builder being active on offline login
- Prevent modules/menu items stay checked out after edit

## 1.0.2 (October 11, 2016)

### Fixed

- Fix modules rendering bug
- Fix offline mode in preview

## 1.0.1 (October 10, 2016)

### Fixed

- Fix Joomla URI handling

## 1.0.0 (October 10, 2016)

### Added

- Initial release
