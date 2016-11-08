<?php defined('SYSPATH') OR die('No direct access allowed.'); ?>

<?php echo $template->meta; ?>
<?php echo $template->header; ?>
<?php echo $template->layer; ?>
<?php echo $template->profile; ?>

<div class="center">
    <div class="head">
    
	    <?php echo $template->logo; ?>
	    <?php echo $template->top; ?>
	    <?php echo $template->logout; ?>
	    <?php echo $template->atack; ?>
	    
	</div>
	
    <div class="block">
        <div class="block-l">
            <div class="block-r">
            
                <?php echo $template->panel; ?>
                <?php echo $template->quick; ?>
                
            </div>
        </div>
    </div>
    
    <?php echo $template->switch; ?>
    
    <div class="wrapper">
        <div class="wrapper-t">
            <div class="wrapper-b-l">
                <div class="wrapper-b-r">
                    <div class="container">
                        <div class="content">
                            <div class="main">
                            
                                <?php echo $template->breadcrumps; ?>
                                
								<!-- BEGIN FORM -->                                
								<div class="desc">
								    <h2>Новое казино</h2>
								    <p> Each pool of clusters is optimized for a specific task (web services, email, databases and more). With multiple servers handling each task, redundancy is built-in and your sites never have to fight for the resources of a single server. </p>
								</div>
								<div class="pad">
								    <div class="button">
								        <div class="button-r"> <a href="#" title="#"><img src="/media/images/button1.png" alt="#" /></a> </div>
								    </div>
								    <!--
								    <div class="button">
								        <div class="button-r"> <a href="#" title="#"><img src="/media/images/button2.png" alt="#" /></a><a href="#" title="#"><img src="/media/images/button3.png" alt="#" /></a> </div>
								    </div>
								    -->
								    <br class="clearfloat" />
								</div>
								<h2>Добавить новый аккаунт</h2>
								<div class="tabs">
								    <ul>
								        <li class="active">Главное</li>
								        <li><a href="#" title="#">Дополнительно</a></li>
								        <li class="last"><a href="#" title="#">Настройки</a></li>
								    </ul>
								    <br class="clearfloat" />
								</div>
								<br class="clearfloat" />
								<div class="bg">
								    <div class="in-bg">
								        <table cellpadding="0" cellspacing="0" class="t1">
								            <tr valign="top">
								                <td class="w02">
								                	
								                	<input type="hidden" name="games.id" value="<?php if (isset($data->games->id)) echo $data->games->id; ?>" />
								                	
								                	<p> Название <br />
								                        <input type="text" class="f03" name="games.title" value="<?php if (isset($data->games->title)) echo $data->games->title; ?>" />
								                        <span class="up-box hide">Разрешено</span> 
								                    </p>
								                    
								                    <p> Сортировать <br />
								                        <input type="text" class="f03" name="games.sort" value="<?php if (isset($data->games->title)) echo $data->games->sort; ?>" />
								                        <span class="up-box hide">Разрешено</span> 
								                    </p>
								                    
								                    <?php foreach ($data->games_configs as $row): ?>
								                    	<?php if ($row->name): ?>
								                    	<p> <?php echo $row->name; ?> <br />
									                        <input type="text" class="f03" name="games_config.<?php echo $row->name; ?>" value="<?php if ($row->value_int) echo $row->value_int; ?>" />
									                        <span class="up-box hide">Разрешено</span> 
									                    </p>
								                    	<?php endif; ?>
								                    <?php endforeach; ?>
								                    
								                    <!-- 
								                    <p> wildchar_win_multiplication <br />
								                        <input type="text" class="f03" name="games_config.wildchar_win_multiplication" value="" />
								                        <span class="up-box hide">Разрешено</span> 
								                    </p>
								                    
								                    <p> double_4_chance <br />
								                        <input type="text" class="f03" name="games_config.double_4_chance" value="" />
								                        <span class="up-box hide">Разрешено</span> 
								                    </p>
								                     -->
								                	<!-- 
								                	<p> Название <br />
								                        <input type="text" class="f03" />
								                        <span class="up-box">Разрешено</span> 
								                    </p>
								                    <p> 
								                    	Описание <br />
								                        <textarea class="f04"></textarea>
								                    </p>
								                    <p> Юридический адрес <br />
								                    	<textarea class="f09"></textarea>
								                    </p>
								                    <p> Юридический адрес <br />
								                        <textarea class="f09"></textarea>
								                    </p>
								                	<p> Главный администратор <br />
								                        <input type="text" class="f05" />
								                        <span class="up-box2">Неправильный формат</span> 
								                    </p>
								                    <p> Номер телефона <br />
								                        <input type="text" class="f06" />
								                        <span class="up-box3">Обязательное поле</span> 
								                    </p>
								                    <p> Юридический адрес <br />
								                        <textarea class="f09"></textarea>
								                    </p>
								                    <p> Доступ <br />
								                        <select class="f01">
								                            <option>Полный</option>
								                        </select>
								                    </p>
								                    <div class="ava"> <strong>Аватар администратора</strong> <br />
								                        <img src="/media/images/ava.jpg" alt="#" /><a href="#" title="#"><img src="/media/images/button10.png" alt="#" /></a>
								                        <p> <input type="file" /> </p>
								                    </div>
								                     -->       
								                </td>                   
								                <td class="w01">
								                	<p> Категория <br />
								                	<select name="games.categories_id">
								                	<?php foreach ($data->categories as $row): ?>
								                    	<option <?php if ($row->id === $data->games->categories_id) echo 'selected="selected"'; ?> value="<?php echo $row->id; ?>"><?php echo $row->title; ?></option>                        
								                    <?php endforeach; ?>
								                    </select>
								                    </p>
								                    
								                    <?php foreach ($data->games_banks as $row): ?>
								                    	<p><?php echo $row->type; ?> <br />
								                    	<select name="banks.<?php echo $row->type; ?>">
								                    	<?php foreach ($data->banks as $row1): ?>
								                    		<?php if ($row->type === $row1->type): ?>
								                    		<option <?php if ($row->banks_id === $row1->id) echo 'selected="selected"'; ?> value="<?php echo $row1->id; ?>"><?php echo $row1->title; ?></option>
								                    		<?php endif; ?>
								                    	<?php endforeach; ?>
								                    	</select>
								                    	</p>
								                    <?php endforeach; ?>
								                </td>
								            </tr>
								        </table>
								        <div class="button2"> 
								        	 <input type="button" name="submit" value="Отправить" /> <input type="button" name="cancel" value="Отменить" />
								       	</div>
								    </div>
								</div>
								<!-- END FORM -->


                                <?php echo $template->list; ?>
                                
                            </div>
                        </div>
                        
                        <?php echo $template->left; ?>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <?php echo $template->foot; ?>
    
</div>

<?php echo $template->footer; ?>