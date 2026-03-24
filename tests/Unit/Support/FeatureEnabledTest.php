<?php

namespace Tests\Unit\Support;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class FeatureEnabledTest extends TestCase
{
    #[Test]
    public function itReturnsTrueWhenFeatureFlagIsEnabled(): void
    {
        config(['feature_flags.new_blog_publish_flow' => true]);

        $this->assertTrue(feature_enabled('new_blog_publish_flow'));
    }

    #[Test]
    public function itReturnsFalseWhenFeatureFlagIsDisabled(): void
    {
        config(['feature_flags.new_blog_publish_flow' => false]);

        $this->assertFalse(feature_enabled('new_blog_publish_flow'));
    }

    #[Test]
    public function itReturnsFalseWhenFeatureFlagIsUndefined(): void
    {
        $this->assertFalse(feature_enabled('undefined_feature'));
    }

    #[Test]
    public function itUsesDefaultValueWhenFeatureFlagIsUndefined(): void
    {
        $this->assertTrue(feature_enabled('undefined_feature', true));
    }
}
