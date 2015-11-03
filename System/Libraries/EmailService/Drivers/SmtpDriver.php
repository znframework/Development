<?php
class SmtpDriver
{
	/***********************************************************************************/
	/* SMPT LIBRARY							                   	                       */
	/***********************************************************************************/
	/* Yazar: Ozan UYKUN <ozanbote@windowslive.com> | <ozanbote@gmail.com>
	/* Site: www.zntr.net
	/* Lisans: The MIT License
	/* Telif Hakkı: Copyright (c) 2012-2015, zntr.net
	/*
	/* Sınıf Adı: SmtpDriver
	/* ZN Versiyon: 2.0 Eylül Güncellemesi
	/* Tanımlanma: Mixed
	/* Dahil Edilme: Gerektirmez
	/* Erişim: Email kütüphanesi tarafından kullanılmaktadır.
	/* Not: Büyük-küçük harf duyarlılığı yoktur.
	/***********************************************************************************/
	
	/* 
	 * Satır sonu karakter bilgisini
	 * tutması için oluşturulmuştur.
	 *
	 * @var string \r\n
	 */
	protected $crlf 	= "\r\n";
	
	/* 
	 * Soket bağlantı bilgisini
	 * tutmak için oluşturulmuştur.
	 * 
	 * @var object
	 */ 
	protected $connect;

	/******************************************************************************************
	* CONSTRUCT                                                                               *
	*******************************************************************************************
	| Genel Kullanım: SMTP gönderimi yapılandırılıyor.										  |
	
	  @param  $to
	  @return object
	|          																				  |
	******************************************************************************************/
	public function __construct($to = '', $subject = '', $body = '', $headers = '', $settings = array())
	{
		$this->to 		  = $to;
		$this->subject    = $subject;
		$this->body 	  = $body;
		$this->header	  = $headers;
		$this->host		  = isset($settings['host'])      ? $settings['host']   	: '';
		$this->user   	  = isset($settings['user'])      ? $settings['user'] 		: '';
		$this->password   = isset($settings['password'])  ? $settings['password'] 	: '';
		$this->from 	  = isset($settings['from'])      ? $settings['from'] 		: '';
		$this->port       = isset($settings['port'])      ? $settings['port'] 		: 587;
		$this->encoding	  = isset($settings['encoding'])  ? $settings['encoding'] 	: '';
		$this->timeout	  = isset($settings['timeout'])   ? $settings['timeout'] 	: '';
		$this->cc		  = isset($settings['cc'])        ? $settings['cc'] 		: '';
		$this->bcc		  = isset($settings['bcc'])       ? $settings['bcc'] 		: '';	
		$this->auth		  = isset($settings['authLogin']) ? $settings['authLogin'] 	: '';
		$this->encode     = isset($settings['encode'])    ? $settings['encode'] 	: '';
		$this->keepAlive  = isset($settings['keepAlive']) ? $settings['keepAlive'] 	: '';
		$this->dsn		  = isset($settings['dsn'])       ? $settings['dsn'] 		: '';
		$this->tos		  = isset($settings['tos'])       ? $settings['tos'] 		: array();
	}
	
	public function sendEmail()
	{
		$connect = $this->connect();
		$sending = $this->sending();
		
		return $sending;
	}
	
	protected function connect()
	{
		if( is_resource($this->connect) )
		{
			return true;
		}
	
		$ssl = $this->encode === 'ssl' 
			 ? 'ssl://' 
			 : '';
		
		$this->connect = fsockopen($ssl.$this->host, $this->port, $errno, $errstr, $this->timeout);
		
		if( ! is_resource($this->connect) )
		{
			return Error::set(lang('Email', 'smtpError', $errno.' '.$errstr));
		}
		
		stream_set_timeout($this->connect, $this->timeout);
		Error::set($this->getData());
		
		if( $this->encode === 'tls' )
		{
			$this->setCommand('hello');
			$this->setCommand('starttls');
			
			$crypto = stream_socket_enable_crypto($this->connect, true, STREAM_CRYPTO_METHOD_TLS_CLIENT);
			
			if( $crypto !== true )
			{
				return Error::set(lang('Email', 'smtpError', $this->getData()));
			}
		}
		
		return $this->setCommand('hello');
	}
	
