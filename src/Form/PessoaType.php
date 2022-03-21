<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class PessoaType extends AbstractType{
    public function buildForm(FormBuilderInterface $builder, array $options)
        {
            $builder
            ->add('nome',TextType::class,
            ['label' => 'nome da pessoa'])
            
            ->add('cpf',TextType::class,
            ['label'=> 'cpf da pessoa'])

            ->add('Salvar',SubmitType::class);
            
        }
}
