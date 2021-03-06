<?php

namespace Omer\TeamBundle\Form;

use Doctrine\ORM\EntityRepository;
use Omer\CompetitionBundle\Entity\Division;
use Omer\CompetitionBundle\Entity\Problem;
use Omer\CompetitionBundle\Entity\ProblemType;
use Omer\TeamBundle\Entity\ForeignTeam;
use Omer\TravelBundle\Form\TravelInfoType;
use Omer\TeamBundle\Form\CoachType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
class ForeignTeamType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        //@toDo Devide into two types: BaseTeamType and ForeignTeamType
        $builder
            ->add('englishTeamName', TextType::class, [
                'label' => 'label.team.english_team_name',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'label.team.english_team_name'
                ]
            ])
            ->add('memberNumber', TextType::class, [
                'label' => 'label.team.member_number',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'label.team.member_number'
                ]
            ])
            ->add('school', TextType::class, [
                'label' => 'label.team.school',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'label.team.school'
                ]
            ])
            ->add('country', TextType::class, [
                'label' => 'label.team.country',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'label.team.country'
                ]
            ])
            ->add('district', TextType::class, [
                'label' => 'label.team.district',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'label.team.district'
                ]
            ])
            ->add('city', TextType::class, [
                'label' => 'label.team.city',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'label.team.city'
                ]
            ])
            ->add('address', TextType::class, [
                'label' => 'label.team.address',
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'label.team.address'
                ]
            ])
            ->add('problem', EntityType::class, [
                'label' => 'label.team.problem',
                'class' => Problem::class,
                'multiple' => false,
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('p')->orderBy('p.type');
                },
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'label.team.problem'
                ]
            ])
            ->add('division', EntityType::class, [
                'label' => 'label.team.division',
                'class' => Division::class,
                'multiple' => false,
                'query_builder' => function(EntityRepository $er) {
                    return $er->createQueryBuilder('d')->orderBy('d.number');
                },
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'label.team.division'
                ]
            ])
            ->add('paymentCurrency', ChoiceType::class, [
                'label' => 'label.team.payment_currency',
                'choices' => array_flip(ForeignTeam::PAYMENT_CURRENCY),
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'label.team.payment_currency'
                ],
            ])
            ->add('concerns', TextareaType::class, [
                'label' => 'label.team.concerns',
                'required' => false,
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'label.team.concerns'
                ]
            ])
            ->add('travelAttributes', CollectionType::class, [
                'label'         => false,
                'entry_type'    => TravelInfoType::class,
                'allow_add'     => false,
                'allow_delete'  => false,
                'by_reference'  => false,
                'attr'          => [
                    'class' => 'collection_travel'
                ]
            ])
            ->add('coaches',  CollectionType::class, [
                'label'         => false,
                'entry_type'    => CoachType::class,
                'allow_add'     => true,
                'allow_delete'  => true,
                'by_reference'  => false,
                'attr'          => [
                    'class' => 'collection_coaches',
                ]
            ])
            ->add('members',  CollectionType::class, [
                'label'         => false,
                'entry_type'    => TeamMemberType::class,
                'allow_add'     => true,
                'allow_delete'  => true,
                'by_reference'  => false,
                'attr'          => [
                    'class' => 'collection_members',
                ]
            ])
            ->add('otherPeople',  CollectionType::class, [
                'label'         => false,
                'entry_type'    => OtherPeopleType::class,
                'allow_add'     => true,
                'allow_delete'  => true,
                'by_reference'  => false,
                'attr'          => [
                    'class' => 'collection_other',
                ]
            ])
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Omer\TeamBundle\Entity\ForeignTeam',
             'translation_domain' => 'OmerTeamBundle'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'omer_teambundle_team';
    }
}
