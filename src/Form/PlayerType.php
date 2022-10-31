<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use App\Entity\Player;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use App\Repository\TeamRepository;

class PlayerType extends AbstractType
{
	private $teams;

    public function __construct(TeamRepository $teamRepository) {
        $this->teams = $teamRepository->findAll();
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('position', ChoiceType::class, [
            	'label' => 'Position',
            	'choices'  => Player::POSITIONS,
            	'choice_label' => function($choice, $key, $value) {
                    return $value;
                },
            ])
            ->add('team', ChoiceType::class, [
            	'label' => 'Team',
            	'choices'  => $this->teams,
                'choice_value' => 'id',
                'choice_label' => 'name',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Player::class,
        ]);
    }
}
