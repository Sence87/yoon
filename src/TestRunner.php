<?php
namespace YoonMvp;

class TestRunner
{
    public function execute()
    {
        ComplianceValidatorTest::run();
        PackageGeneratorTest::run();
    }
}
