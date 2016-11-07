<?php
namespace Concrete\Controller\Frontend;

use Controller;
use Concrete\Core\File\Type\Type as FileType;
use Concrete\Core\Localization\Localization;
use Core;
use Environment;

class AssetsLocalization extends Controller
{
    protected static function sendJavascriptHeader()
    {
        header('Content-type: text/javascript; charset='.APP_CHARSET);
    }

    public static function getCoreJavascript($setResponseHeaders = true)
    {
        if ($setResponseHeaders) {
            static::sendJavascriptHeader();
        }
        ?>
var ccmi18n = {
  expand: <?php echo json_encode(t('Expand'))?>,
  cancel: <?php echo json_encode(t('Cancel'))?>,
  collapse: <?php echo json_encode(t('Collapse'))?>,
  error: <?php echo json_encode(t('Error'))?>,
  deleteBlock: <?php echo json_encode(t('Block Deleted'))?>,
  deleteBlockMsg: <?php echo json_encode(t('The block has been removed successfully.'))?>,
  addBlock: <?php echo json_encode(t('Add Block'))?>,
  addBlockNew: <?php echo json_encode(t('Add Block'))?>,
  addBlockStack: <?php echo json_encode(t('Add Stack'))?>,
  addBlockStackMsg: <?php echo json_encode(t('The stack has been added successfully'))?>,
  addBlockPaste: <?php echo json_encode(t('Paste from Clipboard'))?>,
  changeAreaCSS: <?php echo json_encode(t('Design'))?>,
  editAreaLayout: <?php echo json_encode(t('Edit Layout'))?>,
  addAreaLayout: <?php echo json_encode(t('Add Layout'))?>,
  moveLayoutUp: <?php echo json_encode(t('Move Up'))?>,
  moveLayoutDown: <?php echo json_encode(t('Move Down'))?>,
  moveLayoutAtBoundary: <?php echo json_encode(t('This layout section can not be moved further in this direction.'))?>,
  areaLayoutPresets: <?php echo json_encode(t('Layout Presets'))?>,
  lockAreaLayout: <?php echo json_encode(t('Lock Layout'))?>,
  unlockAreaLayout: <?php echo json_encode(t('Unlock Layout'))?>,
  deleteLayout: <?php echo json_encode(t('Delete'))?>,
  deleteLayoutOptsTitle: <?php echo json_encode(t('Delete Layout'))?>,
  confirmLayoutPresetDelete: <?php echo json_encode(t('Are you sure you want to delete this layout preset?'))?>,
  setAreaPermissions: <?php echo json_encode(t('Set Permissions'))?>,
  addBlockMsg: <?php echo json_encode(t('The block has been added successfully.'))?>,
  updateBlock: <?php echo json_encode(t('Update Block'))?>,
  updateBlockMsg: <?php echo json_encode(t('The block has been saved successfully.'))?>,
  copyBlockToScrapbookMsg: <?php echo json_encode(t('The block has been added to your clipboard.'))?>,
  content: <?php echo json_encode(t('Content'))?>,
  closeWindow: <?php echo json_encode(t('Close'))?>,
  editBlock: <?php echo json_encode(t('Edit'))?>,
  editBlockWithName: <?php echo json_encode(tc('%s is a block type name', 'Edit %s'))?>,
  setPermissionsDeferredMsg: <?php echo json_encode(t('Permission setting saved. You must complete the workflow before this change is active.'))?>,
  editStackContents: <?php echo json_encode(t('Manage Stack Contents'))?>,
  compareVersions: <?php echo json_encode(t('Compare Versions'))?>,
  blockAreaMenu: <?php echo json_encode(t('Add Block'))?>,
  arrangeBlock: <?php echo json_encode(t('Move'))?>,
  arrangeBlockMsg: <?php echo json_encode(t('Blocks arranged successfully.'))?>,
  copyBlockToScrapbook: <?php echo json_encode(t('Copy to Clipboard'))?>,
  changeBlockTemplate: <?php echo json_encode(t('Custom Template'))?>,
  changeBlockCSS: <?php echo json_encode(t('Design'))?>,
  errorCustomStylePresetNoName: <?php echo json_encode(t('You must give your custom style preset a name.'))?>,
  changeBlockBaseStyle: <?php echo json_encode(t('Set Block Styles'))?>,
  confirmCssReset: <?php echo json_encode(t('Are you sure you want to remove all of these custom styles?'))?>,
  confirmCssPresetDelete: <?php echo json_encode(t('Are you sure you want to delete this custom style preset?'))?>,
  setBlockPermissions: <?php echo json_encode(t('Set Permissions'))?>,
  setBlockAlias: <?php echo json_encode(t('Setup on Child Pages'))?>,
  setBlockComposerSettings: <?php echo json_encode(t('Composer Settings'))?>,
  themeBrowserTitle: <?php echo json_encode(t('Get More Themes'))?>,
  themeBrowserLoading: <?php echo json_encode(t('Retrieving theme data from concrete5.org marketplace.'))?>,
  addonBrowserLoading: <?php echo json_encode(t('Retrieving add-on data from concrete5.org marketplace.'))?>,
  clear: <?php echo json_encode(t('Clear'))?>,
  requestTimeout: <?php echo json_encode(t('This request took too long.'))?>,
  generalRequestError: <?php echo json_encode(t('An unexpected error occurred.'))?>,
  helpPopup: <?php echo json_encode(t('Help'))?>,
  community: <?php echo json_encode(t('concrete5 Marketplace'))?>,
  communityCheckout: <?php echo json_encode(t('concrete5 Marketplace - Purchase & Checkout'))?>,
  communityDownload: <?php echo json_encode(t('concrete5 Marketplace - Download'))?>,
  noIE6: <?php echo json_encode(t('concrete5 does not support Internet Explorer 6 in edit mode.'))?>,
  helpPopupLoginMsg: <?php echo json_encode(t('Get more help on your question by posting it to the concrete5 help center on concrete5.org'))?>,
  marketplaceErrorMsg: <?php echo json_encode(t('<p>You package could not be installed.  An unknown error occured.</p>'))?>,
  marketplaceInstallMsg: <?php echo json_encode(t('<p>Your package will now be downloaded and installed.</p>'))?>,
  marketplaceLoadingMsg: <?php echo json_encode(t('<p>Retrieving information from the concrete5 Marketplace.</p>'))?>,
  marketplaceLoginMsg: <?php echo json_encode(t('<p>You must be logged into the concrete5 Marketplace to install add-ons and themes.  Please log in.</p>'))?>,
  marketplaceLoginSuccessMsg: <?php echo json_encode(t('<p>You have successfully logged into the concrete5 Marketplace.</p>'))?>,
  marketplaceLogoutSuccessMsg: <?php echo json_encode(t('<p>You are now logged out of concrete5 Marketplace.</p>'))?>,
  deleteAttributeValue: <?php echo json_encode(t('Are you sure you want to remove this value?'))?>,
  customizeSearch: <?php echo json_encode(t('Customize Search'))?>,
  properties: <?php echo json_encode(t('Page Saved'))?>,
  savePropertiesMsg: <?php echo json_encode(t('Page Properties saved.'))?>,
  saveSpeedSettingsMsg: <?php echo json_encode(t('Full page caching settings saved.'))?>,
  saveUserSettingsMsg: <?php echo json_encode(t('User Settings saved.'))?>,
  ok: <?php echo json_encode(t('Ok'))?>,
  scheduleGuestAccess: <?php echo json_encode(t('Schedule Guest Access'))?>,
  scheduleGuestAccessSuccess: <?php echo json_encode(t('Timed Access for Guest Users Updated Successfully.'))?>,
  newsflowLoading: <?php echo json_encode(t('Checking for updates.'))?>,
  x: <?php echo json_encode(t('x'))?>,
  user_activate: <?php echo json_encode(t('Activate Users'))?>,
  user_deactivate: <?php echo json_encode(t('Deactivate Users'))?>,
  user_delete: <?php echo json_encode(t('Delete'))?>,
  user_group_remove: <?php echo json_encode(t('Remove From Group'))?>,
  user_group_add: <?php echo json_encode(t('Add to Group'))?>,
  none: <?php echo json_encode(t('None'))?>,
  editModeMsg: <?php echo json_encode(t('Let\'s start editing a page.'))?>,
  editMode: <?php echo json_encode(t('Edit Mode'))?>,
  save: <?php echo json_encode(t('Save'))?>,
  currentImage: <?php echo json_encode(t('Current Image'))?>,
  image: <?php echo json_encode(t('Image'))?>,
  size: <?php echo json_encode(t('Size'))?>,
  chooseFont: <?php echo json_encode(t('Choose Font'))?>,
  fontWeight: <?php echo json_encode(t('Font Weight'))?>,
  italic: <?php echo json_encode(t('Italic'))?>,
  underline: <?php echo json_encode(t('Underline'))?>,
  uppercase: <?php echo json_encode(t('Uppercase'))?>,
  fontSize: <?php echo json_encode(t('Font Size'))?>,
  letterSpacing: <?php echo json_encode(t('Letter spacing'))?>,
  lineHeight: <?php echo json_encode(t('Line Height'))?>,
  emptyArea: <?php echo json_encode(t('Empty %s Area', '<%- area_handle %>'))?>
};

var ccmi18n_editor = {
  insertLinkToFile: <?php echo json_encode(t('Insert Link to File'))?>,
  insertImage: <?php echo json_encode(t('Insert Image'))?>,
  insertLinkToPage: <?php echo json_encode(t('Link to Page'))?>
};

var ccmi18n_sitemap = {
  seo: <?php echo json_encode(t('SEO'))?>,
  pageLocation: <?php echo json_encode(t('Location'))?>,
  pageLocationTitle: <?php echo json_encode(t('Location'))?>,
  visitExternalLink: <?php echo json_encode(t('Visit'))?>,
  editExternalLink: <?php echo json_encode(t('Edit External Link'))?>,
  deleteExternalLink: <?php echo json_encode(t('Delete'))?>,
  copyProgressTitle: <?php echo json_encode(t('Copy Progress'))?>,
  addExternalLink: <?php echo json_encode(t('Add External Link'))?>,
  sendToTop: <?php echo json_encode(t('Send To Top'))?>,
  sendToBottom: <?php echo json_encode(t('Send To Bottom'))?>,
  emptyTrash: <?php echo json_encode(t('Empty Trash'))?>,
  restorePage: <?php echo json_encode(t('Restore Page'))?>,
  deletePageForever: <?php echo json_encode(t('Delete Forever'))?>,
  previewPage: <?php echo json_encode(t('Preview'))?>,
  visitPage: <?php echo json_encode(t('Visit'))?>,
  pageAttributes: <?php echo json_encode(t('Attributes'))?>,
  speedSettings: <?php echo json_encode(t('Caching'))?>,
  speedSettingsTitle: <?php echo json_encode(t('Caching'))?>,
  pageAttributesTitle: <?php echo json_encode(t('Attributes'))?>,
  pagePermissionsTitle: <?php echo json_encode(t('Page Permissions'))?>,
  setPagePermissions: <?php echo json_encode(t('Permissions'))?>,
  setPagePermissionsMsg: <?php echo json_encode(t('Page permissions updated successfully.'))?>,
  pageDesignMsg: <?php echo json_encode(t('Theme and page type updated successfully.'))?>,
  pageDesign: <?php echo json_encode(t('Design &amp; Type'))?>,
  pageVersions: <?php echo json_encode(t('Versions'))?>,
  deletePage: <?php echo json_encode(t('Delete'))?>,
  deletePages: <?php echo json_encode(t('Delete Pages'))?>,
  deletePageSuccessMsg: <?php echo json_encode(t('The page has been removed successfully.'))?>,
  deletePageSuccessDeferredMsg: <?php echo json_encode(t('Delete request saved. You must complete the workflow before the page is fully removed.'))?>,
  addPage: <?php echo json_encode(t('Add Page'))?>,
  moveCopyPage: <?php echo json_encode(t('Move/Copy'))?>,
  reorderPage: <?php echo json_encode(t('Change Page Order'))?>,
  reorderPageMessage: <?php echo json_encode(t('Move or reorder pages by dragging their icons.'))?>,
  moveCopyPageMessage: <?php echo json_encode(t('Choose a new parent page from the sitemap.'))?>,
  editInComposer: <?php echo json_encode(t('Edit in Composer'))?>,
  searchPages: <?php echo json_encode(t('Search Pages'))?>,
  explorePages: <?php echo json_encode(t('Flat View'))?>,
  backToSitemap: <?php echo json_encode(t('Back to Sitemap'))?>,
  searchResults: <?php echo json_encode(t('Search Results'))?>,
  createdBy: <?php echo json_encode(t('Created By'))?>,
  choosePage: <?php echo json_encode(t('Choose a Page'))?>,
  viewing: <?php echo json_encode(t('Viewing'))?>,
  results: <?php echo json_encode(t('Result(s)'))?>,
  max: <?php echo json_encode(t('max'))?>,
  noResults: <?php echo json_encode(t('No results found.'))?>,
  areYouSure: <?php echo json_encode(t('Are you sure?'))?>,
  loadingText: <?php echo json_encode(t('Loading'))?>,
  loadError: <?php echo json_encode(t('Unable to load sitemap data. Response received: '))?>,
  loadErrorTitle: <?php echo json_encode(t('Unable to load sitemap data.'))?>,
  on: <?php echo json_encode(t('on'))?>
};

var ccmi18n_spellchecker = {
  resumeEditing: <?php echo json_encode(t('Resume Editing'))?>,
  noSuggestions: <?php echo json_encode(t('No Suggestions'))?>
};

var ccmi18n_groups = {
  editGroup: <?php echo json_encode(t('Edit Group'))?>,
  editPermissions: <?php echo json_encode(t('Edit Permissions'))?>
};

var ccmi18n_filemanager = {
  view: <?php echo json_encode(t('View'))?>,
  download: <?php echo json_encode(t('Download'))?>,
  select: <?php echo json_encode(t('Choose'))?>,
  duplicateFile: <?php echo json_encode(t('Copy File'))?>,
  clear: <?php echo json_encode(t('Clear'))?>,
  edit: <?php echo json_encode(t('Edit'))?>,
  replace: <?php echo json_encode(t('Replace'))?>,
  duplicate: <?php echo json_encode(t('Copy'))?>,
  chooseNew: <?php echo json_encode(t('Choose New File'))?>,
  sets: <?php echo json_encode(t('Sets'))?>,
  permissions: <?php echo json_encode(t('Permissions'))?>,
  properties: <?php echo json_encode(t('Properties'))?>,
  deleteFile: <?php echo json_encode(t('Delete'))?>,
  title: <?php echo json_encode(t('File Manager'))?>,
  uploadErrorChooseFile: <?php echo json_encode(t('You must choose a file.'))?>,
  rescan: <?php echo json_encode(t('Rescan'))?>,
  pending: <?php echo json_encode(t('Pending'))?>,
  uploadComplete: <?php echo json_encode(t('Upload Complete'))?>,
  uploadFailed: <?php echo json_encode(t('Upload Failed'))?>,
  uploadProgress: <?php echo json_encode(t('Upload Progress'))?>,
  chosenTooMany: <?php echo json_encode(t('You may only select a single file.'))?>,
  PTYPE_CUSTOM: <?php echo json_encode(/*FilePermissions::PTYPE_CUSTOM*/ '')?>,
  PTYPE_NONE: <?php echo json_encode(/*FilePermissions::PTYPE_NONE*/ '')?>,
  PTYPE_ALL: <?php echo json_encode(/*FilePermissions::PTYPE_ALL*/ '')?>,
  FTYPE_IMAGE: <?php echo json_encode(FileType::T_IMAGE)?>,
  FTYPE_VIDEO: <?php echo json_encode(FileType::T_VIDEO)?>,
  FTYPE_TEXT: <?php echo json_encode(FileType::T_TEXT)?>,
  FTYPE_AUDIO: <?php echo json_encode(FileType::T_AUDIO)?>,
  FTYPE_DOCUMENT: <?php echo json_encode(FileType::T_DOCUMENT)?>,
  FTYPE_APPLICATION: <?php echo json_encode(FileType::T_APPLICATION)?>
};

var ccmi18n_chosen = {
  placeholder_text_multiple: <?php echo json_encode(t('Select Some Options'))?>,
  placeholder_text_single: <?php echo json_encode(t('Select an Option'))?>,
  no_results_text: <?php echo json_encode(t(/*i18n After this text we have a search criteria: for instance 'No results match "Criteria"'*/'No results match'))?>
};

var ccmi18n_topics = {
  addCategory: <?php echo json_encode(t('Add Category'))?>,
  editCategory: <?php echo json_encode(t('Edit Category'))?>,
  deleteCategory: <?php echo json_encode(t('Delete Category'))?>,
  cloneCategory: <?php echo json_encode(t('Clone Category'))?>,
  addTopic: <?php echo json_encode(t('Add Topic'))?>,
  editTopic: <?php echo json_encode(t('Edit Topic'))?>,
  deleteTopic: <?php echo json_encode(t('Delete Topic'))?>,
  cloneTopic: <?php echo json_encode(t('Clone Topic'))?>,
  editPermissions: <?php echo json_encode(t('Edit Permissions'))?>
};

var ccmi18n_tourist = {
  skipButton: <?php echo json_encode('<button class="btn btn-default btn-sm pull-right tour-next">'.t('Skip →').'</button>')?>,
  nextButton: <?php echo json_encode('<button class="btn btn-primary btn-sm pull-right tour-next">'.t('Next →').'</button>')?>,
  finalButton: <?php echo json_encode('<button class="btn btn-primary btn-sm pull-right tour-next">'.t('Done').'</button>')?>,
  closeButton: <?php echo json_encode('<a class="btn btn-close tour-close" href="#"><i class="fa fa-remove"></i></a>')?>,
  okButton: <?php echo json_encode('<button class="btn btn-sm tour-close btn-primary">'.t('Ok').'</button>')?>,
  doThis: <?php echo json_encode(t('Do this:'))?>,
  thenThis: <?php echo json_encode(t('Then this:'))?>,
  nextThis: <?php echo json_encode(t('Next this:'))?>,
  stepXofY: <?php echo json_encode(t('step %1$d of %2$d'))?>
};

var ccmi18n_helpGuides = {
  'add-page': [
    {title: <?php echo json_encode(t('Pages Panel'))?>, text: <?php echo json_encode(t('The pages is where you go to add a new page to your site, or jump between existing pages. To open the pages panel, click the icon.'))?>},
    {title: <?php echo json_encode(t('Page Types'))?>, text: <?php echo json_encode(t('This is your list of page types. Click any of them to add a page.'))?>},
    {title: <?php echo json_encode(t('Sitemap'))?>, text: <?php echo json_encode(t('This is your sitemap. Use it to easily navigate your site.'))?>}
  ],
  'change-content-edit-mode': [
    {title: <?php echo json_encode(t('Edit Mode Active'))?>, text: <?php echo json_encode(t('The highlighted button makes it obvious you\'re in edit mode.'))?>},
    {title: <?php echo json_encode(t('Edit the Block'))?>, text: <?php echo json_encode(t('Just roll over any content on the page. Click or tap to get the edit menu for that block.'))?>},
    {title: <?php echo json_encode(t('Edit Menu'))?>, text: <?php echo json_encode(t('Use this menu to edit a block\'s contents, change its display, or remove it entirely.'))?>},
    {title: <?php echo json_encode(t('Save Changes'))?>, text: <?php echo json_encode(t("When you're done editing you can Save Changes for other editors to see, or Publish Changes to make your changes live immediately."))?>}
  ],
  'change-content': [
    {title: <?php echo json_encode(t('Enter Edit Mode'))?>, text: <?php echo json_encode(t('First, click the "Edit Page" button. This will enter edit mode for this page.'))?>}
  ],
  'dashboard': [
    {title: <?php echo json_encode(t('Dashboard Panel'))?>, text: <?php echo json_encode(t('The dashboard is where you go to manage aspects of your site that have to do with more than the content on just one page. Click the sliders icon.'))?>},
    {title: <?php echo json_encode(t('Sitemap'))?>, text: <?php echo json_encode(t("The sitemap lets manage the structure of your website. You can delete pages you don't need, or drag them around the tree to suit your needs."))?>}
  ],
  'location-panel': [
    {title: <?php echo json_encode(t('Choose Location'))?>, text: <?php echo json_encode(t('Click this button to choose the location of the page in your sitemap. If saved, the page will be moved to this location.'))?>},
    {title: <?php echo json_encode(t('Page URLs'))?>, text: <?php echo json_encode(t('Control the URLs used to access your page here. Non-canonical URLs will redirect to your page; canonical URLs can be either generated or automatically or overridden. Sub-pages to this page start with canonical URLs by default.'))?>}
  ],
  'personalize': [
    {title: <?php echo json_encode(t('Properties Panel'))?>, text: <?php echo json_encode(t('The properties panel controls data and details about the current page including design customizations. To open the properties panel, click the gear icon.'))?>},
    {title: <?php echo json_encode(t('Page Design'))?>, text: <?php echo json_encode(t('From here you can change your page template and customize your page\'s styles.'))?>},
    {title: <?php echo json_encode(t('Customize'))?>, text: <?php echo json_encode(t('Click here to load the theme customizer for the page.'))?>}
  ],
  'toolbar': [
    {title: <?php echo json_encode(t('Edit Mode'))?>, text: <?php echo json_encode(t('Edit anything on this page by clicking the pencil icon.'))?>},
    {title: <?php echo json_encode(t('Settings'))?>, text: <?php echo json_encode(t('Change the general look and options like SEO and permissions. Delete the page or roll versions back from here as well.'))?>},
    {title: <?php echo json_encode(t('Add Content'))?>, text: <?php echo json_encode(t('Place a new block on the page. Copy one using the clipboard, or try a reusable stack.'))?>},
    {title: <?php echo json_encode(t('Intelligent Search'))?>, text: <?php echo json_encode(t('At a loss? Try searching here. You can find anything from pages in your site to settings and how-to documentation.'))?>},
    {title: <?php echo json_encode(t('Add Page'))?>, text: <?php echo json_encode(t('Add a new page to your site, or quickly jump around your sitemap.'))?>},
    {title: <?php echo json_encode(t('Dashboard'))?>, text: <?php echo json_encode(t('Anything that isn\'t specific to this page happens here. Manage users, files, reporting data, and site-wide settings.'))?>}
  ]
}
<?php

    }

