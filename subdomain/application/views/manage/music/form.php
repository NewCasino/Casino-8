<?php defined('SYSPATH') OR die('No direct access allowed.') ?>
<script language="javascript" type="text/javascript">
/* <![CDATA[ */
$(document).ready(function(){	
	$('form').bind('submit', function(){
		var input = $('.form :input');
		var flag = false;
		for (var i = 0; i < input.length; i++) {
			if ($(input[i]).attr('required') && $(input[i]).val() == '') {				
				$(input[i]).parent().find('span').removeClass('hide').html('Обязательное поле').addClass('up-box3');
				flag = true;				
			}
		}
		if ($('input[name=music[id]]').val() == '' && $('input[name=file]').val() == '')
		{
			$('input[name=file]').parent().find('span').removeClass('hide').html('Обязательное поле').addClass('up-box3');
			flag = true;
		}
		if (flag) {
			$('.button2 span').html('Возникли ошибки, проверте форму').removeClass('hide').addClass('up-box3');
			return false;
		}
	});
	$('.button2 input[name=cancel]').bind('click', function(){
		$('.form').fadeOut();		
	});
});
/* ]]> */
</script>
<form action="/manage/music/save" method="post" enctype="multipart/form-data"> 
<h2><?php echo Kohana::lang('music.edit') ?></h2>
<div class="tabs">
    <ul>
        <li class="active" tab="main"><a href="javascript:;" title="Главное">Главное</a></li>								        
    </ul>
    <br class="clearfloat" />
</div>
<br class="clearfloat" />
<div class="bg">
    <div class="in-bg" tab="main">
        <table cellpadding="0" cellspacing="0" class="t1">
            <tr valign="top">
                <td class="w02">
                	<input type="hidden" name="music[id]" value="<?php if (isset($data->item_music->id)) echo $data->item_music->id ?>" />                	
                	<p> <?php echo Kohana::lang('music.track') ?> <br />
                        <input type="text" class="f03" required="true" name="music[track]" value="<?php if (isset($data->item_music->track)) echo $data->item_music->track ?>" />								                        
                        <span class="hide"></span><br />
                        <font class="description"><?php echo Kohana::lang('music.track_description') ?></font>
                    </p><br />
                    <p> <?php echo Kohana::lang('music.artist') ?> <br />
                        <input type="text" class="f03" required="true" name="music[artist]" value="<?php if (isset($data->item_music->artist)) echo $data->item_music->artist ?>" />								                        
                        <span class="hide"></span><br />
                        <font class="description"><?php echo Kohana::lang('music.artist_description') ?></font> 
                    </p><br />
                </td>                   
                <td class="w01">
                	<p> <?php echo Kohana::lang('music.file') ?> <br />
                		<input type="file" name="file" />
	                    <span class="hide"></span><br />
                        <font class="description"><?php echo Kohana::lang('music.file_description') ?></font>
                        <br />
                        <?php if (isset($data->item_music->file)) echo '<a href="/media/mp3/'.$data->item_music->file.'"><b>'.$data->item_music->file.'</b></a>' ?>
	                </p><br />
                </td>
            </tr>
        </table>
        <div class="button2"> 
	    	<input type="submit" value="Добавить" /> <input type="button" name="cancel" value="Отменить" />
	    	<br /><span class="hide"></span>
	    </div>
    </div>
</div> 
</form>								