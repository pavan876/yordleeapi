<?php
namespace Intuit\V1\Rpc\MFARequestForSite;

use Intuit\V1\Rpc\AddSiteAccount\AddSiteAccountController;
use Intuit\V1\Model\IntuitInterface;

class MFARequestForSiteController extends AddSiteAccountController {

    public function mFARequestForSiteAction() {

    		return $this->addSiteAccountAction();	
    }


    protected function processIntuitRequest( $data ) {

    	    $this->intuitInterface = new IntuitInterface( );
    		$intuitResult = $this->intuitInterface->discoverAndAddAccountsChallenge( $data->customerId, $data->bankId, 
    																					$data->challengeNodeId, $data->challengeSessionId, 
    																					$data->challengeResponses );

    		return $intuitResult;
    }
}
