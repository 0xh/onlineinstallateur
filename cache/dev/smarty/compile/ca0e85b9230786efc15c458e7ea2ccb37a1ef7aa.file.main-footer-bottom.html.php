<?php /* Smarty version Smarty-3.1.19-dev, created on 2016-04-15 12:32:40
         compiled from "C:\Development\programs\xampp\htdocs\heizfabrik\local\modules\HookNavigation\templates\frontOffice\default\main-footer-bottom.html" */ ?>
<?php /*%%SmartyHeaderCode:170975710c3486718e4-32302218%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ca0e85b9230786efc15c458e7ea2ccb37a1ef7aa' => 
    array (
      0 => 'C:\\Development\\programs\\xampp\\htdocs\\heizfabrik\\local\\modules\\HookNavigation\\templates\\frontOffice\\default\\main-footer-bottom.html',
      1 => 1460457121,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '170975710c3486718e4-32302218',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'bottomFolderId' => 0,
    'URL' => 0,
    'TITLE' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.19-dev',
  'unifunc' => 'content_5710c348677fc3_54244261',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5710c348677fc3_54244261')) {function content_5710c348677fc3_54244261($_smarty_tpl) {?><nav class="nav-footer" role="navigation">
    <ul class="list-unstyled list-inline">
        <?php $_smarty_tpl->smarty->_tag_stack[] = array('loop', array('name'=>"footer_links",'type'=>"content",'folder'=>$_smarty_tpl->tpl_vars['bottomFolderId']->value,'limit'=>4)); $_block_repeat=true; echo $_smarty_tpl->smarty->registered_plugins['block']['loop'][0][0]->theliaLoop(array('name'=>"footer_links",'type'=>"content",'folder'=>$_smarty_tpl->tpl_vars['bottomFolderId']->value,'limit'=>4), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>

        <li><a href="<?php echo TheliaSmarty\Template\SmartyParser::theliaEscape($_smarty_tpl->tpl_vars['URL']->value,$_smarty_tpl);?>
"><?php echo TheliaSmarty\Template\SmartyParser::theliaEscape($_smarty_tpl->tpl_vars['TITLE']->value,$_smarty_tpl);?>
</a></li>
        <?php $_block_content = ob_get_clean(); $_block_repeat=false; echo $_smarty_tpl->smarty->registered_plugins['block']['loop'][0][0]->theliaLoop(array('name'=>"footer_links",'type'=>"content",'folder'=>$_smarty_tpl->tpl_vars['bottomFolderId']->value,'limit'=>4), $_block_content, $_smarty_tpl, $_block_repeat); } array_pop($_smarty_tpl->smarty->_tag_stack);?>

    </ul>
</nav><?php }} ?>
