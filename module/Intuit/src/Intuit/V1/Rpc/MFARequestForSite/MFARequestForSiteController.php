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
    		$intuitResult = $this->intuitInterface->discoverAndAddAccountsChallenge( $data->customer_id, $data->bank_id, 
    																					$data->challenge_node_id, $data->challenge_session_id, 
    																					$data->challenge_responses );

    		return $intuitResult;
    }
}
