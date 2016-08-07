<?php
namespace ZN\ViewObjects;

interface CommonInterface
{
	//----------------------------------------------------------------------------------------------------
	//
	// Yazar      : Ozan UYKUN <ozanbote@windowslive.com> | <ozanbote@gmail.com>
	// Site       : www.zntr.net
	// Lisans     : The MIT License
	// Telif Hakkı: Copyright (c) 2012-2016, zntr.net
	//
	//----------------------------------------------------------------------------------------------------

	//----------------------------------------------------------------------------------------------------
	// Attributes
	//----------------------------------------------------------------------------------------------------
	// 
	// @param array $attributes
	//
	//----------------------------------------------------------------------------------------------------
	public function attributes(Array $attributes) : String;

	//----------------------------------------------------------------------------------------------------
	// Input
	//----------------------------------------------------------------------------------------------------
	//
	// @param string $type
	// @param string $name
	// @param string $value
	// @param array  $attributes
	//
	//----------------------------------------------------------------------------------------------------	
	public function input(String $type = NULL, String $name = NULL, String $value = NULL, Array $_attributes = []) : String;
}