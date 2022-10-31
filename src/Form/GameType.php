<?php

namespace App\Form;

use App\Entity\Team;
use App\Repository\TeamRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;

class GameType extends AbstractType
{
    private $teams;

    public function __construct(TeamRepository $teamRepository) {
        $this->teams = $teamRepository->findAll();
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
            	'disabled' => true,
            	'label' => 'Current name',
            ])
            ->add('team', ChoiceType::class, [
            	'label' => 'Select the team',
            	'choices'  => $this->teams,
                'choice_value' => 'id',
                'choice_label' => 'name',
            ])
        ;
    }
}