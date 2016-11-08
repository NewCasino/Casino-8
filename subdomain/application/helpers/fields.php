<?php defined('SYSPATH') OR die('No direct access allowed.');

class fields_Core {
	
	public static $array;
	
	public static function set($filename)
	{		
		self::$array = Kohana::include_fields($filename);
	}
	
	public static function get()
	{
		return self::$array;
	}
	
	public static function get_table()
	{
		return self::$array['table'];
	}
	
	public static function get_type()
	{
		return self::$array['type'];
	}
	
	public static function get_template()
	{
		return self::$array['template'];
	}
	
	public static function get_form_tabs()
	{
		$array = array();
		
		foreach (self::$array['form'] as $key => $rows) 
		{
			$array[$rows['name']] = $rows['title'];
		}
		
		return $array;
	}
	
	public static function get_form_keys()
	{
		$array = array();
		
		foreach (self::$array['form'] as $rows) 
		{		
			foreach ($rows['sidebar'] as $side => $rows)
			{				
				foreach ($rows as $rows)
				{
					$array[] = $rows['name'];
				}
			}			
		}
		
		return $array;
	}
	
	public static function get_form_fields()
	{
		$array = array();
		
		foreach (self::$array['form'] as $rows) 
		{		
			foreach ($rows['sidebar'] as $side => $rows)
			{				
				foreach ($rows as $rows)
				{
					$array[] = $rows;
				}
			}			
		}
		
		return $array;
	}
	
	public static function get_list_tabs()
	{
		$array = array();
		
		foreach (self::$array['list'] as $key => $rows) 
		{			
			$array[$rows['name']] = $rows['title'];
		}
		
		return $array;
	}
	
	public static function get_list_keys()
	{}
	
	public static function get_list_columns()
	{
		$array = array();
		
		foreach (self::$array['list'] as $rows) 
		{		
			if (isset($rows['columns']))
			{
				foreach ($rows['columns'] as $rows) 
				{
					$array[] = $rows;
				}				
			}
		}
		
		return $array;
	}
}