<?php

namespace eni\QCMBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class eniQCMBundle extends Bundle {

	public function getParent() {
    	return 'FOSUserBundle';
  	}

}
