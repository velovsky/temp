<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;

class CookieController
{
	public function bakeCookie()
	{
		return new Response(
								'{"response": "New Cookie"}',
								Response::HTTP_OK,
								array('content-type' => 'application/json')
								);
	}
}