<?php

declare(strict_types=1);

namespace Adeliom\EasyMediaBundle\Tests\Admin;

use Adeliom\EasyMediaBundle\Admin\Field\EasyMediaField;
use Adeliom\EasyMediaBundle\Form\EasyMediaType;
use PHPUnit\Framework\TestCase;

class EasyMediaFieldTest extends TestCase
{
    public function testNewCreatesFieldWithDefaults(): void
    {
        $field = EasyMediaField::new('media', 'Media');
        $dto = $field->getAsDto();

        self::assertSame('media', $dto->getProperty());
        self::assertSame('Media', $dto->getLabel());
        self::assertSame(EasyMediaType::class, $dto->getFormType());
        self::assertStringContainsString('field-easy-media', $dto->getCssClass());
    }
}
