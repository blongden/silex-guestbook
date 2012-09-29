<?php
namespace Blongden\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;

class GuestbookType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', 'text', [
            'constraints' => [
                new Assert\MinLength(3)
            ]
        ]);

        $builder->add('message', 'textarea', [
            'constraints' => [
                new Assert\NotBlank(),
                new Assert\MaxLength(140)
            ]
        ]);
        
    }

    public function getName()
    {
        return 'guestbook';
    }
}
