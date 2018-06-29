<?php
namespace Yoon\YoonMvp;

class TestRunner
{
    public function execute()
    {
        ComplianceValidatorTest::run();
        PackageGeneratorTest::run();
    }
}
