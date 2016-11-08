<?php defined('SYSPATH') or die('No direct access allowed.'); 

return array
(
	'list' => array /* tabs */
	(
		'name' => 'tab1',
		'title' => 'Tab1',
		'sidebar' => array 
		(
			
		),
	),
	'form' => array /* tabs */
	(
		'name' => 'tab1',
		'title' => 'Tab1',
		'sidebar' => array 
		(
			'left' => array
			(
				array
				(
					'name' => 'id',
					'title' => Kohana::lang('fields.id.title'),
					'description' => Kohana::lang('fields.id.description'),
					'view' => array
					(
						'form' => array
						(
							'required' => false,
							'type' => 'hidden',
							'tag' => 'input',
							'style' => '', 	
							'value' => '',
						),
					),
				),
				array
				(
					'name' => 'checkbox',
					'title' => Kohana::lang('fields.checkbox.title'),
					'description' => Kohana::lang('fields.checkbox.description'),
					'view' => array
					(
						'form' => array
						(
							'required' => true,
							'type' => 'checkbox',
							'tag' => 'input',
							'style' => '', 	
							'value' => '',
						),
					),
				),
				array
				(
					'name' => 'text',
					'title' => Kohana::lang('fields.text.title'),
					'description' => Kohana::lang('fields.text.description'),
					'view' => array
					(
						'form' => array
						(
							'required' => true,
							'type' => 'text',
							'tag' => 'input',
							'style' => '', 	
							'value' => '0',
						),
					),
				),
				array
				(
					'name' => 'textarea',
					'title' => Kohana::lang('fields.textarea.title'),
					'description' => Kohana::lang('fields.textarea.description'),
					'view' => array
					(
						'form' => array
						(
							'title' => Kohana::lang('fields.mytextarea.title'),
							'description' => Kohana::lang('fields.mytextarea.description'),
							'required' => true,
							'type' => 'text',
							'tag' => 'textarea',
							'style' => 'text1', 	
							'value' => 'Example description text',
						),
						'list' => array
						(
							'filter' => true,
							'output_limit' => '50',
							'use_html' => true,	
						),
					),
				),
				array
				(
					'name' => 'select',
					'title' => Kohana::lang('fields.select.title'),
					'description' => Kohana::lang('fields.select.description'),
					'view' => array
					(
						'form' => array
						(
							'required' => false,
							'type' => 'select',
							'tag' => 'textarea',
							'style' => 'text1', 	
							'value' => 'Example description text',
							'items' => array
							(
								'1' => '1',
								'2' => '2',
								'3' => '3',
							),
						),
						'list' => array
						(
							'filter' => true,
							'filter_items' => array
							(
								'1' => 'some 1',
								'2' => 'some 2',
								'3' => 'some 3',
							),
							'output_related_items' => array
							(
								'1' => 'some 1',
								'2' => 'some 2',
								'3' => 'some 3',
							),
						),
					),					
				),
				array
				(
					'name' => 'radio',
					'title' => Kohana::lang('fields.radio.title'),
					'description' => Kohana::lang('fields.radio.description'),
					'view' => array
					(
						'form' => array
						(
							'required' => false,
							'type' => 'select',
							'tag' => 'radio',
							'style' => '', 	
							'value' => '',
							'items' => array
							(
								'1' => '1',
								'2' => '2',
								'3' => '3',
							),
						),
						'list' => array
						(
							'filter' => true,
							'filter_items' => array
							(
								'1' => 'some 1',
								'2' => 'some 2',
								'3' => 'some 3',
							),
							'output_related_items' => array
							(
								'1' => 'some 1',
								'2' => 'some 2',
								'3' => 'some 3',
							),
						),
					),					
				),
				array
				(
					'name' => 'file',
					'title' => Kohana::lang('fields.file.title'),
					'description' => Kohana::lang('fields.file.description'),
					'view' => array
					(
						'form' => array
						(
							'required' => false,
							'type' => 'file',
							'tag' => 'input',
							'style' => '', 
						),
					),					
				),
				array
				(
					'name' => 'image',
					'title' => Kohana::lang('fields.image.title'),
					'description' => Kohana::lang('fields.image.description'),
					'view' => array
					(
						'form' => array
						(
							'required' => false,
							'type' => 'image',
							'tag' => 'input',
							'style' => '',							
						),
					),					
				),
			),
			'right' => array
			(),
		),
	),
);