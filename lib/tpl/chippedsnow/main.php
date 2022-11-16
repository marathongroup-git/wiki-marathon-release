<?php
/**
 * DokuWiki Chipped Snow Template
 * Based on the starter template
 *
 * @link     http://dokuwiki.org/template:chippedsnow
 * @author   desbest <afaninthehouse@gmail.com>
 * @license  GPL 2 (http://www.gnu.org/licenses/gpl.html)
 */

if (!defined('DOKU_INC')) die(); /* must be run from within DokuWiki */
@require_once(dirname(__FILE__).'/tpl_functions.php'); /* include hook for template functions */
header('X-UA-Compatible: IE=edge,chrome=1');

$showTools = !tpl_getConf('hideTools') || ( tpl_getConf('hideTools') && !empty($_SERVER['REMOTE_USER']) );
$showSidebar = page_findnearest($conf['sidebar']) && ($ACT=='show');
?><!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php echo $conf['lang'] ?>"
  lang="<?php echo $conf['lang'] ?>" dir="<?php echo $lang['direction'] ?>" class="no-js">
<head>
    <meta charset="UTF-8" />
    <title><?php tpl_pagetitle() ?> [<?php echo strip_tags($conf['title']) ?>]</title>
    <script>(function(H){H.className=H.className.replace(/\bno-js\b/,'js')})(document.documentElement)</script>
    <?php tpl_metaheaders() ?>
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <?php echo tpl_favicon(array('favicon', 'mobile')) ?>
    <?php tpl_includeFile('meta.html') ?>

</head>

