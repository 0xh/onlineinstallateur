<?php /* Smarty version Smarty-3.1.19-dev, created on 2016-04-11 16:06:23
         compiled from "C:\xampp\htdocs\thelia\local\modules\HookNavigation\templates\frontOffice\default\main-footer-body.html" */ ?>
<?php /*%%SmartyHeaderCode:15011570baf5f16cc86-05000273%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a29ee82a289b2ddb9c4d2e2d52c3d119432679ca' => 
    array (
      0 => 'C:\\xampp\\htdocs\\thelia\\local\\modules\\HookNavigation\\templates\\frontOffice\\default\\main-footer-body.html',
      1 => 1459491142,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '15011570baf5f16cc86-05000273',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'bodyFolderId' => 0,
    'URL' => 0,
    'TITLE' => 0,
    'CHAPO' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19-dev',
  'unifunc' => 'content_570baf5f17e4e2_34199280',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_570baf5f17e4e2_34199280')) {function content_570baf5f17e4e2_34199280($_smarty_tpl) {?><?php $_smarty_tpl->smarty->_tag_stack[] = array('ifloop', array('rel'=>"blog.articles")); $_block_repeat=true; echo $_smarty_tpl->smarty->registered_plugins['block']['ifloop'][0][0]->theliaIfLoop(array('rel'=>"blog.articles"), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>

<ul>
    <?php $_smarty_tpl->smarty->_tag_stack[] = array('loop', array('type'=>"content",'name'=>"blog.articles",'folder'=>$_smarty_tpl->tpl_vars['bodyFolderId']->value,'limit'=>3)); $_block_repeat=true; echo $_smarty_tpl->smarty->registered_plugins['block']['loop'][0][0]->theliaLoop(array('type'=>"content",'name'=>"blog.articles",'folder'=>$_smarty_tpl->tpl_vars['bodyFolderId']->value,'limit'=>3), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>

    <li>
        <a href="<?php echo TheliaSmarty\Template\SmartyParser::theliaEscape($_smarty_tpl->tpl_vars['URL']->value,$_smarty_tpl);?>
">
            <h4 class="block-subtitle"><?php echo TheliaSmarty\Template\SmartyParser::theliaEscape($_smarty_tpl->tpl_vars['TITLE']->value,$_smarty_tpl);?>
</h4>
            <p><?php echo TheliaSmarty\Template\SmartyParser::theliaEscape($_smarty_tpl->tpl_vars['CHAPO']->value,$_smarty_tpl);?>
</p>
        </a>
    </li>
    <?php $_block_content = ob_get_clean(); $_block_repeat=false; echo $_smarty_tpl->smarty->registered_plugins['block']['loop'][0][0]->theliaLoop(array('type'=>"content",'name'=>"blog.articles",'folder'=>$_smarty_tpl->tpl_vars['bodyFolderId']->value,'limit'=>3), $_block_content, $_smarty_tpl, $_block_repeat); } array_pop($_smarty_tpl->smarty->_tag_stack);?>

</ul>
<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo $_smarty_tpl->smarty->registered_plugins['block']['ifloop'][0][0]->theliaIfLoop(array('rel'=>"blog.articles"), $_block_content, $_smarty_tpl, $_block_repeat); } array_pop($_smarty_tpl->smarty->_tag_stack);?>

<?php $_smarty_tpl->smarty->_tag_stack[] = array('elseloop', array('rel'=>"blog.articles")); $_block_repeat=true; echo $_smarty_tpl->smarty->registered_plugins['block']['elseloop'][0][0]->theliaElseloop(array('rel'=>"blog.articles"), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>

<ul>
    <li><?php echo $_smarty_tpl->smarty->registered_plugins[Smarty::PLUGIN_FUNCTION]['intl'][0][0]->translate(array('l'=>"No articles currently",'d'=>"hooknavigation.fo.default"),$_smarty_tpl);?>
</li>
</ul>
<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo $_smarty_tpl->smarty->registered_plugins['block']['elseloop'][0][0]->theliaElseloop(array('rel'=>"blog.articles"), $_block_content, $_smarty_tpl, $_block_repeat); } array_pop($_smarty_tpl->smarty->_tag_stack);?>
<?php }} ?>
