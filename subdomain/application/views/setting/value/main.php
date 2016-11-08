<?php defined('SYSPATH') OR die('No direct access allowed.') ?>
<?php echo $template->meta ?>
<script language="javascript" type="text/javascript">
/* <![CDATA[ */
$(document).ready(function(){
	function jsStringReplace(text,searchString, replaceString)
	{
		lengthSearchString=searchString.length;
		lengthReplaceString=replaceString.length;
		rezultText=text;
		start_poz=0;//начальная позиция с которой начинаем поиск заданной подстроки
		while ((poz=rezultText.indexOf(searchString,start_poz))!=-1)
		{
			firstPart=rezultText.substring(0,poz);
			lengthRezultText=rezultText.length;
			endPart=rezultText.substring(poz+lengthSearchString, lengthRezultText );
			rezultText=firstPart+replaceString+endPart;
			start_poz=poz+lengthReplaceString;
		}
		return (rezultText);
	}

	function jsCodeHtmlChars(r)
	{
		r=jsStringReplace(r,"&","&amp;");
		r=jsStringReplace(r,"<","&lt;");
		r=jsStringReplace(r,">","&gt;");

		r=jsStringReplace(r,"&#039","'");
		r=jsStringReplace(r,"&#039&#039","&quot;");
		return (r);
	}
			
	$('form').bind('submit', function(){
        $('textarea[name=google_analytics]').val(jsCodeHtmlChars($('textarea[name=google_analytics]').val()));
    });
});
/* ]]> */
</script>
<?php echo $template->header ?>
<?php echo $template->layer ?>
<?php echo $template->profile ?>
<div class="center">
    <div class="head">
	    <?php echo $template->logo ?>
	    <?php echo $template->top ?>
	    <?php echo $template->logout ?>
	    <?php echo $template->atack ?>
	</div>
    <div class="block">
        <div class="block-l">
            <div class="block-r">
                <?php echo $template->panel ?>
                <?php echo $template->quick ?>
            </div>
        </div>
    </div>
    <?php echo $template->switch ?>
    <div class="wrapper">
        <div class="wrapper-t">
            <div class="wrapper-b-l">
                <div class="wrapper-b-r">
                    <div class="container">
                        <div class="content">
                            <div class="main">
                                <?php echo $template->breadcrumps ?>
								<!-- BEGIN FORM -->                                
								<div class="desc">
								    <h2>Управление настройками</h2>
								    <p>В этом модуле вы сможете управлять настройками сайта. </p>
								</div>
								<form action="/setting/value/save" method="post"> 
                                    <br class="clearfloat" />
                                    <div class="bg">
                                        <div class="in-bg" tab="main">
                                            <table cellpadding="0" cellspacing="0" class="t1">
                                                <tr valign="top">
                                                    <td class="w02">
                                                        <p> <?php echo Kohana::lang('setting.url') ?> <br />
                                                            <input type="text" class="f03" required="true" name="url" value="<?php echo $data->list_value->url ?>" />                                                       
                                                            <span class="hide"></span><br />
                                                            <font class="description"></font>
                                                        </p><br />                    
                                                        <p> <?php echo Kohana::lang('setting.title') ?> <br />
                                                            <input type="text" class="f03" required="true" name="title" value="<?php echo $data->list_value->title ?>" />                                                       
                                                            <span class="hide"></span><br />
                                                            <font class="description"></font>
                                                        </p><br />
                                                        <p> <?php echo Kohana::lang('setting.description') ?> <br />
                                                            <textarea class="f04" name="description"><?php echo $data->list_value->description ?></textarea>                                                       
                                                            <span class="hide"></span><br />
                                                            <font class="description"></font>
                                                        </p><br />
                                                        <p> <?php echo Kohana::lang('setting.keywords') ?> <br />
                                                            <textarea class="f04" name="keywords"><?php echo $data->list_value->keywords ?></textarea>                                                       
                                                            <span class="hide"></span><br />
                                                            <font class="description"></font>
                                                        </p><br />
                                                        <p> <?php echo Kohana::lang('setting.google_analytics') ?> <br />
                                                            <textarea class="f04" name="google_analytics"><?php echo $data->list_value->google_analytics ?></textarea>                                                       
                                                            <span class="hide"></span><br />
                                                            <font class="description"></font>
                                                        </p><br />
                                                        <p> <?php echo Kohana::lang('setting.google_webmaster_tools') ?> <br />
                                                            <input type="text" class="f03" name="google_webmaster_tools" value="<?php print $data->list_value->google_webmaster_tools ?>"/>                                                       
                                                            <span class="hide"></span><br />
                                                            <font class="description"></font>
                                                        </p><br />
                                                    </td>                   
                                                    <td class="w01">
														<p> <?php echo Kohana::lang('setting.one_login') ?> <br />
                                                            <input type="radio" required="true" name="one_login" value="1" <?php if ($data->list_value->one_login == 1) echo 'checked="checked"' ?> />&nbsp;<b>Да</b>&nbsp;&nbsp;
                                                            <input type="radio" required="true" name="one_login" value="0" <?php if ($data->list_value->one_login == 0) echo 'checked="checked"' ?> />&nbsp;<b>Нет</b>                                                     
                                                            <span class="hide"></span><br />
                                                            <font class="description"></font>
                                                        </p><br />
                                                        <p> <?php echo Kohana::lang('setting.lang_id_default') ?> <br />
                                                        	<select name="lang_id_default">
                                                            	<option value="1" <?php if ($data->list_value->lang_id_default == 1) echo 'selected="selected"' ?>>Русский</option>
                                                            	<option value="2" <?php if ($data->list_value->lang_id_default == 2) echo 'selected="selected"' ?>>Английский</option>
                                                            </select>                                                       
                                                            <span class="hide"></span><br />
                                                            <font class="description"></font>
                                                        </p><br />
                                                        <p> <?php echo Kohana::lang('setting.currency') ?> <br />
                                                            <input type="text" class="f24" required="true" name="currency" value="<?php echo number_format($data->list_value->currency, 2, '.', '') ?>" />                                                       
                                                            <span class="hide"></span><br />
                                                            <font class="description"></font>
                                                        </p><br />
                                                        <p> <?php echo Kohana::lang('setting.demo_user_balance') ?> <br />
                                                            <input type="text" class="f24" required="true" name="demo_user_balance" value="<?php echo number_format($data->list_value->demo_user_balance, 2, '.', '') ?>" />                                                       
                                                            <span class="hide"></span><br />
                                                            <font class="description"></font>
                                                        </p><br />
                                                        <p> <?php echo Kohana::lang('setting.banking_limit_min_cash') ?> <br />
                                                            <input type="text" class="f24" required="true" name="banking_limit_min_cash" value="<?php echo number_format($data->list_value->banking_limit_min_cash, 2, '.', '') ?>" />                                                       
                                                            <span class="hide"></span><br />
                                                            <font class="description"></font>
                                                        </p><br />
                                                        <p> <?php echo Kohana::lang('setting.banking_limit_min_cash_bonus') ?> <br />
                                                            <input type="text" class="f24" required="true" name="banking_limit_min_cash_bonus" value="<?php echo number_format($data->list_value->banking_limit_min_cash_bonus, 2, '.', '') ?>" />                                                       
                                                            <span class="hide"></span><br />
                                                            <font class="description"></font>
                                                        </p><br />
                									</td>
                                                </tr>
                                            </table>
                                            <div class="button2"> 
                                                <input type="submit" value="Сохранить" />
                                                <br /><span class="hide"></span>
                                            </div>
                                        </div>    
                                    </div> 
                                </form>
								<!-- END FORM -->
                            </div>
                        </div>
                        <?php echo $template->left ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php echo $template->foot ?>
</div>
<?php echo $template->footer ?>