<body>

    <div id="dokuwiki__top" class="container site <?php echo tpl_classes(); ?> <?php echo ($showSidebar) ? 'hasSidebar' : ''; ?>">
        
        <!-- Header -->
        <?php tpl_includeFile('header.html') ?>
        <header id="top">
             <!-- BREADCRUMBS -->
            <?php if($conf['breadcrumbs']){ ?>
                <div class="breadcrumbs"><?php tpl_breadcrumbs() ?></div>
            <?php } ?>
            <?php if($conf['youarehere']){ ?>
                <div class="breadcrumbs"><?php tpl_youarehere() ?></div>
            <?php } ?>


            <h1><?php tpl_link(wl(),$conf['title'],'accesskey="h" title="[H]"') ?></h1>
                <?php if ($conf['tagline']): ?>
                    <p class="claim"><?php echo $conf['tagline'] ?></p>
                <?php endif ?>
             <?php /* how to insert logo instead (if no CSS image replacement technique is used):
                        upload your logo into the data/media folder (root of the media manager) and replace 'logo.png' accordingly:
                        tpl_link(wl(),'<img src="'.ml('logo.png').'" alt="'.$conf['title'].'" />','id="dokuwiki__top" accesskey="h" title="[H]"') */ ?>
                        <ul class="a11y skip">
                    <li><a href="#dokuwiki__content"><?php echo $lang['skip_to_content'] ?></a></li>
                </ul>
        </header>
        

        <div class="row flex">
        <!-- Main Body -->  
        <section id="sidebar">

            <?php tpl_searchform() ?>

            <!-- The checkbox input & label partner -->
            <input type="checkbox" class="hide" id="menu-toggle">
            <label class="menutoggle" for="menu-toggle">Menu</label>

            <div id="navcontainer">
            <ul id="navlist">
            <!-- ********** ASIDE ********** -->
            <?php if ($showSidebar): ?>
                    <?php tpl_includeFile('sidebarheader.html') ?>
                    <?php tpl_include_page($conf['sidebar'], 1, 1) /* includes the nearest sidebar page */ ?>
                    <?php tpl_includeFile('sidebarfooter.html') ?>
                    <div class="clearer"></div>
            <?php endif; ?>

            <!-- SITE TOOLS -->
            <h3 class="a11y"><?php echo $lang['site_tools'] ?></h3>
            
                <?php tpl_toolsevent('sitetools', array(
                    'recent'    => tpl_action('recent', 1, 'li', 1),
                    'media'     => tpl_action('media', 1, 'li', 1),
                    'index'     => tpl_action('index', 1, 'li', 1),
                )); ?>

           <!-- USER TOOLS -->
            <?php if ($conf['useacl'] && $showTools): ?>
            <h3 class="a11y"><?php echo $lang['user_tools'] ?></h3>
                <?php
                    if (!empty($_SERVER['REMOTE_USER'])) {
                        echo '<li class="user">';
                        tpl_userinfo(); /* 'Logged in as ...' */
                        echo '</li>';
                    }
                ?>
                <?php /* the optional second parameter of tpl_action() switches between a link and a button,
                         e.g. a button inside a <li> would be: tpl_action('edit', 0, 'li') */
                ?>
                <?php tpl_toolsevent('usertools', array(
                    'admin'     => tpl_action('admin', 1, 'li', 1),
                    'userpage'  => _tpl_action('userpage', 1, 'li', 1),
                    'profile'   => tpl_action('profile', 1, 'li', 1),
                    'register'  => tpl_action('register', 1, 'li', 1),
                    'login'     => tpl_action('login', 1, 'li', 1),
                )); ?>
            <?php endif ?>

            </ul>
            </div>
            
        </section>        
        <article id="maincolumn" class="sparewidth">

            <?php html_msgarea() /* occasional error and info messages on top of the page */ ?>

            <ul class="horimenu">
                  <!-- PAGE ACTIONS -->
            <?php if ($showTools): ?>
            <h3 class="a11y"><?php echo $lang['page_tools'] ?></h3>
                <?php tpl_toolsevent('pagetools', array(
                    'edit'      => tpl_action('edit', 1, 'li', 1),
                    'discussion'=> _tpl_action('discussion', 1, 'li', 1),
                    'revisions' => tpl_action('revisions', 1, 'li', 1),
                    'backlink'  => tpl_action('backlink', 1, 'li', 1),
                    'subscribe' => tpl_action('subscribe', 1, 'li', 1),
                    'revert'    => tpl_action('revert', 1, 'li', 1),
                    //'top'       => tpl_action('top', 1, 'li', 1),
                )); ?>
            <?php endif; ?>
            </ul>


            <div id="tpl__content" class="contenthere white">
                <?php tpl_flush() /* flush the output buffer */ ?>
                <?php tpl_includeFile('pageheader.html') ?>

                <div class="page">
                    <!-- wikipage start -->
                    <?php tpl_content() /* the main content */ ?>
                    <!-- wikipage stop -->
                    <div class="clearer"></div>
                </div>

                <?php tpl_flush() ?>
                <?php tpl_includeFile('pagefooter.html') ?>          
            </div>
        </article>

        

        </div>
        <div class="footer white">
            <a href="http://desbest.com" target="_blank">Chipped Snow theme by desbest</a>
             <div class="doc"><?php tpl_pageinfo() /* 'Last modified' etc */ ?></div>
             <?php tpl_license('button') /* content license, parameters: img=*badge|button|0, imgonly=*0|1, return=*0|1 */ ?>
        </div>
        <?php tpl_includeFile('footer.html') ?>
        <div class="no"><?php tpl_indexerWebBug() /* provide DokuWiki housekeeping, required in all templates */ ?></div>
    </div><!-- close row and flex -->

    <?php /* with these Conditional Comments you can better address IE issues in CSS files,
             precede CSS rules by #IE8 for IE8 (div closes at the bottom) */ ?>
    <!--[if lte IE 8 ]><div id="IE8"><![endif]-->

    <?php /* the "dokuwiki__top" id is needed somewhere at the top, because that's where the "back to top" button/link links to */ ?>
    <?php /* tpl_classes() provides useful CSS classes; if you choose not to use it, the 'dokuwiki' class at least
             should always be in one of the surrounding elements (e.g. plugins and templates depend on it) */ ?>

        <!-- ********** HEADER ********** -->



    
    <script defer type="text/javascript" src="<?php echo tpl_basedir();?>/less-1.1.3.min.js"></script>
    <script defer type="text/javascript" src="<?php echo tpl_basedir();?>/mobileinputsize.js"></script>
</body>
</html>