    public static function getSelect2Javascript($setResponseHeaders = true)
    {
        if ($setResponseHeaders) {
            static::sendJavascriptHeader();
        }
        $locale = str_replace('_', '-', Localization::activeLocale());
        if ($locale === 'en-US') {
            echo '// No needs to translate '.$locale;
        } else {
            $env = Environment::get();
            /* @var $env \Concrete\Core\Foundation\Environment */
            $language = Localization::activeLanguage();
            $alternatives = array($locale);
            if (strcmp($locale, $language) !== 0) {
                $alternatives[] = $language;
            }
            $found = null;
            foreach ($alternatives as $alternative) {
                $r = $env->getRecord(DIRNAME_JAVASCRIPT."/i18n/select2_locale_{$alternative}.js");
                if (is_file($r->file)) {
                    $found = $r->file;
                    break;
                }
            }
            if (isset($found)) {
                readfile($found);
            } else {
                echo '// No select2 translations for '.implode(', ', $alternatives);
            }
        }
    }

    public static function getRedactorJavascript($setResponseHeaders = true)
    {
        if ($setResponseHeaders) {
            static::sendJavascriptHeader();
        }
        $locale = Localization::activeLocale();
        ?>
jQuery.Redactor.opts.langs[<?php echo json_encode($locale)?>] = {
  html: <?php echo json_encode(t('HTML'))?>,
  video: <?php echo json_encode(t('Insert Video'))?>,
  image: <?php echo json_encode(t('Insert Image'))?>,
  table: <?php echo json_encode(t('Table'))?>,
  link: <?php echo json_encode(t('Link'))?>,
  link_insert: <?php echo json_encode(t('Insert link'))?>,
  link_edit: <?php echo json_encode(t('Edit link'))?>,
  unlink: <?php echo json_encode(t('Unlink'))?>,
  formatting: <?php echo json_encode(t('Formatting'))?>,
  paragraph: <?php echo json_encode(t('Normal text'))?>,
  quote: <?php echo json_encode(t('Quote'))?>,
  code: <?php echo json_encode(t('Code'))?>,
  header1: <?php echo json_encode(t('Header 1'))?>,
  header2: <?php echo json_encode(t('Header 2'))?>,
  header3: <?php echo json_encode(t('Header 3'))?>,
  header4: <?php echo json_encode(t('Header 4'))?>,
  header5: <?php echo json_encode(t('Header 5'))?>,
  bold: <?php echo json_encode(t('Bold'))?>,
  italic: <?php echo json_encode(t('Italic'))?>,
  fontcolor: <?php echo json_encode(t('Font Color'))?>,
  backcolor: <?php echo json_encode(t('Back Color'))?>,
  unorderedlist: <?php echo json_encode(t('Unordered List'))?>,
  orderedlist: <?php echo json_encode(t('Ordered List'))?>,
  outdent: <?php echo json_encode(t('Outdent'))?>,
  indent: <?php echo json_encode(t('Indent'))?>,
  cancel: <?php echo json_encode(t('Cancel'))?>,
  insert: <?php echo json_encode(t('Insert'))?>,
  save: <?php echo json_encode(t('Save'))?>,
  _delete: <?php echo json_encode(t('Delete'))?>,
  insert_table: <?php echo json_encode(t('Insert Table'))?>,
  insert_row_above: <?php echo json_encode(t('Add Row Above'))?>,
  insert_row_below: <?php echo json_encode(t('Add Row Below'))?>,
  insert_column_left: <?php echo json_encode(t('Add Column Left'))?>,
  insert_column_right: <?php echo json_encode(t('Add Column Right'))?>,
  delete_column: <?php echo json_encode(t('Delete Column'))?>,
  delete_row: <?php echo json_encode(t('Delete Row'))?>,
  delete_table: <?php echo json_encode(t('Delete Table'))?>,
  rows: <?php echo json_encode(t('Rows'))?>,
  columns: <?php echo json_encode(t('Columns'))?>,
  add_head: <?php echo json_encode(t('Add Head'))?>,
  delete_head: <?php echo json_encode(t('Delete Head'))?>,
  title: <?php echo json_encode(t('Title'))?>,
  image_position: <?php echo json_encode(t('Position'))?>,
  none: <?php echo json_encode(t('None'))?>,
  left: <?php echo json_encode(t('Left'))?>,
  right: <?php echo json_encode(t('Right'))?>,
  center: <?php echo json_encode(t('Center'))?>,
  image_web_link: <?php echo json_encode(t('Image Web Link'))?>,
  text: <?php echo json_encode(t('Text'))?>,
  mailto: <?php echo json_encode(t('Email'))?>,
  web: <?php echo json_encode(t('URL'))?>,
  video_html_code: <?php echo json_encode(t('Video Embed Code or Youtube/Vimeo Link'))?>,
  file: <?php echo json_encode(t('Insert File'))?>,
  upload: <?php echo json_encode(t('Upload'))?>,
  download: <?php echo json_encode(t('Download'))?>,
  choose: <?php echo json_encode(t('Choose'))?>,
  or_choose: <?php echo json_encode(t('Or choose'))?>,
  drop_file_here: <?php echo json_encode(t('Drop file here'))?>,
  align_left: <?php echo json_encode(t('Align text to the left'))?>,
  align_center: <?php echo json_encode(t('Center text'))?>,
  align_right: <?php echo json_encode(t('Align text to the right'))?>,
  align_justify: <?php echo json_encode(t('Justify text'))?>,
  horizontalrule: <?php echo json_encode(t('Insert Horizontal Rule'))?>,
  deleted: <?php echo json_encode(t('Deleted'))?>,
  anchor: <?php echo json_encode(t('Anchor'))?>,
  open_link: <?php echo json_encode(t('Open Link'))?>,
  link_new_tab: <?php echo json_encode(t('Open link in new tab'))?>,
  /* concrete5 */
  link_same_window: <?php echo json_encode(t('Open link in same window'))?>,
  in_lightbox: <?php echo json_encode(t('Open link in Lightbox'))?>,
  lightbox_link_type: <?php echo json_encode(t('Link Type'))?>,
  lightbox_link_type_iframe: <?php echo json_encode(t('Web Page'))?>,
  lightbox_link_type_image: <?php echo json_encode(t('Image'))?>,
  lightbox_link_type_iframe_options: <?php echo json_encode(t('Frame Options'))?>,
  lightbox_link_type_iframe_width: <?php echo json_encode(t('Width'))?>,
  lightbox_link_type_iframe_height: <?php echo json_encode(t('Height'))?>,
  customStyles: <?php echo json_encode(t('Custom Styles'))?>,
  remove_font: <?php echo json_encode(t('Remove font'))?>,
  change_font_family: <?php echo json_encode(t('Change font family'))?>,
  remove_font_size: <?php echo json_encode(t('Remove font size'))?>,
  change_font_size: <?php echo json_encode(t('Change font size'))?>,
  remove_style: <?php echo json_encode(t('Remove Style'))?>,
  insert_character: <?php echo json_encode(t('Insert Character'))?>,
  undo: <?php echo json_encode(t('Undo'))?>,
  redo: <?php echo json_encode(t('Redo'))?>,
  /* end concrete5 */
  underline: <?php echo json_encode(t('Underline'))?>,
  alignment: <?php echo json_encode(t('Alignment'))?>,
  filename: <?php echo json_encode(t('Name (optional)'))?>,
  edit: <?php echo json_encode(t('Edit'))?>,
  upload_label: <?php echo json_encode(t('Drop file here or '))?>
};

jQuery.Redactor.opts.lang = <?php echo json_encode($locale)?>;
jQuery.each(jQuery.Redactor.opts.langs.en, function(key, value) {
  if(!(key in jQuery.Redactor.opts.langs[<?php echo json_encode($locale)?>])) {
    jQuery.Redactor.opts.langs[<?php echo json_encode($locale)?>][key] = value;
  }
});
<?php

    }

