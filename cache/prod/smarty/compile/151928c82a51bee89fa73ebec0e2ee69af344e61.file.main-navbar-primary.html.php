<?php /* Smarty version Smarty-3.1.19-dev, created on 2016-04-11 15:56:54
         compiled from "C:\xampp\htdocs\thelia\local\modules\HookNavigation\templates\frontOffice\default\main-navbar-primary.html" */ ?>
<?php /*%%SmartyHeaderCode:13996570bad261e73f3-73000007%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '151928c82a51bee89fa73ebec0e2ee69af344e61' => 
    array (
      0 => 'C:\\xampp\\htdocs\\thelia\\local\\modules\\HookNavigation\\templates\\frontOffice\\default\\main-navbar-primary.html',
      1 => 1459491142,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13996570bad261e73f3-73000007',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'CHILD_COUNT' => 0,
    'URL' => 0,
    'TITLE' => 0,
    'ID' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19-dev',
  'unifunc' => 'content_570bad26208cf0_35066771',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_570bad26208cf0_35066771')) {function content_570bad26208cf0_35066771($_smarty_tpl) {?><nav class="navbar navbar-default nav-main" role="navigation" itemscope itemtype="http://schema.org/SiteNavigationElement">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-primary">
                <span class="sr-only"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['intl'][0][0]->translate(array('l'=>"Toggle navigation",'d'=>"hooknavigation.fo.default"),$_smarty_tpl);?>
</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand visible-xs" href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['navigate'][0][0]->navigateToUrlFunction(array('to'=>"index"),$_smarty_tpl);?>
"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['intl'][0][0]->translate(array('l'=>"Categories",'d'=>"hooknavigation.fo.default"),$_smarty_tpl);?>
</a>
        </div>
        <div class="collapse navbar-collapse" id="navbar-primary">
            <ul class="nav navbar-nav navbar-categories">
                <li><a href="<?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['navigate'][0][0]->navigateToUrlFunction(array('to'=>"index"),$_smarty_tpl);?>
" class="home"><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['intl'][0][0]->translate(array('l'=>"Home",'d'=>"hooknavigation.fo.default"),$_smarty_tpl);?>
</a></li>
                <?php $_smarty_tpl->smarty->_tag_stack[] = array('loop', array('type'=>"category",'name'=>"category.navigation",'parent'=>"0",'need_count_child'=>"yes")); $_block_repeat=true; echo $_smarty_tpl->smarty->registered_plugins['block']['loop'][0][0]->theliaLoop(array('type'=>"category",'name'=>"category.navigation",'parent'=>"0",'need_count_child'=>"yes"), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>

                <?php if ($_smarty_tpl->tpl_vars['CHILD_COUNT']->value>0) {?>
                    <li class="dropdown">
                        <a href="<?php echo TheliaSmarty\Template\SmartyParser::theliaEscape($_smarty_tpl->tpl_vars['URL']->value,$_smarty_tpl);?>
" class="dropdown-toggle"><?php echo TheliaSmarty\Template\SmartyParser::theliaEscape($_smarty_tpl->tpl_vars['TITLE']->value,$_smarty_tpl);?>
</a>
                        <ul class="dropdown-menu" role="menu">
                            <?php $_smarty_tpl->smarty->_tag_stack[] = array('loop', array('type'=>"category",'name'=>"sub-cat",'parent'=>((string)$_smarty_tpl->tpl_vars['ID']->value))); $_block_repeat=true; echo $_smarty_tpl->smarty->registered_plugins['block']['loop'][0][0]->theliaLoop(array('type'=>"category",'name'=>"sub-cat",'parent'=>((string)$_smarty_tpl->tpl_vars['ID']->value)), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>

                                <li><a href="<?php echo TheliaSmarty\Template\SmartyParser::theliaEscape($_smarty_tpl->tpl_vars['URL']->value,$_smarty_tpl);?>
"><?php echo TheliaSmarty\Template\SmartyParser::theliaEscape($_smarty_tpl->tpl_vars['TITLE']->value,$_smarty_tpl);?>
</a></li>    
                            <?php $_block_content = ob_get_clean(); $_block_repeat=false; echo $_smarty_tpl->smarty->registered_plugins['block']['loop'][0][0]->theliaLoop(array('type'=>"category",'name'=>"sub-cat",'parent'=>((string)$_smarty_tpl->tpl_vars['ID']->value)), $_block_content, $_smarty_tpl, $_block_repeat); } array_pop($_smarty_tpl->smarty->_tag_stack);?>

                        </ul>
                    </li>
                <?php } else { ?>
                    <li><a href="<?php echo TheliaSmarty\Template\SmartyParser::theliaEscape($_smarty_tpl->tpl_vars['URL']->value,$_smarty_tpl);?>
"><?php echo TheliaSmarty\Template\SmartyParser::theliaEscape($_smarty_tpl->tpl_vars['TITLE']->value,$_smarty_tpl);?>
</a></li>
                <?php }?>
                <?php $_block_content = ob_get_clean(); $_block_repeat=false; echo $_smarty_tpl->smarty->registered_plugins['block']['loop'][0][0]->theliaLoop(array('type'=>"category",'name'=>"category.navigation",'parent'=>"0",'need_count_child'=>"yes"), $_block_content, $_smarty_tpl, $_block_repeat); } array_pop($_smarty_tpl->smarty->_tag_stack);?>

            </ul>
        </div>
    </div>
</nav>

<?php }} ?>
