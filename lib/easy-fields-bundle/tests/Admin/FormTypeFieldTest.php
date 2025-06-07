<?php

declare(strict_types=1);

namespace Adeliom\EasyFieldsBundle\Tests\Admin;

use Adeliom\EasyFieldsBundle\Admin\Field\FormTypeField;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class FormTypeFieldTest extends TestCase
{
    public function testFormType(): void
    {
        $field = FormTypeField::new('email', 'Email', EmailType::class);
        $this->assertSame(EmailType::class, $field->getAsDto()->getFormType());
    }
}
