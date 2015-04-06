<?php
namespace Yodlee\V1\Rpc\InstantAccountVerification;

class InstantAccountVerificationControllerFactory
{
    public function __invoke($controllers)
    {
        return new InstantAccountVerificationController();
    }
}
