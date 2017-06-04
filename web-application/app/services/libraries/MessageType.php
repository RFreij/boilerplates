<?php
/**
 *
 * Created by PhpStorm.
 * User: Roy Freij - Netcreaties
 * Date: 22-5-2017
 * Time: 13:27
 */

namespace app\services\libraries;

class MessageType {

	const __default = self::Notification;
	
	const Error = 0;
	const Success = 1;
	const Notification = 2;
	
}