	protected function sending()
	{
		if( empty($this->host) )
		{
			return Error::set(lang('Error', 'noHostName'));
		}
		
		if( ! $this->connect() || ! $this->authLogin() )
		{
			return false;
		}
		
		$this->setCommand('from', $this->from);
		
		if( ! empty($this->tos) ) 
		{
			foreach( $this->tos as $key => $val )
			{ 
				$this->setCommand('to', $key);
			}
		}
		
		if( ! empty($this->cc) )
		{
			foreach( $this->cc as $key => $val )
			{
				$this->setCommand('to', $key);
			}
		}
		
		if( ! empty($this->bcc) )
		{
			foreach( $this->bcc as $key => $val )
			{
				$this->setCommand('to', $key);
			}
		}
		
		$this->setCommand('data');
		
		$this->setData($this->header.preg_replace('/^\./m', '..$1', $this->body));
		
		$this->setData('.');
		
		$reply = $this->getData();
		
		Error::set($reply);
		
		if( strpos($reply, '250') !== 0 )
		{
			return Error::set(lang('Email', 'smtpError', $reply));
		}
		
		if( $this->keepAlive )
		{
			$this->setCommand('reset');
		}
		else
		{
			$this->setCommand('quit');
		}
		
		return true;
	}
	
	protected function authLogin()
	{
		if( ! $this->auth )
		{
			return true;
		}
		
		if( $this->user === '' && $this->password === '' )
		{
			return Error::set(lang('Email', 'noSmtpUnpassword'));
		}
		
		$this->setData('AUTH LOGIN');
		$reply = $this->getData();
		
		if( strpos($reply, '503') === 0 )
		{
			return true;
		}
		elseif( strpos($reply, '334') !== 0 )
		{
			return Error::set(lang('Email', 'failedSmtpLogin', $reply));
		}
		
		$this->setData(base64_encode($this->user));	
		$reply = $this->getData();
		
		if( strpos($reply, '334') !== 0 )
		{
			return Error::set(lang('Email', 'smtpAuthUserName', $reply));
		}
		
		$this->setData(base64_encode($this->password));
		$reply = $this->getData();
		
		if( strpos($reply, '235') !== 0 )
		{
			return Error::set(lang('Email', 'smtpAuthPassword', $reply));
		}
		
		return true;
	}
	
	protected function setCommand($cmd, $data = '')
	{
		
		switch( $cmd )
		{
			case 'hello' :
				if( $this->auth || $this->encoding === '8bit' )
				{
					$this->setData('EHLO '.$this->hostname() );
				}
				else
				{
					$this->setData('HELO '.$this->hostname());
				}
				
				$resp = 250;
			break;
			
			case 'starttls'	:
				$this->setData('STARTTLS');
				$resp = 220;
			break;
			
			case 'from' :
				$this->setData('MAIL FROM:<'.$data.'>');
				$resp = 250;
			break;
			
			case 'to' :
				if( $this->dsn )
				{
					$this->setData('RCPT TO:<'.$data.'> NOTIFY=SUCCESS,DELAY,FAILURE ORCPT=rfc822;'.$data);
				}
				else
				{
					$this->setData('RCPT TO:<'.$data.'>');
				}
				$resp = 250;
			break;
			
			case 'data'	:
				$this->setData('DATA');
				$resp = 354;
			break;
			
			case 'reset':
				$this->setData('RSET');
				$resp = 250;
			break;
			
			case 'quit'	:
				$this->setData('QUIT');
				$resp = 221;
			break;
		}
		
		$reply = $this->getData();
		
		Error::set($cmd.': '.$reply);
		
		if( (int)substr($reply, 0, 3) !== $resp )
		{
			return Error::set(lang('Email', 'smtpError', $reply));
		}
		
		if( $cmd === 'quit' )
		{
			fclose($this->connect);
		}
		
		return true;
	}
	
	protected function setData($data)
	{
		$data .= $this->crlf;
		
		for( $written = $timestamp = 0, $length = strlen($data); $written < $length; $written += $result )
		{
			$result = fwrite($this->connect, substr($data, $written));
			
			if( $result === false )
			{
				break;
			}
		}
		if( $result === false )
		{
			return Error::set(lang('Email', 'smtpDataFailure', $data));
		}
		
		return true;
	}
	
	public function getData()
	{
		$data = '';
		
		while( $str = fgets($this->connect, 512) )
		{
			$data .= $str;
			
			if( $str[3] === ' ' )
			{
				break;
			}
		}
		
		return $data;
	}
	
	protected function hostname()
	{
		if( isset($_SERVER['SERVER_NAME']) )
		{
			return $_SERVER['SERVER_NAME'];
		}
		
		return isset($_SERVER['SERVER_ADDR']) 
			   ? '['.$_SERVER['SERVER_ADDR'].']' 
			   : '[127.0.0.1]';
	}
	
	public function send($to, $subject, $message, $headers, $settings)
	{
		$smtp = new self($to, $subject, $message, $headers, $settings);
		
		return $smtp->sendEmail();
	}   
}