    public static function getDynatreeJavascript($setResponseHeaders = true)
    {
        if ($setResponseHeaders) {
            static::sendJavascriptHeader();
        }
        ?>
jQuery.ui.dynatree.prototype.options.strings.loading = <?php echo json_encode(t('Loading...'))?>;
jQuery.ui.dynatree.prototype.options.strings.loadError = <?php echo json_encode(t('Load error!'))?>;
<?php

    }

    public static function getImageEditorJavascript($setResponseHeaders = true)
    {
        if ($setResponseHeaders) {
            static::sendJavascriptHeader();
        }
        ?>
var ccmi18n_imageeditor = {
  loadingControlSets: <?php echo json_encode(t('Loading Control Sets...'))?>,
  loadingComponents: <?php echo json_encode(t('Loading Components...'))?>,
  loadingFilters: <?php echo json_encode(t('Loading Filters...'))?>,
  loadingImage: <?php echo json_encode(t('Loading Image...'))?>,
  areYouSure: <?php echo json_encode(t('Are you sure?'))?>
};
        <?php

    }

    public static function getJQueryUIJavascript($setResponseHeaders = true)
    {
        if ($setResponseHeaders) {
            static::sendJavascriptHeader();
        }
        $env = Environment::get();
        /* @var $env \Concrete\Core\Foundation\Environment */
        $alternatives = array(Localization::activeLocale());
        if (Localization::activeLocale() !== Localization::activeLanguage()) {
            $alternatives[] = Localization::activeLanguage();
        }
        $found = null;
        foreach ($alternatives as $alternative) {
            $r = $env->getRecord(DIRNAME_JAVASCRIPT.'/i18n/ui.datepicker-'.str_replace('_', '-', $alternative).'.js');
            if (is_file($r->file)) {
                $found = $r->file;
                break;
            }
        }
        if (isset($found)) {
            readfile($found);
        } else {
            echo '// No jQueryUI translations for '.Localization::activeLocale();
        }
    }
    public static function getTranslatorJavascript($setResponseHeaders = true)
    {
        if ($setResponseHeaders) {
            static::sendJavascriptHeader();
        }
        ?>
ccmTranslator.setI18NDictionart({
  AskDiscardDirtyTranslation: <?php echo json_encode(t("The current item has changed.\nIf you proceed you will lose your changes.\n\nDo you want to proceed anyway?"))?>,
  Comments: <?php echo json_encode(t('Comments'))?>,
  Context: <?php echo json_encode(t('Context'))?>,
  ExamplePH: <?php echo json_encode(t('Example: %s'))?>,
  Filter: <?php echo json_encode(t('Filter'))?>,
  Original_String: <?php echo json_encode(t('Original String'))?>,
  Please_fill_in_all_plurals: <?php echo json_encode(t('Please fill-in all plural forms'))?>,
  Plural_Original_String: <?php echo json_encode(t('Plural Original String'))?>,
  References: <?php echo json_encode(t('References'))?>,
  Save_and_Continue: <?php echo json_encode(t('Save & Continue'))?>,
  Search_for_: <?php echo json_encode(t('Search for...'))?>,
  Search_in_contexts: <?php echo json_encode(t('Search in contexts'))?>,
  Search_in_originals: <?php echo json_encode(t('Search in originals'))?>,
  Search_in_translations: <?php echo json_encode(t('Search in translations'))?>,
  Show_approved: <?php echo json_encode(t('Show approved'))?>,
  Show_translated: <?php echo json_encode(t('Show translated'))?>,
  Show_unapproved: <?php echo json_encode(t('Show unapproved'))?>,
  Show_untranslated: <?php echo json_encode(t('Show untranslated'))?>,
  Singular_Original_String: <?php echo json_encode(t('Singular Original String'))?>,
  Toggle_Dropdown: <?php echo json_encode(t('Toggle Dropdown'))?>,
  TAB: <?php echo json_encode(t('[TAB] Forward'))?>,
  TAB_SHIFT: <?php echo json_encode(t('[SHIFT]+[TAB] Backward'))?>,
  Translate: <?php echo json_encode(t('Translate'))?>,
  Translation: <?php echo json_encode(t('Translation'))?>,
  PluralNames: {
    zero: <?php echo json_encode(tc('PluralCase', 'Zero'))?>,
    one: <?php echo json_encode(tc('PluralCase', 'One'))?>,
    two: <?php echo json_encode(tc('PluralCase', 'Two'))?>,
    few: <?php echo json_encode(tc('PluralCase', 'Few'))?>,
    many: <?php echo json_encode(tc('PluralCase', 'Many'))?>,
    other: <?php echo json_encode(tc('PluralCase', 'Other'))?>
  }
});<?php

    }
    public static function getDropzoneJavascript($setResponseHeaders = true)
    {
        if ($setResponseHeaders) {
            static::sendJavascriptHeader();
        }
        ?>
Dropzone.prototype.defaultOptions.dictDefaultMessage = <?php echo json_encode(t('Drop files here to upload'))?>;
Dropzone.prototype.defaultOptions.dictFallbackMessage = <?php echo json_encode(t("Your browser does not support drag'n'drop file uploads."))?>;
Dropzone.prototype.defaultOptions.dictFallbackText = <?php echo json_encode(t('Please use the fallback form below to upload your files like in the olden days.'))?>;
    <?php

    }
    public static function getConversationsJavascript($setResponseHeaders = true)
    {
        if ($setResponseHeaders) {
            static::sendJavascriptHeader();
        }
        ?>
jQuery.fn.concreteConversation.localize({
  Confirm_remove_message: <?php echo json_encode(t('Remove this message? Replies to it will not be removed'))?>,
  Confirm_mark_as_spam: <?php echo json_encode(t('Are you sure you want to flag this message as spam?'))?>,
  Warn_currently_editing: <?php echo json_encode(t('Please complete or cancel the current message editing session before editing this message.'))?>,
  Unspecified_error_occurred: <?php echo json_encode(t('An unspecified error occurred.'))?>,
  Error_deleting_message: <?php echo json_encode(t('Something went wrong while deleting this message, please refresh and try again.'))?>,
  Error_flagging_message: <?php echo json_encode(t('Something went wrong while flagging this message, please refresh and try again.'))?>
});
jQuery.fn.concreteConversationAttachments.localize({
  Too_many_files: <?php echo json_encode(t('Too many files'))?>,
  Invalid_file_extension: <?php echo json_encode(t('Invalid file extension'))?>,
  Max_file_size_exceeded: <?php echo json_encode(t('Max file size exceeded'))?>,
  Error_deleting_attachment: <?php echo json_encode(t('Something went wrong while deleting this attachment, please refresh and try again.'))?>,
  Confirm_remove_attachment: <?php echo json_encode(t('Remove this attachment?'))?>
});
        <?php

    }
}
